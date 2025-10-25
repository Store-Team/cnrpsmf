<?php

namespace App\Controller\api;

use App\Entity\InspectionConvoi;
use App\Repository\InspectionConvoiRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/inspection/convoi')]
final class ApiInspectionConvoiController extends AbstractController
{
    public function __construct(private SerializerInterface $serializer)
    {
    }

    #[Route(name: 'app_inspection_convoi_index', methods: ['GET'])]
    public function index(InspectionConvoiRepository $inspectionConvoiRepository): JsonResponse
    {
        $inspections = $inspectionConvoiRepository->findAll();
        
        return $this->json([
            'success' => true,
            'data' => $inspections
        ], context: ['groups' => ['api_inspectionconvoi']]);
    }

    #[Route('/new', name: 'app_inspection_convoi_new', methods: ['POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        try {
            $inspection = $this->serializer->deserialize(
                $request->getContent(),
                InspectionConvoi::class,
                'json',
                ['groups' => ['api_inspectionconvoi']]
            );

            $entityManager->persist($inspection);
            $entityManager->flush();

            return $this->json([
                'success' => true,
                'message' => 'Inspection Convoi créée avec succès',
                'data' => $inspection
            ], JsonResponse::HTTP_CREATED, context: ['groups' => ['api_inspectionconvoi']]);
            
        } catch (\Exception $e) {
            return $this->json([
                'success' => false,
                'message' => 'Erreur lors de la création: ' . $e->getMessage()
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/{matricule}', name: 'app_inspection_convoi_show', methods: ['GET'])]
    public function show(InspectionConvoi $inspection): JsonResponse
    {
        return $this->json([
            'success' => true,
            'data' => $inspection
        ], context: ['groups' => ['api_inspectionconvoi']]);
    }

    #[Route('/{matricule}/edit', name: 'app_inspection_convoi_edit', methods: ['PUT', 'PATCH'])]
    public function edit(Request $request, InspectionConvoi $inspection, EntityManagerInterface $entityManager): JsonResponse
    {
        try {
            $this->serializer->deserialize(
                $request->getContent(),
                InspectionConvoi::class,
                'json',
                ['object_to_populate' => $inspection, 'groups' => ['api_inspectionconvoi']]
            );

            $entityManager->flush();

            return $this->json([
                'success' => true,
                'message' => 'Inspection Convoi mise à jour avec succès',
                'data' => $inspection
            ], context: ['groups' => ['api_inspectionconvoi']]);
            
        } catch (\Exception $e) {
            return $this->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour: ' . $e->getMessage()
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/{matricule}', name: 'app_inspection_convoi_delete', methods: ['DELETE'])]
    public function delete(Request $request, InspectionConvoi $inspection, EntityManagerInterface $entityManager): JsonResponse
    {
        try {
            $entityManager->remove($inspection);
            $entityManager->flush();
            
            return $this->json([
                'success' => true,
                'message' => 'Inspection Convoi supprimée avec succès'
            ]);
            
        } catch (\Exception $e) {
            return $this->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression: ' . $e->getMessage()
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

#[Route('/api/inspection/convoi')]
final class ApiInspectionConvoiController extends AbstractController
{
    #[Route(name: 'app_inspection_convoi_index', methods: ['GET'])]
    public function index(InspectionConvoiRepository $inspectionConvoiRepository): JsonResponse
    {
        $inspections = $inspectionConvoiRepository->findAll();
        
        $data = [];
        foreach ($inspections as $item) {
            $data[] = [
                'id' => $item->getId(),
                'matricule' => $item->getMatricule(),
                'lieu_emission' => $item->getLieuEmission(),
                'date_emission' => $item->getDateEmission()?->format('Y-m-d'),
                'r_type' => $item->getRType(),
                'r_nationalite' => $item->getRNationalite(),
                'r_addresse' => $item->getRAddresse(),
                'r_telephone' => $item->getRTelephone(),
                'v_matricule' => $item->getVMatricule(),
                'v_marque' => $item->getVMarque(),
                'v_type' => $item->getVType(),
                'type_charge' => $item->getTypeCharge(),
                'tonnage_kg' => $item->getTonnageKg(),
                'longueur' => $item->getLongueur(),
                'v_largeur' => $item->getVLargeur(),
                'hauteur' => $item->getHauteur(),
                'arrimage' => $item->isArrimage(),
                'centrage' => $item->isCentrage(),
                'signalisation' => $item->isSignalisation(),
                'p_depart' => $item->getPDepart(),
                'p_arrivee' => $item->getPArrivee(),
                'h_depart' => $item->getHDepart()?->format('H:i:s'),
                'h_arrivee' => $item->getHArrivee()?->format('H:i:s'),
                'raison_arret' => $item->getRaisonArret(),
                'observations_generales' => $item->getObservationsGenerales(),
                'approuve' => $item->isApprouve(),
                'inspecteur_nom' => $item->getInspecteurNom(),
                'equipe1' => $item->getEquipe1(),
                'equipe1_contact' => $item->getEquipe1Contact(),
                'equipe2' => $item->getEquipe2(),
                'equipe2_contact' => $item->getEquipe2Contact(),
                'equipe3' => $item->getEquipe3(),
                'equipe3_contact' => $item->getEuipe3Contact(),
            ];
        }
        
        return $this->json([
            'success' => true,
            'data' => $data
        ]);
    }

    #[Route('/new', name: 'app_inspection_convoi_new', methods: ['POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        try {
            $data = json_decode($request->getContent(), true);
            
            if (!$data) {
                return $this->json([
                    'success' => false,
                    'message' => 'Données JSON invalides'
                ], JsonResponse::HTTP_BAD_REQUEST);
            }
            
            $inspection = new InspectionConvoi();
            // Note: Assuming setMatricule exists, if not it would need to be added to the entity
            if (method_exists($inspection, 'setMatricule')) {
                $inspection->setMatricule($data['matricule'] ?? '');
            }
            
            $inspection->setLieuEmission($data['lieu_emission'] ?? '');
            
            if (isset($data['date_emission'])) {
                $inspection->setDateEmission(new \DateTime($data['date_emission']));
            }
            
            $inspection->setRType($data['r_type'] ?? '');
            $inspection->setRNationalite($data['r_nationalite'] ?? '');
            $inspection->setRAddresse($data['r_addresse'] ?? '');
            $inspection->setRTelephone($data['r_telephone'] ?? '');
            $inspection->setVMatricule($data['v_matricule'] ?? '');
            $inspection->setVMarque($data['v_marque'] ?? '');
            $inspection->setVType($data['v_type'] ?? '');
            $inspection->setTypeCharge($data['type_charge'] ?? '');
            $inspection->setTonnageKg($data['tonnage_kg'] ?? '');
            $inspection->setLongueur($data['longueur'] ?? '');
            $inspection->setVLargeur($data['v_largeur'] ?? '');
            $inspection->setHauteur($data['hauteur'] ?? '');
            $inspection->setArrimage($data['arrimage'] ?? false);
            $inspection->setCentrage($data['centrage'] ?? false);
            $inspection->setSignalisation($data['signalisation'] ?? false);
            $inspection->setPDepart($data['p_depart'] ?? '');
            $inspection->setPArrivee($data['p_arrivee'] ?? '');
            
            if (isset($data['h_depart'])) {
                $inspection->setHDepart(new \DateTime($data['h_depart']));
            }
            if (isset($data['h_arrivee'])) {
                $inspection->setHArrivee(new \DateTime($data['h_arrivee']));
            }
            
            $inspection->setRaisonArret($data['raison_arret'] ?? '');
            $inspection->setObservationsGenerales($data['observations_generales'] ?? '');
            $inspection->setApprouve($data['approuve'] ?? false);
            $inspection->setInspecteurNom($data['inspecteur_nom'] ?? '');
            $inspection->setEquipe1($data['equipe1'] ?? '');
            $inspection->setEquipe1Contact($data['equipe1_contact'] ?? '');
            $inspection->setEquipe2($data['equipe2'] ?? '');
            $inspection->setEquipe2Contact($data['equipe2_contact'] ?? '');
            $inspection->setEquipe3($data['equipe3'] ?? '');
            $inspection->setEuipe3Contact($data['equipe3_contact'] ?? '');

            $entityManager->persist($inspection);
            $entityManager->flush();

            return $this->json([
                'success' => true,
                'message' => 'Inspection Convoi créée avec succès',
                'data' => [
                    'id' => $inspection->getId(),
                    'matricule' => $inspection->getMatricule()
                ]
            ], JsonResponse::HTTP_CREATED);
            
        } catch (\Exception $e) {
            return $this->json([
                'success' => false,
                'message' => 'Erreur lors de la création: ' . $e->getMessage()
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/{matricule}', name: 'app_inspection_convoi_show', methods: ['GET'])]
    public function show(InspectionConvoi $inspection): JsonResponse
    {
        return $this->json([
            'success' => true,
            'data' => [
                'id' => $inspection->getId(),
                'matricule' => $inspection->getMatricule(),
                'lieu_emission' => $inspection->getLieuEmission(),
                'date_emission' => $inspection->getDateEmission()?->format('Y-m-d'),
                'r_type' => $inspection->getRType(),
                'r_nationalite' => $inspection->getRNationalite(),
                'r_addresse' => $inspection->getRAddresse(),
                'r_telephone' => $inspection->getRTelephone(),
                'v_matricule' => $inspection->getVMatricule(),
                'v_marque' => $inspection->getVMarque(),
                'v_type' => $inspection->getVType(),
                'type_charge' => $inspection->getTypeCharge(),
                'tonnage_kg' => $inspection->getTonnageKg(),
                'longueur' => $inspection->getLongueur(),
                'v_largeur' => $inspection->getVLargeur(),
                'hauteur' => $inspection->getHauteur(),
                'arrimage' => $inspection->isArrimage(),
                'centrage' => $inspection->isCentrage(),
                'signalisation' => $inspection->isSignalisation(),
                'p_depart' => $inspection->getPDepart(),
                'p_arrivee' => $inspection->getPArrivee(),
                'h_depart' => $inspection->getHDepart()?->format('H:i:s'),
                'h_arrivee' => $inspection->getHArrivee()?->format('H:i:s'),
                'raison_arret' => $inspection->getRaisonArret(),
                'observations_generales' => $inspection->getObservationsGenerales(),
                'approuve' => $inspection->isApprouve(),
                'inspecteur_nom' => $inspection->getInspecteurNom(),
                'equipe1' => $inspection->getEquipe1(),
                'equipe1_contact' => $inspection->getEquipe1Contact(),
                'equipe2' => $inspection->getEquipe2(),
                'equipe2_contact' => $inspection->getEquipe2Contact(),
                'equipe3' => $inspection->getEquipe3(),
                'equipe3_contact' => $inspection->getEuipe3Contact(),
            ]
        ]);
    }

    #[Route('/{matricule}/edit', name: 'app_inspection_convoi_edit', methods: ['PUT', 'PATCH'])]
    public function edit(Request $request, InspectionConvoi $inspection, EntityManagerInterface $entityManager): JsonResponse
    {
        try {
            $data = json_decode($request->getContent(), true);
            
            if (!$data) {
                return $this->json([
                    'success' => false,
                    'message' => 'Données JSON invalides'
                ], JsonResponse::HTTP_BAD_REQUEST);
            }
            
            if (isset($data['lieu_emission'])) {
                $inspection->setLieuEmission($data['lieu_emission']);
            }
            if (isset($data['date_emission'])) {
                $inspection->setDateEmission(new \DateTime($data['date_emission']));
            }
            if (isset($data['r_type'])) {
                $inspection->setRType($data['r_type']);
            }
            if (isset($data['r_nationalite'])) {
                $inspection->setRNationalite($data['r_nationalite']);
            }
            if (isset($data['r_addresse'])) {
                $inspection->setRAddresse($data['r_addresse']);
            }
            if (isset($data['r_telephone'])) {
                $inspection->setRTelephone($data['r_telephone']);
            }
            if (isset($data['v_matricule'])) {
                $inspection->setVMatricule($data['v_matricule']);
            }
            if (isset($data['v_marque'])) {
                $inspection->setVMarque($data['v_marque']);
            }
            if (isset($data['v_type'])) {
                $inspection->setVType($data['v_type']);
            }
            if (isset($data['type_charge'])) {
                $inspection->setTypeCharge($data['type_charge']);
            }
            if (isset($data['tonnage_kg'])) {
                $inspection->setTonnageKg($data['tonnage_kg']);
            }
            if (isset($data['longueur'])) {
                $inspection->setLongueur($data['longueur']);
            }
            if (isset($data['v_largeur'])) {
                $inspection->setVLargeur($data['v_largeur']);
            }
            if (isset($data['hauteur'])) {
                $inspection->setHauteur($data['hauteur']);
            }
            if (isset($data['arrimage'])) {
                $inspection->setArrimage($data['arrimage']);
            }
            if (isset($data['centrage'])) {
                $inspection->setCentrage($data['centrage']);
            }
            if (isset($data['signalisation'])) {
                $inspection->setSignalisation($data['signalisation']);
            }
            if (isset($data['p_depart'])) {
                $inspection->setPDepart($data['p_depart']);
            }
            if (isset($data['p_arrivee'])) {
                $inspection->setPArrivee($data['p_arrivee']);
            }
            if (isset($data['h_depart'])) {
                $inspection->setHDepart(new \DateTime($data['h_depart']));
            }
            if (isset($data['h_arrivee'])) {
                $inspection->setHArrivee(new \DateTime($data['h_arrivee']));
            }
            if (isset($data['raison_arret'])) {
                $inspection->setRaisonArret($data['raison_arret']);
            }
            if (isset($data['observations_generales'])) {
                $inspection->setObservationsGenerales($data['observations_generales']);
            }
            if (isset($data['approuve'])) {
                $inspection->setApprouve($data['approuve']);
            }
            if (isset($data['inspecteur_nom'])) {
                $inspection->setInspecteurNom($data['inspecteur_nom']);
            }
            if (isset($data['equipe1'])) {
                $inspection->setEquipe1($data['equipe1']);
            }
            if (isset($data['equipe1_contact'])) {
                $inspection->setEquipe1Contact($data['equipe1_contact']);
            }
            if (isset($data['equipe2'])) {
                $inspection->setEquipe2($data['equipe2']);
            }
            if (isset($data['equipe2_contact'])) {
                $inspection->setEquipe2Contact($data['equipe2_contact']);
            }
            if (isset($data['equipe3'])) {
                $inspection->setEquipe3($data['equipe3']);
            }
            if (isset($data['equipe3_contact'])) {
                $inspection->setEuipe3Contact($data['equipe3_contact']);
            }

            $entityManager->flush();

            return $this->json([
                'success' => true,
                'message' => 'Inspection Convoi mise à jour avec succès',
                'data' => [
                    'id' => $inspection->getId(),
                    'matricule' => $inspection->getMatricule()
                ]
            ]);
            
        } catch (\Exception $e) {
            return $this->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour: ' . $e->getMessage()
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/{matricule}', name: 'app_inspection_convoi_delete', methods: ['DELETE'])]
    public function delete(Request $request, InspectionConvoi $inspection, EntityManagerInterface $entityManager): JsonResponse
    {
        try {
            $entityManager->remove($inspection);
            $entityManager->flush();
            
            return $this->json([
                'success' => true,
                'message' => 'Inspection Convoi supprimée avec succès'
            ]);
            
        } catch (\Exception $e) {
            return $this->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression: ' . $e->getMessage()
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

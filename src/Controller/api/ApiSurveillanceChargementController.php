<?php

namespace App\Controller\api;

use App\Entity\SurveillanceChargement;
use App\Repository\SurveillanceChargementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/surveillance/chargement')]
final class ApiSurveillanceChargementController extends AbstractController
{
    #[Route(name: 'app_surveillance_chargement_index', methods: ['GET'])]
    public function index(SurveillanceChargementRepository $surveillanceChargementRepository): JsonResponse
    {
        $surveillances = $surveillanceChargementRepository->findAll();
        
        $data = [];
        foreach ($surveillances as $item) {
            $data[] = [
                'id' => $item->getId(),
                'matricule' => $item->getMatricule(),
                'numero_recu' => $item->getNumeroRecu(),
                'lieu_emission' => $item->getLieuEmission(),
                'date_emission' => $item->getDateEmission()?->format('Y-m-d'),
                'r_organisation' => $item->getROrganisation(),
                'r_nationalite' => $item->getRNationalite(),
                'r_addresse' => $item->getRAddresse(),
                'r_telephone' => $item->getRTelephone(),
                'v_matricule' => $item->getVMatricule(),
                'type_charge' => $item->getTypeCharge(),
                'tonnage_kg' => $item->getTonnageKg(),
                'signalisation' => $item->isSignalisation(),
                'couverture' => $item->isCouverture(),
                'p_depart' => $item->getPDepart(),
                'p_arrivee' => $item->getPArrivee(),
                'h_depart' => $item->getHDepart()?->format('H:i:s'),
                'h_arrivee' => $item->getHArrivee()?->format('H:i:s'),
                'nom_inspecteur' => $item->getNomInspecteur(),
                'approuvee' => $item->isApprouvee(),
            ];
        }
        
        return $this->json([
            'success' => true,
            'data' => $data
        ]);
    }

    #[Route('/new', name: 'app_surveillance_chargement_new', methods: ['POST'])]
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
            
            $surveillance = new SurveillanceChargement();
            $surveillance->setMatricule($data['matricule'] ?? '');
            $surveillance->setNumeroRecu($data['numero_recu'] ?? '');
            $surveillance->setLieuEmission($data['lieu_emission'] ?? '');
            
            if (isset($data['date_emission'])) {
                $surveillance->setDateEmission(new \DateTime($data['date_emission']));
            }
            
            $surveillance->setROrganisation($data['r_organisation'] ?? '');
            $surveillance->setRNationalite($data['r_nationalite'] ?? '');
            $surveillance->setRAddresse($data['r_addresse'] ?? '');
            $surveillance->setRTelephone($data['r_telephone'] ?? '');
            $surveillance->setVMatricule($data['v_matricule'] ?? '');
            $surveillance->setTypeCharge($data['type_charge'] ?? '');
            $surveillance->setTonnageKg($data['tonnage_kg'] ?? '');
            $surveillance->setSignalisation($data['signalisation'] ?? false);
            $surveillance->setCouverture($data['couverture'] ?? false);
            $surveillance->setPDepart($data['p_depart'] ?? '');
            $surveillance->setPArrivee($data['p_arrivee'] ?? '');
            
            if (isset($data['h_depart'])) {
                $surveillance->setHDepart(new \DateTime($data['h_depart']));
            }
            if (isset($data['h_arrivee'])) {
                $surveillance->setHArrivee(new \DateTime($data['h_arrivee']));
            }
            
            $surveillance->setNomInspecteur($data['nom_inspecteur'] ?? '');
            $surveillance->setApprouvee($data['approuvee'] ?? false);

            $entityManager->persist($surveillance);
            $entityManager->flush();

            return $this->json([
                'success' => true,
                'message' => 'Surveillance Chargement créée avec succès',
                'data' => [
                    'id' => $surveillance->getId(),
                    'matricule' => $surveillance->getMatricule()
                ]
            ], JsonResponse::HTTP_CREATED);
            
        } catch (\Exception $e) {
            return $this->json([
                'success' => false,
                'message' => 'Erreur lors de la création: ' . $e->getMessage()
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/{matricule}', name: 'app_surveillance_chargement_show', methods: ['GET'])]
    public function show(SurveillanceChargement $surveillance): JsonResponse
    {
        return $this->json([
            'success' => true,
            'data' => [
                'id' => $surveillance->getId(),
                'matricule' => $surveillance->getMatricule(),
                'numero_recu' => $surveillance->getNumeroRecu(),
                'lieu_emission' => $surveillance->getLieuEmission(),
                'date_emission' => $surveillance->getDateEmission()?->format('Y-m-d'),
                'r_organisation' => $surveillance->getROrganisation(),
                'r_nationalite' => $surveillance->getRNationalite(),
                'r_addresse' => $surveillance->getRAddresse(),
                'r_telephone' => $surveillance->getRTelephone(),
                'v_matricule' => $surveillance->getVMatricule(),
                'type_charge' => $surveillance->getTypeCharge(),
                'tonnage_kg' => $surveillance->getTonnageKg(),
                'signalisation' => $surveillance->isSignalisation(),
                'couverture' => $surveillance->isCouverture(),
                'p_depart' => $surveillance->getPDepart(),
                'p_arrivee' => $surveillance->getPArrivee(),
                'h_depart' => $surveillance->getHDepart()?->format('H:i:s'),
                'h_arrivee' => $surveillance->getHArrivee()?->format('H:i:s'),
                'nom_inspecteur' => $surveillance->getNomInspecteur(),
                'approuvee' => $surveillance->isApprouvee(),
            ]
        ]);
    }

    #[Route('/{matricule}/edit', name: 'app_surveillance_chargement_edit', methods: ['PUT', 'PATCH'])]
    public function edit(Request $request, SurveillanceChargement $surveillance, EntityManagerInterface $entityManager): JsonResponse
    {
        try {
            $data = json_decode($request->getContent(), true);
            
            if (!$data) {
                return $this->json([
                    'success' => false,
                    'message' => 'Données JSON invalides'
                ], JsonResponse::HTTP_BAD_REQUEST);
            }
            
            if (isset($data['numero_recu'])) {
                $surveillance->setNumeroRecu($data['numero_recu']);
            }
            if (isset($data['lieu_emission'])) {
                $surveillance->setLieuEmission($data['lieu_emission']);
            }
            if (isset($data['date_emission'])) {
                $surveillance->setDateEmission(new \DateTime($data['date_emission']));
            }
            if (isset($data['r_organisation'])) {
                $surveillance->setROrganisation($data['r_organisation']);
            }
            if (isset($data['r_nationalite'])) {
                $surveillance->setRNationalite($data['r_nationalite']);
            }
            if (isset($data['r_addresse'])) {
                $surveillance->setRAddresse($data['r_addresse']);
            }
            if (isset($data['r_telephone'])) {
                $surveillance->setRTelephone($data['r_telephone']);
            }
            if (isset($data['v_matricule'])) {
                $surveillance->setVMatricule($data['v_matricule']);
            }
            if (isset($data['type_charge'])) {
                $surveillance->setTypeCharge($data['type_charge']);
            }
            if (isset($data['tonnage_kg'])) {
                $surveillance->setTonnageKg($data['tonnage_kg']);
            }
            if (isset($data['signalisation'])) {
                $surveillance->setSignalisation($data['signalisation']);
            }
            if (isset($data['couverture'])) {
                $surveillance->setCouverture($data['couverture']);
            }
            if (isset($data['p_depart'])) {
                $surveillance->setPDepart($data['p_depart']);
            }
            if (isset($data['p_arrivee'])) {
                $surveillance->setPArrivee($data['p_arrivee']);
            }
            if (isset($data['h_depart'])) {
                $surveillance->setHDepart(new \DateTime($data['h_depart']));
            }
            if (isset($data['h_arrivee'])) {
                $surveillance->setHArrivee(new \DateTime($data['h_arrivee']));
            }
            if (isset($data['nom_inspecteur'])) {
                $surveillance->setNomInspecteur($data['nom_inspecteur']);
            }
            if (isset($data['approuvee'])) {
                $surveillance->setApprouvee($data['approuvee']);
            }

            $entityManager->flush();

            return $this->json([
                'success' => true,
                'message' => 'Surveillance Chargement mise à jour avec succès',
                'data' => [
                    'id' => $surveillance->getId(),
                    'matricule' => $surveillance->getMatricule()
                ]
            ]);
            
        } catch (\Exception $e) {
            return $this->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour: ' . $e->getMessage()
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/{matricule}', name: 'app_surveillance_chargement_delete', methods: ['DELETE'])]
    public function delete(Request $request, SurveillanceChargement $surveillance, EntityManagerInterface $entityManager): JsonResponse
    {
        try {
            $entityManager->remove($surveillance);
            $entityManager->flush();
            
            return $this->json([
                'success' => true,
                'message' => 'Surveillance Chargement supprimée avec succès'
            ]);
            
        } catch (\Exception $e) {
            return $this->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression: ' . $e->getMessage()
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

<?php

namespace App\Controller\api;

use App\Entity\AutorisationMateriauxConstruction;
use App\Repository\AutorisationMateriauxConstructionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/autorisation/materiauxconstruction')]
final class ApiAutorisationMateriauxConstructionController extends AbstractController
{
    #[Route(name: 'app_autorisation_materiaux_construction_index', methods: ['GET'])]
    public function index(AutorisationMateriauxConstructionRepository $autorisationMateriauxConstructionRepository): JsonResponse
    {
        $autorisations = $autorisationMateriauxConstructionRepository->findAll();
        
        $data = [];
        foreach ($autorisations as $item) {
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
                'r_securite' => $item->getRSecurite(),
                'heure_circulation' => $item->getHeureCirculation(),
                'p_depart' => $item->getPDepart(),
                'p_arrivee' => $item->getPArrivee(),
                'h_depart' => $item->getHDepart()?->format('H:i:s'),
                'h_arrivee' => $item->getHArrivee()?->format('H:i:s'),
                'arrimage' => $item->isArrimage(),
                'centrage' => $item->isCentrage(),
                'signalisation' => $item->isSignalisation(),
                'charge_technique' => $item->getChargeTechnique(),
            ];
        }
        
        return $this->json([
            'success' => true,
            'data' => $data
        ]);
    }

    #[Route('/new', name: 'app_autorisation_materiaux_construction_new', methods: ['POST'])]
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
            
            $autorisation = new AutorisationMateriauxConstruction();
            // Note: Assuming matricule setter exists, if not it would need to be added to the entity
            if (method_exists($autorisation, 'setMatricule')) {
                $autorisation->setMatricule($data['matricule'] ?? '');
            }
            $autorisation->setLieuEmission($data['lieu_emission'] ?? '');
            
            if (isset($data['date_emission'])) {
                $autorisation->setDateEmission(new \DateTime($data['date_emission']));
            }
            
            $autorisation->setRType($data['r_type'] ?? '');
            $autorisation->setRNationalite($data['r_nationalite'] ?? '');
            $autorisation->setRAddresse($data['r_addresse'] ?? '');
            $autorisation->setRTelephone($data['r_telephone'] ?? '');
            $autorisation->setVMatricule($data['v_matricule'] ?? '');
            $autorisation->setVMarque($data['v_marque'] ?? '');
            $autorisation->setVType($data['v_type'] ?? '');
            $autorisation->setTypeCharge($data['type_charge'] ?? '');
            $autorisation->setTonnageKg($data['tonnage_kg'] ?? '');
            $autorisation->setRSecurite($data['r_securite'] ?? '');
            $autorisation->setHeureCirculation($data['heure_circulation'] ?? '');
            $autorisation->setPDepart($data['p_depart'] ?? '');
            $autorisation->setPArrivee($data['p_arrivee'] ?? '');
            
            if (isset($data['h_depart'])) {
                $autorisation->setHDepart(new \DateTime($data['h_depart']));
            }
            if (isset($data['h_arrivee'])) {
                $autorisation->setHArrivee(new \DateTime($data['h_arrivee']));
            }
            
            $autorisation->setArrimage($data['arrimage'] ?? false);
            $autorisation->setCentrage($data['centrage'] ?? false);
            $autorisation->setSignalisation($data['signalisation'] ?? false);
            $autorisation->setChargeTechnique($data['charge_technique'] ?? '');

            $entityManager->persist($autorisation);
            $entityManager->flush();

            return $this->json([
                'success' => true,
                'message' => 'Autorisation Matériaux Construction créée avec succès',
                'data' => [
                    'id' => $autorisation->getId(),
                    'matricule' => $autorisation->getMatricule()
                ]
            ], JsonResponse::HTTP_CREATED);
            
        } catch (\Exception $e) {
            return $this->json([
                'success' => false,
                'message' => 'Erreur lors de la création: ' . $e->getMessage()
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/{id}', name: 'app_autorisation_materiaux_construction_show', methods: ['GET'])]
    public function show(AutorisationMateriauxConstruction $autorisation): JsonResponse
    {
        return $this->json([
            'success' => true,
            'data' => [
                'id' => $autorisation->getId(),
                'matricule' => $autorisation->getMatricule(),
                'lieu_emission' => $autorisation->getLieuEmission(),
                'date_emission' => $autorisation->getDateEmission()?->format('Y-m-d'),
                'r_type' => $autorisation->getRType(),
                'r_nationalite' => $autorisation->getRNationalite(),
                'r_addresse' => $autorisation->getRAddresse(),
                'r_telephone' => $autorisation->getRTelephone(),
                'v_matricule' => $autorisation->getVMatricule(),
                'v_marque' => $autorisation->getVMarque(),
                'v_type' => $autorisation->getVType(),
                'type_charge' => $autorisation->getTypeCharge(),
                'tonnage_kg' => $autorisation->getTonnageKg(),
                'r_securite' => $autorisation->getRSecurite(),
                'heure_circulation' => $autorisation->getHeureCirculation(),
                'p_depart' => $autorisation->getPDepart(),
                'p_arrivee' => $autorisation->getPArrivee(),
                'h_depart' => $autorisation->getHDepart()?->format('H:i:s'),
                'h_arrivee' => $autorisation->getHArrivee()?->format('H:i:s'),
                'arrimage' => $autorisation->isArrimage(),
                'centrage' => $autorisation->isCentrage(),
                'signalisation' => $autorisation->isSignalisation(),
                'charge_technique' => $autorisation->getChargeTechnique(),
            ]
        ]);
    }

    #[Route('/{id}/edit', name: 'app_autorisation_materiaux_construction_edit', methods: ['PUT', 'PATCH'])]
    public function edit(Request $request, AutorisationMateriauxConstruction $autorisation, EntityManagerInterface $entityManager): JsonResponse
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
                $autorisation->setLieuEmission($data['lieu_emission']);
            }
            if (isset($data['date_emission'])) {
                $autorisation->setDateEmission(new \DateTime($data['date_emission']));
            }
            if (isset($data['r_type'])) {
                $autorisation->setRType($data['r_type']);
            }
            if (isset($data['r_nationalite'])) {
                $autorisation->setRNationalite($data['r_nationalite']);
            }
            if (isset($data['r_addresse'])) {
                $autorisation->setRAddresse($data['r_addresse']);
            }
            if (isset($data['r_telephone'])) {
                $autorisation->setRTelephone($data['r_telephone']);
            }
            if (isset($data['v_matricule'])) {
                $autorisation->setVMatricule($data['v_matricule']);
            }
            if (isset($data['v_marque'])) {
                $autorisation->setVMarque($data['v_marque']);
            }
            if (isset($data['v_type'])) {
                $autorisation->setVType($data['v_type']);
            }
            if (isset($data['type_charge'])) {
                $autorisation->setTypeCharge($data['type_charge']);
            }
            if (isset($data['tonnage_kg'])) {
                $autorisation->setTonnageKg($data['tonnage_kg']);
            }
            if (isset($data['r_securite'])) {
                $autorisation->setRSecurite($data['r_securite']);
            }
            if (isset($data['heure_circulation'])) {
                $autorisation->setHeureCirculation($data['heure_circulation']);
            }
            if (isset($data['p_depart'])) {
                $autorisation->setPDepart($data['p_depart']);
            }
            if (isset($data['p_arrivee'])) {
                $autorisation->setPArrivee($data['p_arrivee']);
            }
            if (isset($data['h_depart'])) {
                $autorisation->setHDepart(new \DateTime($data['h_depart']));
            }
            if (isset($data['h_arrivee'])) {
                $autorisation->setHArrivee(new \DateTime($data['h_arrivee']));
            }
            if (isset($data['arrimage'])) {
                $autorisation->setArrimage($data['arrimage']);
            }
            if (isset($data['centrage'])) {
                $autorisation->setCentrage($data['centrage']);
            }
            if (isset($data['signalisation'])) {
                $autorisation->setSignalisation($data['signalisation']);
            }
            if (isset($data['charge_technique'])) {
                $autorisation->setChargeTechnique($data['charge_technique']);
            }

            $entityManager->flush();

            return $this->json([
                'success' => true,
                'message' => 'Autorisation Matériaux Construction mise à jour avec succès',
                'data' => [
                    'id' => $autorisation->getId(),
                    'matricule' => $autorisation->getMatricule()
                ]
            ]);
            
        } catch (\Exception $e) {
            return $this->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour: ' . $e->getMessage()
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/{id}', name: 'app_autorisation_materiaux_construction_delete', methods: ['DELETE'])]
    public function delete(Request $request, AutorisationMateriauxConstruction $autorisation, EntityManagerInterface $entityManager): JsonResponse
    {
        try {
            $entityManager->remove($autorisation);
            $entityManager->flush();
            
            return $this->json([
                'success' => true,
                'message' => 'Autorisation Matériaux Construction supprimée avec succès'
            ]);
            
        } catch (\Exception $e) {
            return $this->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression: ' . $e->getMessage()
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

<?php

namespace App\Controller\api;

use App\Entity\SurveillanceTaxiMoto;
use App\Form\SurveillanceTaxiMotoType;
use App\Repository\SurveillanceTaxiMotoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;



#[Route('/api/surveillance/taximoto')]
final class ApiSurveillanceTaxiMotoController extends AbstractController
{
    #[Route(name: 'app_surveillance_taxi_moto_index', methods: ['GET'])]
    public function index(SurveillanceTaxiMotoRepository $surveillanceTaxiMotoRepository): JsonResponse
    {
        $surveillanceTaxiMotos = $surveillanceTaxiMotoRepository->findAll();
        
        $data = [];
        foreach ($surveillanceTaxiMotos as $item) {
            $data[] = [
                'id' => $item->getId(),
                'matricule' => $item->getMatricule(),
                'numero_recu' => $item->getNumeroRecu(),
                'lieu_emission' => $item->getLieuEmission(),
                'date_emission' => $item->getDateEmission()?->format('Y-m-d'),
                'nom_dem' => $item->getNomDem(),
                'corporation' => $item->getCorporation(),
                'telephone_dem' => $item->getTelephoneDem(),
                'm_matricule' => $item->getMMatricule(),
                'marque_moto' => $item->getMarqueMoto(),
                'inspecteur1' => $item->getInspecteur1(),
                'inspecteur2' => $item->getInspecteur2(),
                'inspecteur3' => $item->getInspecteur3(),
            ];
        }
        
        return $this->json([
            'success' => true,
            'data' => $data
        ]);
    }

    #[Route('/new', name: 'app_surveillance_taxi_moto_new', methods: ['POST'])]
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
            
            $surveillanceTaxiMoto = new SurveillanceTaxiMoto();
            $surveillanceTaxiMoto->setMatricule($data['matricule'] ?? '');
            $surveillanceTaxiMoto->setNumeroRecu($data['numero_recu'] ?? '');
            $surveillanceTaxiMoto->setLieuEmission($data['lieu_emission'] ?? '');
            
            if (isset($data['date_emission'])) {
                $surveillanceTaxiMoto->setDateEmission(new \DateTime($data['date_emission']));
            }
            
            $surveillanceTaxiMoto->setNomDem($data['nom_dem'] ?? '');
            $surveillanceTaxiMoto->setCorporation($data['corporation'] ?? '');
            $surveillanceTaxiMoto->setTelephoneDem($data['telephone_dem'] ?? '');
            $surveillanceTaxiMoto->setMMatricule($data['m_matricule'] ?? '');
            $surveillanceTaxiMoto->setMarqueMoto($data['marque_moto'] ?? '');
            $surveillanceTaxiMoto->setInspecteur1($data['inspecteur1'] ?? '');
            $surveillanceTaxiMoto->setInspecteur2($data['inspecteur2'] ?? '');
            $surveillanceTaxiMoto->setInspecteur3($data['inspecteur3'] ?? '');

            $entityManager->persist($surveillanceTaxiMoto);
            $entityManager->flush();

            return $this->json([
                'success' => true,
                'message' => 'Surveillance Taxi/Moto créée avec succès',
                'data' => [
                    'id' => $surveillanceTaxiMoto->getId(),
                    'matricule' => $surveillanceTaxiMoto->getMatricule()
                ]
            ], JsonResponse::HTTP_CREATED);
            
        } catch (\Exception $e) {
            return $this->json([
                'success' => false,
                'message' => 'Erreur lors de la création: ' . $e->getMessage()
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/{matricule}', name: 'app_surveillance_taxi_moto_show', methods: ['GET'])]
    public function show(SurveillanceTaxiMoto $surveillanceTaxiMoto): JsonResponse
    {
        return $this->json([
            'success' => true,
            'data' => [
                'id' => $surveillanceTaxiMoto->getId(),
                'matricule' => $surveillanceTaxiMoto->getMatricule(),
                'numero_recu' => $surveillanceTaxiMoto->getNumeroRecu(),
                'lieu_emission' => $surveillanceTaxiMoto->getLieuEmission(),
                'date_emission' => $surveillanceTaxiMoto->getDateEmission()?->format('Y-m-d'),
                'nom_dem' => $surveillanceTaxiMoto->getNomDem(),
                'corporation' => $surveillanceTaxiMoto->getCorporation(),
                'telephone_dem' => $surveillanceTaxiMoto->getTelephoneDem(),
                'm_matricule' => $surveillanceTaxiMoto->getMMatricule(),
                'marque_moto' => $surveillanceTaxiMoto->getMarqueMoto(),
                'inspecteur1' => $surveillanceTaxiMoto->getInspecteur1(),
                'inspecteur2' => $surveillanceTaxiMoto->getInspecteur2(),
                'inspecteur3' => $surveillanceTaxiMoto->getInspecteur3(),
            ]
        ]);
    }

    #[Route('/{matricule}/edit', name: 'app_surveillance_taxi_moto_edit', methods: ['PUT', 'PATCH'])]
    public function edit(Request $request, SurveillanceTaxiMoto $surveillanceTaxiMoto, EntityManagerInterface $entityManager): JsonResponse
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
                $surveillanceTaxiMoto->setNumeroRecu($data['numero_recu']);
            }
            if (isset($data['lieu_emission'])) {
                $surveillanceTaxiMoto->setLieuEmission($data['lieu_emission']);
            }
            if (isset($data['date_emission'])) {
                $surveillanceTaxiMoto->setDateEmission(new \DateTime($data['date_emission']));
            }
            if (isset($data['nom_dem'])) {
                $surveillanceTaxiMoto->setNomDem($data['nom_dem']);
            }
            if (isset($data['corporation'])) {
                $surveillanceTaxiMoto->setCorporation($data['corporation']);
            }
            if (isset($data['telephone_dem'])) {
                $surveillanceTaxiMoto->setTelephoneDem($data['telephone_dem']);
            }
            if (isset($data['m_matricule'])) {
                $surveillanceTaxiMoto->setMMatricule($data['m_matricule']);
            }
            if (isset($data['marque_moto'])) {
                $surveillanceTaxiMoto->setMarqueMoto($data['marque_moto']);
            }
            if (isset($data['inspecteur1'])) {
                $surveillanceTaxiMoto->setInspecteur1($data['inspecteur1']);
            }
            if (isset($data['inspecteur2'])) {
                $surveillanceTaxiMoto->setInspecteur2($data['inspecteur2']);
            }
            if (isset($data['inspecteur3'])) {
                $surveillanceTaxiMoto->setInspecteur3($data['inspecteur3']);
            }

            $entityManager->flush();

            return $this->json([
                'success' => true,
                'message' => 'Surveillance Taxi/Moto mise à jour avec succès',
                'data' => [
                    'id' => $surveillanceTaxiMoto->getId(),
                    'matricule' => $surveillanceTaxiMoto->getMatricule()
                ]
            ]);
            
        } catch (\Exception $e) {
            return $this->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour: ' . $e->getMessage()
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/{matricule}', name: 'app_surveillance_taxi_moto_delete', methods: ['DELETE'])]
    public function delete(Request $request, SurveillanceTaxiMoto $surveillanceTaxiMoto, EntityManagerInterface $entityManager): JsonResponse
    {
        try {
            $entityManager->remove($surveillanceTaxiMoto);
            $entityManager->flush();
            
            return $this->json([
                'success' => true,
                'message' => 'Surveillance Taxi/Moto supprimée avec succès'
            ]);
            
        } catch (\Exception $e) {
            return $this->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression: ' . $e->getMessage()
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

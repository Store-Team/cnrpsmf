<?php

namespace App\Controller\api;

use App\Entity\Quittance;
use App\Repository\QuittanceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/quittance')]
final class ApiQuittanceController extends AbstractController
{
    #[Route(name: 'app_quittance_index', methods: ['GET'])]
    public function index(QuittanceRepository $quittanceRepository): JsonResponse
    {
        $quittances = $quittanceRepository->findAll();
        
        $data = [];
        foreach ($quittances as $item) {
            $data[] = [
                'id' => $item->getId(),
                'matricule' => $item->getMatricule(),
                'type_quittance' => $item->getTypeQuittance(),
                'lieu_emission' => $item->getLieuEmission(),
                'date_emmision' => $item->getDateEmmision()?->format('Y-m-d'),
                'assujettif' => $item->getAssujettif(),
                'numero_perception' => $item->getNumeroPerception(),
                'montant_chiffres' => $item->getMontantChiffres(),
                'montant' => $item->getMontant(),
                'banque' => $item->getBanque(),
                'numero_compte' => $item->getNumeroCompte(),
                'mode_payement' => $item->getModePayement(),
                'nature_impo' => $item->getNatureImpo(),
                'receveur_drlu' => $item->getReceveurDrlu(),
            ];
        }
        
        return $this->json([
            'success' => true,
            'data' => $data
        ]);
    }

    #[Route('/new', name: 'app_quittance_new', methods: ['POST'])]
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
            
            $quittance = new Quittance();
            $quittance->setMatricule($data['matricule'] ?? '');
            $quittance->setTypeQuittance($data['type_quittance'] ?? '');
            $quittance->setLieuEmission($data['lieu_emission'] ?? '');
            
            if (isset($data['date_emmision'])) {
                $quittance->setDateEmmision(new \DateTime($data['date_emmision']));
            }
            
            $quittance->setAssujettif($data['assujettif'] ?? '');
            $quittance->setNumeroPerception($data['numero_perception'] ?? '');
            $quittance->setMontantChiffres($data['montant_chiffres'] ?? '');
            $quittance->setMontant($data['montant'] ?? '');
            $quittance->setBanque($data['banque'] ?? '');
            $quittance->setNumeroCompte($data['numero_compte'] ?? '');
            $quittance->setModePayement($data['mode_payement'] ?? '');
            $quittance->setNatureImpo($data['nature_impo'] ?? '');
            $quittance->setReceveurDrlu($data['receveur_drlu'] ?? '');

            $entityManager->persist($quittance);
            $entityManager->flush();

            return $this->json([
                'success' => true,
                'message' => 'Quittance créée avec succès',
                'data' => [
                    'id' => $quittance->getId(),
                    'matricule' => $quittance->getMatricule()
                ]
            ], JsonResponse::HTTP_CREATED);
            
        } catch (\Exception $e) {
            return $this->json([
                'success' => false,
                'message' => 'Erreur lors de la création: ' . $e->getMessage()
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/{matricule}', name: 'app_quittance_show', methods: ['GET'])]
    public function show(Quittance $quittance): JsonResponse
    {
        return $this->json([
            'success' => true,
            'data' => [
                'id' => $quittance->getId(),
                'matricule' => $quittance->getMatricule(),
                'type_quittance' => $quittance->getTypeQuittance(),
                'lieu_emission' => $quittance->getLieuEmission(),
                'date_emmision' => $quittance->getDateEmmision()?->format('Y-m-d'),
                'assujettif' => $quittance->getAssujettif(),
                'numero_perception' => $quittance->getNumeroPerception(),
                'montant_chiffres' => $quittance->getMontantChiffres(),
                'montant' => $quittance->getMontant(),
                'banque' => $quittance->getBanque(),
                'numero_compte' => $quittance->getNumeroCompte(),
                'mode_payement' => $quittance->getModePayement(),
                'nature_impo' => $quittance->getNatureImpo(),
                'receveur_drlu' => $quittance->getReceveurDrlu(),
            ]
        ]);
    }

    #[Route('/{matricule}/edit', name: 'app_quittance_edit', methods: ['PUT', 'PATCH'])]
    public function edit(Request $request, Quittance $quittance, EntityManagerInterface $entityManager): JsonResponse
    {
        try {
            $data = json_decode($request->getContent(), true);
            
            if (!$data) {
                return $this->json([
                    'success' => false,
                    'message' => 'Données JSON invalides'
                ], JsonResponse::HTTP_BAD_REQUEST);
            }
            
            if (isset($data['type_quittance'])) {
                $quittance->setTypeQuittance($data['type_quittance']);
            }
            if (isset($data['lieu_emission'])) {
                $quittance->setLieuEmission($data['lieu_emission']);
            }
            if (isset($data['date_emmision'])) {
                $quittance->setDateEmmision(new \DateTime($data['date_emmision']));
            }
            if (isset($data['assujettif'])) {
                $quittance->setAssujettif($data['assujettif']);
            }
            if (isset($data['numero_perception'])) {
                $quittance->setNumeroPerception($data['numero_perception']);
            }
            if (isset($data['montant_chiffres'])) {
                $quittance->setMontantChiffres($data['montant_chiffres']);
            }
            if (isset($data['montant'])) {
                $quittance->setMontant($data['montant']);
            }
            if (isset($data['banque'])) {
                $quittance->setBanque($data['banque']);
            }
            if (isset($data['numero_compte'])) {
                $quittance->setNumeroCompte($data['numero_compte']);
            }
            if (isset($data['mode_payement'])) {
                $quittance->setModePayement($data['mode_payement']);
            }
            if (isset($data['nature_impo'])) {
                $quittance->setNatureImpo($data['nature_impo']);
            }
            if (isset($data['receveur_drlu'])) {
                $quittance->setReceveurDrlu($data['receveur_drlu']);
            }

            $entityManager->flush();

            return $this->json([
                'success' => true,
                'message' => 'Quittance mise à jour avec succès',
                'data' => [
                    'id' => $quittance->getId(),
                    'matricule' => $quittance->getMatricule()
                ]
            ]);
            
        } catch (\Exception $e) {
            return $this->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour: ' . $e->getMessage()
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/{matricule}', name: 'app_quittance_delete', methods: ['DELETE'])]
    public function delete(Request $request, Quittance $quittance, EntityManagerInterface $entityManager): JsonResponse
    {
        try {
            $entityManager->remove($quittance);
            $entityManager->flush();
            
            return $this->json([
                'success' => true,
                'message' => 'Quittance supprimée avec succès'
            ]);
            
        } catch (\Exception $e) {
            return $this->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression: ' . $e->getMessage()
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

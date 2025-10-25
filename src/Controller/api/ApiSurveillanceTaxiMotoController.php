<?php

namespace App\Controller\api;

use App\Entity\SurveillanceTaxiMoto;
use App\Repository\SurveillanceTaxiMotoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\Expr\Orx;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;


#[Route('/api/surveillance/taximoto')]
#[OA\Tag(name: 'Surveillance Taxi Moto')]
final class ApiSurveillanceTaxiMotoController extends AbstractController
{
    public function __construct(private SerializerInterface $serializer)
    {
    }


    #[Route(name: 'app_surveillance_taxi_moto_index', methods: ['GET'])]
    #[OA\Get(
        path: '/api/surveillance/taximoto',
        summary: 'Liste toutes les surveillances de taxi moto',
        description: 'Récupère la liste complète des surveillances de taxi moto avec pagination optionnelle',
        tags: ['Surveillance Taxi Moto']
    )]
    #[OA\Response(
        response: 200,
        description: 'Liste des surveillances récupérée avec succès',
        content: new OA\JsonContent(
            type: 'object',
            properties: [
                new OA\Property(property: 'success', type: 'boolean', example: true),
                new OA\Property(
                    property: 'data', 
                    type: 'array', 
                    items: new OA\Items(
                        type: 'object',
                        properties: [
                            new OA\Property(property: 'id', type: 'integer', example: 1),
                            new OA\Property(property: 'numero_autorisation', type: 'string', example: 'TM-2024-001'),
                            new OA\Property(property: 'lieu_emission', type: 'string', example: 'Douala'),
                            new OA\Property(property: 'date_emission', type: 'string', format: 'date', example: '2024-01-15'),
                            new OA\Property(property: 'conducteur_nom', type: 'string', example: 'MBALLA Paul'),
                            new OA\Property(property: 'conducteur_permis', type: 'string', example: 'P12345678'),
                            new OA\Property(property: 'vehicule_matricule', type: 'string', example: 'DLA-123-AB'),
                            new OA\Property(property: 'vehicule_marque', type: 'string', example: 'YAMAHA'),
                            new OA\Property(property: 'vehicule_couleur', type: 'string', example: 'Rouge'),
                            new OA\Property(property: 'heure_debut', type: 'string', format: 'time', example: '08:00:00'),
                            new OA\Property(property: 'heure_fin', type: 'string', format: 'time', example: '18:00:00'),
                            new OA\Property(property: 'zone_operation', type: 'string', example: 'Centre-ville'),
                            new OA\Property(property: 'observations', type: 'string', example: 'RAS'),
                            new OA\Property(property: 'approuve', type: 'boolean', example: true)
                        ]
                    )
                )
            ],
            example: [
                'success' => true,
                'data' => [
                    [
                        'id' => 1,
                        'numero_autorisation' => 'TM-2024-001',
                        'lieu_emission' => 'Douala',
                        'date_emission' => '2024-01-15',
                        'conducteur_nom' => 'MBALLA Paul',
                        'conducteur_permis' => 'P12345678',
                        'vehicule_matricule' => 'DLA-123-AB',
                        'vehicule_marque' => 'YAMAHA',
                        'vehicule_couleur' => 'Rouge',
                        'heure_debut' => '08:00:00',
                        'heure_fin' => '18:00:00',
                        'zone_operation' => 'Centre-ville',
                        'observations' => 'RAS',
                        'approuve' => true
                    ]
                ]
            ]
        )
    )]
    public function index(SurveillanceTaxiMotoRepository $surveillanceTaxiMotoRepository): JsonResponse
    {
        $surveillances = $surveillanceTaxiMotoRepository->findAll();
        
        return $this->json([
            'success' => true,
            'data' => $surveillances
        ], context: ['groups' => ['api_surveillance_taxi_moto']]);
    }
















    
    #[Route('/new', name: 'app_surveillance_taxi_moto_new', methods: ['POST'])]
    #[OA\Post(
        path: '/api/surveillance/taximoto/new',
        summary: 'Crée une nouvelle surveillance de taxi moto',
        description: 'Crée une nouvelle surveillance avec toutes les informations du conducteur, véhicule et zone d\'opération',
        tags: ['Surveillance Taxi Moto'],
        requestBody: new OA\RequestBody(
            required: true,
        content: new OA\JsonContent(
            type: 'object',
            description: 'Données de la surveillance à créer',
            required: ['numero_autorisation', 'lieu_emission', 'date_emission', 'conducteur_nom', 'vehicule_matricule'],
            properties: [
                new OA\Property(property: 'numero_autorisation', type: 'string', example: 'TM-2024-002', description: 'Numéro unique d\'autorisation'),
                new OA\Property(property: 'lieu_emission', type: 'string', example: 'Yaoundé', description: 'Lieu d\'émission de l\'autorisation'),
                new OA\Property(property: 'date_emission', type: 'string', format: 'date', example: '2024-01-20', description: 'Date d\'émission'),
                new OA\Property(property: 'conducteur_nom', type: 'string', example: 'NKOMO Jean', description: 'Nom complet du conducteur'),
                new OA\Property(property: 'conducteur_permis', type: 'string', example: 'P87654321', description: 'Numéro de permis'),
                new OA\Property(property: 'conducteur_telephone', type: 'string', example: '+237 6XX XX XX XX', description: 'Téléphone du conducteur'),
                new OA\Property(property: 'vehicule_matricule', type: 'string', example: 'YDE-456-CD', description: 'Plaque d\'immatriculation'),
                new OA\Property(property: 'vehicule_marque', type: 'string', example: 'HONDA', description: 'Marque du véhicule'),
                new OA\Property(property: 'vehicule_modele', type: 'string', example: 'CBR 125', description: 'Modèle du véhicule'),
                new OA\Property(property: 'vehicule_couleur', type: 'string', example: 'Bleu', description: 'Couleur principale'),
                new OA\Property(property: 'heure_debut', type: 'string', format: 'time', example: '06:00:00', description: 'Heure de début d\'activité'),
                new OA\Property(property: 'heure_fin', type: 'string', format: 'time', example: '20:00:00', description: 'Heure de fin d\'activité'),
                new OA\Property(property: 'zone_operation', type: 'string', example: 'Quartier Mvog-Mbi', description: 'Zone d\'opération autorisée'),
                new OA\Property(property: 'observations', type: 'string', example: 'Véhicule en bon état', description: 'Observations particulières'),
                new OA\Property(property: 'approuve', type: 'boolean', example: false, description: 'Statut d\'approbation')
            ],
            example: [
                'numero_autorisation' => 'TM-2024-002',
                'lieu_emission' => 'Yaoundé',
                'date_emission' => '2024-01-20',
                'conducteur_nom' => 'NKOMO Jean',
                'conducteur_permis' => 'P87654321',
                'conducteur_telephone' => '+237 6XX XX XX XX',
                'vehicule_matricule' => 'YDE-456-CD',
                'vehicule_marque' => 'HONDA',
                'vehicule_modele' => 'CBR 125',
                'vehicule_couleur' => 'Bleu',
                'heure_debut' => '06:00:00',
                'heure_fin' => '20:00:00',
                'zone_operation' => 'Quartier Mvog-Mbi',
                'observations' => 'Véhicule en bon état',
                'approuve' => false
            ]
        )
        ),
        responses:[
            new OA\Response(
                response: 201,
                description: 'Surveillance créée avec succès',
                content: new OA\JsonContent(
                    type: 'object',
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Surveillance Taxi Moto créée avec succès'),
                        new OA\Property(
                            property: 'data', 
                            type: 'object',
                            properties: [
                                new OA\Property(property: 'id', type: 'integer', example: 2),
                                new OA\Property(property: 'numero_autorisation', type: 'string', example: 'TM-2024-002'),
                                new OA\Property(property: 'conducteur_nom', type: 'string', example: 'NKOMO Jean')
                            ]
                        )
                    ],
                    example: [
                        'success' => true,
                        'message' => 'Surveillance Taxi Moto créée avec succès',
                        'data' => [
                            'id' => 2,
                            'numero_autorisation' => 'TM-2024-002',
                            'conducteur_nom' => 'NKOMO Jean'
                        ]
                    ]
                )
            ),
            new OA\Response(
                response: 500,
                description: 'Erreur serveur',
                content: new OA\JsonContent(
                    type: 'object',
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: false),
                        new OA\Property(property: 'message', type: 'string', example: 'Erreur lors de la création: [détails de l\'erreur]')
                    ],
                    example: [
                        'success' => false,
                        'message' => 'Erreur lors de la création: [détails de l\'erreur]'
                    ]
                )
            )
        ]
    )]
    public function new(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        try {
            $surveillance = $this->serializer->deserialize(
                $request->getContent(),
                SurveillanceTaxiMoto::class,
                'json',
                ['groups' => ['api_surveillance_taxi_moto']]
            );

            $entityManager->persist($surveillance);
            $entityManager->flush();

            return $this->json([
                'success' => true,
                'message' => 'Surveillance Taxi Moto créée avec succès',
                'data' => $surveillance
            ], JsonResponse::HTTP_CREATED, context: ['groups' => ['api_surveillance_taxi_moto']]);
            
        } catch (\Exception $e) {
            return $this->json([
                'success' => false,
                'message' => 'Erreur lors de la création: ' . $e->getMessage()
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
















    
    #[Route('/{id}', name: 'app_surveillance_taxi_moto_show', methods: ['GET'])]
    #[OA\Get(
        path: '/api/surveillance/taximoto/{id}',
        summary: 'Récupère une surveillance spécifique',
        description: 'Affiche les détails complets d\'une surveillance de taxi moto par son ID',
        tags: ['Surveillance Taxi Moto']
    )]
    #[OA\Parameter(
        name: 'id',
        description: 'ID unique de la surveillance',
        in: 'path',
        required: true,
        schema: new OA\Schema(type: 'integer', minimum: 1),
        example: 1
    )]
    #[OA\Response(
        response: 200,
        description: 'Surveillance trouvée',
        content: new OA\JsonContent(
            type: 'object',
            properties: [
                new OA\Property(property: 'success', type: 'boolean', example: true),
                new OA\Property(
                    property: 'data', 
                    type: 'object',
                    properties: [
                        new OA\Property(property: 'id', type: 'integer', example: 1),
                        new OA\Property(property: 'numero_autorisation', type: 'string', example: 'TM-2024-001'),
                        new OA\Property(property: 'lieu_emission', type: 'string', example: 'Douala'),
                        new OA\Property(property: 'date_emission', type: 'string', format: 'date', example: '2024-01-15'),
                        new OA\Property(property: 'conducteur_nom', type: 'string', example: 'MBALLA Paul'),
                        new OA\Property(property: 'conducteur_permis', type: 'string', example: 'P12345678'),
                        new OA\Property(property: 'conducteur_telephone', type: 'string', example: '+237 6XX XX XX XX'),
                        new OA\Property(property: 'vehicule_matricule', type: 'string', example: 'DLA-123-AB'),
                        new OA\Property(property: 'vehicule_marque', type: 'string', example: 'YAMAHA'),
                        new OA\Property(property: 'vehicule_modele', type: 'string', example: 'MT-125'),
                        new OA\Property(property: 'vehicule_couleur', type: 'string', example: 'Rouge'),
                        new OA\Property(property: 'heure_debut', type: 'string', format: 'time', example: '08:00:00'),
                        new OA\Property(property: 'heure_fin', type: 'string', format: 'time', example: '18:00:00'),
                        new OA\Property(property: 'zone_operation', type: 'string', example: 'Centre-ville'),
                        new OA\Property(property: 'observations', type: 'string', example: 'RAS'),
                        new OA\Property(property: 'approuve', type: 'boolean', example: true)
                    ]
                )
            ],
            example: [
                'success' => true,
                'data' => [
                    'id' => 1,
                    'numero_autorisation' => 'TM-2024-001',
                    'lieu_emission' => 'Douala',
                    'date_emission' => '2024-01-15',
                    'conducteur_nom' => 'MBALLA Paul',
                    'conducteur_permis' => 'P12345678',
                    'conducteur_telephone' => '+237 6XX XX XX XX',
                    'vehicule_matricule' => 'DLA-123-AB',
                    'vehicule_marque' => 'YAMAHA',
                    'vehicule_modele' => 'MT-125',
                    'vehicule_couleur' => 'Rouge',
                    'heure_debut' => '08:00:00',
                    'heure_fin' => '18:00:00',
                    'zone_operation' => 'Centre-ville',
                    'observations' => 'RAS',
                    'approuve' => true
                ]
            ]
        )
    )]
    #[OA\Response(
        response: 404, 
        description: 'Surveillance non trouvée',
        content: new OA\JsonContent(
            type: 'object',
            properties: [
                new OA\Property(property: 'success', type: 'boolean', example: false),
                new OA\Property(property: 'message', type: 'string', example: 'Surveillance avec l\'ID 999 non trouvée')
            ]
        )
    )]
    public function show(SurveillanceTaxiMoto $surveillance): JsonResponse
    {
        return $this->json([
            'success' => true,
            'data' => $surveillance
        ], context: ['groups' => ['api_surveillance_taxi_moto']]);
    }
















    
    #[Route('/{id}/edit', name: 'app_surveillance_taxi_moto_edit', methods: ['PUT', 'PATCH'])]
    #[OA\Put(
        path: '/api/surveillance/taximoto/{id}/edit',
        summary: 'Met à jour une surveillance existante',
        description: 'Modifie les informations d\'une surveillance existante. Seuls les champs fournis seront mis à jour.',
        tags: ['Surveillance Taxi Moto']
    )]
    #[OA\Parameter(
        name: 'id',
        description: 'ID unique de la surveillance à modifier',
        in: 'path',
        required: true,
        schema: new OA\Schema(type: 'integer', minimum: 1),
        example: 1
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            type: 'object',
            description: 'Données à mettre à jour (mise à jour partielle possible)',
            properties: [
                new OA\Property(property: 'conducteur_telephone', type: 'string', example: '+237 6XX XX XX XX', description: 'Nouveau numéro de téléphone'),
                new OA\Property(property: 'zone_operation', type: 'string', example: 'Quartier Bonamoussadi', description: 'Nouvelle zone d\'opération'),
                new OA\Property(property: 'heure_debut', type: 'string', format: 'time', example: '07:00:00', description: 'Nouvelle heure de début'),
                new OA\Property(property: 'heure_fin', type: 'string', format: 'time', example: '19:00:00', description: 'Nouvelle heure de fin'),
                new OA\Property(property: 'observations', type: 'string', example: 'Contrôle technique à jour', description: 'Nouvelles observations'),
                new OA\Property(property: 'approuve', type: 'boolean', example: true, description: 'Statut d\'approbation')
            ],
            example: [
                'conducteur_telephone' => '+237 655 XX XX XX',
                'zone_operation' => 'Quartier Bonamoussadi',
                'heure_debut' => '07:00:00',
                'heure_fin' => '19:00:00',
                'observations' => 'Contrôle technique à jour',
                'approuve' => true
            ]
        )
    )]
    #[OA\Response(
        response: 200,
        description: 'Surveillance mise à jour avec succès',
        content: new OA\JsonContent(
            type: 'object',
            properties: [
                new OA\Property(property: 'success', type: 'boolean', example: true),
                new OA\Property(property: 'message', type: 'string', example: 'Surveillance Taxi Moto mise à jour avec succès'),
                new OA\Property(
                    property: 'data', 
                    type: 'object',
                    properties: [
                        new OA\Property(property: 'id', type: 'integer', example: 1),
                        new OA\Property(property: 'numero_autorisation', type: 'string', example: 'TM-2024-001'),
                        new OA\Property(property: 'zone_operation', type: 'string', example: 'Quartier Bonamoussadi'),
                        new OA\Property(property: 'approuve', type: 'boolean', example: true)
                    ]
                )
            ],
            example: [
                'success' => true,
                'message' => 'Surveillance Taxi Moto mise à jour avec succès',
                'data' => [
                    'id' => 1,
                    'numero_autorisation' => 'TM-2024-001',
                    'zone_operation' => 'Quartier Bonamoussadi',
                    'approuve' => true
                ]
            ]
        )
    )]
    #[OA\Response(
        response: 404, 
        description: 'Surveillance non trouvée',
        content: new OA\JsonContent(
            type: 'object',
            properties: [
                new OA\Property(property: 'success', type: 'boolean', example: false),
                new OA\Property(property: 'message', type: 'string', example: 'Surveillance avec l\'ID 999 non trouvée')
            ]
        )
    )]
    #[OA\Response(response: 500, description: 'Erreur serveur')]
    public function edit(Request $request, SurveillanceTaxiMoto $surveillance, EntityManagerInterface $entityManager): JsonResponse
    {
        try {
            $this->serializer->deserialize(
                $request->getContent(),
                SurveillanceTaxiMoto::class,
                'json',
                ['object_to_populate' => $surveillance, 'groups' => ['api_surveillance_taxi_moto']]
            );

            $entityManager->flush();

            return $this->json([
                'success' => true,
                'message' => 'Surveillance Taxi Moto mise à jour avec succès',
                'data' => $surveillance
            ], context: ['groups' => ['api_surveillance_taxi_moto']]);
            
        } catch (\Exception $e) {
            return $this->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour: ' . $e->getMessage()
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
















    
    #[Route('/{id}', name: 'app_surveillance_taxi_moto_delete', methods: ['DELETE'])]
    #[OA\Delete(
        path: '/api/surveillance/taximoto/{id}',
        summary: 'Supprime une surveillance',
        description: 'Supprime définitivement une surveillance de taxi moto du système',
        tags: ['Surveillance Taxi Moto']
    )]
    #[OA\Parameter(
        name: 'id',
        description: 'ID unique de la surveillance à supprimer',
        in: 'path',
        required: true,
        schema: new OA\Schema(type: 'integer', minimum: 1),
        example: 1
    )]
    #[OA\Response(
        response: 200,
        description: 'Surveillance supprimée avec succès',
        content: new OA\JsonContent(
            type: 'object',
            properties: [
                new OA\Property(property: 'success', type: 'boolean', example: true),
                new OA\Property(property: 'message', type: 'string', example: 'Surveillance Taxi Moto supprimée avec succès')
            ],
            example: [
                'success' => true,
                'message' => 'Surveillance Taxi Moto supprimée avec succès'
            ]
        )
    )]
    #[OA\Response(
        response: 404, 
        description: 'Surveillance non trouvée',
        content: new OA\JsonContent(
            type: 'object',
            properties: [
                new OA\Property(property: 'success', type: 'boolean', example: false),
                new OA\Property(property: 'message', type: 'string', example: 'Surveillance avec l\'ID 999 non trouvée')
            ]
        )
    )]
    #[OA\Response(
        response: 500, 
        description: 'Erreur serveur',
        content: new OA\JsonContent(
            type: 'object',
            properties: [
                new OA\Property(property: 'success', type: 'boolean', example: false),
                new OA\Property(property: 'message', type: 'string', example: 'Erreur lors de la suppression: contrainte de base de données')
            ]
        )
    )]
    public function delete(Request $request, SurveillanceTaxiMoto $surveillance, EntityManagerInterface $entityManager): JsonResponse
    {
        try {
            $entityManager->remove($surveillance);
            $entityManager->flush();
            
            return $this->json([
                'success' => true,
                'message' => 'Surveillance Taxi Moto supprimée avec succès'
            ]);
            
        } catch (\Exception $e) {
            return $this->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression: ' . $e->getMessage()
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
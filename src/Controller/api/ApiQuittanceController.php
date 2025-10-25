<?php

namespace App\Controller\api;

use App\Entity\Quittance;
use App\Repository\QuittanceRepository;
use Doctrine\ORM\EntityManagerInterface;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/quittance')]
#[OA\Tag(name: 'Quittance')]
final class ApiQuittanceController extends AbstractController
{
    public function __construct(private SerializerInterface $serializer)
    {
    }

    #[Route(name: 'app_quittance_index', methods: ['GET'])]
    #[OA\Get(
        path: '/api/quittance',
        summary: 'Liste toutes les quittances',
        description: 'Récupère la liste complète des quittances de paiement avec informations financières détaillées',
        tags: ['Quittance']
    )]
    #[OA\Response(
        response: 200,
        description: 'Liste des quittances récupérée avec succès',
        content: new OA\JsonContent(
            type: 'object',
            properties: [
                new OA\Property(property: 'success', type: 'boolean', description: 'Statut de la requête', example: true),
                new OA\Property(
                    property: 'data', 
                    type: 'array',
                    description: 'Liste des quittances de paiement',
                    items: new OA\Items(
                        type: 'object',
                        properties: [
                            new OA\Property(property: 'id', type: 'integer', description: 'ID auto-généré', example: 1),
                            new OA\Property(property: 'matricule', type: 'string', description: 'Matricule unique de la quittance', example: '20251025001'),
                            new OA\Property(property: 'type_quittance', type: 'string', description: 'Type de quittance émise', example: 'Taxe de circulation'),
                            new OA\Property(property: 'lieu_emission', type: 'string', description: 'Lieu d\'émission de la quittance', example: 'Trésor Public de Douala'),
                            new OA\Property(property: 'date_emmision', type: 'string', format: 'date', description: 'Date d\'émission', example: '2025-10-25'),
                            new OA\Property(property: 'assujettif', type: 'string', description: 'Nom de l\'assujetti/redevable', example: 'SARL Transport Express Cameroun'),
                            new OA\Property(property: 'numero_perception', type: 'string', description: 'Numéro de perception fiscale', example: 'P2025100001'),
                            new OA\Property(property: 'montant_chiffres', type: 'string', description: 'Montant en chiffres', example: '125000'),
                            new OA\Property(property: 'montant', type: 'string', description: 'Montant précis avec décimales', example: '125000.000'),
                            new OA\Property(property: 'banque', type: 'string', description: 'Banque de dépôt', example: 'Banque Atlantique Cameroun'),
                            new OA\Property(property: 'numero_compte', type: 'string', description: 'Numéro de compte bancaire', example: '10001-00123-45678-90'),
                            new OA\Property(property: 'mode_payement', type: 'string', description: 'Mode de paiement utilisé', example: 'Virement bancaire'),
                            new OA\Property(property: 'nature_impo', type: 'string', description: 'Nature de l\'impôt ou taxe', example: 'Taxe sur les véhicules de transport'),
                            new OA\Property(property: 'receveur_drlu', type: 'string', description: 'Receveur de la Direction Régionale', example: 'NGONO Pierre - DR Littoral')
                        ]
                    )
                )
            ],
            example: [
                'success' => true,
                'data' => [
                    [
                        'id' => 1,
                        'matricule' => '20251025001',
                        'type_quittance' => 'Taxe de circulation',
                        'lieu_emission' => 'Trésor Public de Douala',
                        'date_emmision' => '2025-10-25',
                        'assujettif' => 'SARL Transport Express Cameroun',
                        'numero_perception' => 'P2025100001',
                        'montant_chiffres' => '125000',
                        'montant' => '125000.000',
                        'banque' => 'Banque Atlantique Cameroun',
                        'numero_compte' => '10001-00123-45678-90',
                        'mode_payement' => 'Virement bancaire',
                        'nature_impo' => 'Taxe sur les véhicules de transport',
                        'receveur_drlu' => 'NGONO Pierre - DR Littoral'
                    ],
                    [
                        'id' => 2,
                        'matricule' => '20251025002',
                        'type_quittance' => 'Droits de douane',
                        'lieu_emission' => 'Bureau des Douanes Port de Douala',
                        'date_emmision' => '2025-10-25',
                        'assujettif' => 'Entreprise Import-Export FOBA',
                        'numero_perception' => 'P2025100002',
                        'montant_chiffres' => '2850000',
                        'montant' => '2850000.000',
                        'banque' => 'Ecobank Cameroun',
                        'numero_compte' => '20002-00456-78901-23',
                        'mode_payement' => 'Chèque bancaire',
                        'nature_impo' => 'Droits de douane sur marchandises importées',
                        'receveur_drlu' => 'MBALLA Rosine - Bureau Central Douala'
                    ],
                    [
                        'id' => 3,
                        'matricule' => '20251025003',
                        'type_quittance' => 'Redevance portuaire',
                        'lieu_emission' => 'Port Autonome de Douala - Caisse',
                        'date_emmision' => '2025-10-25',
                        'assujettif' => 'Armement Maritime du Cameroun',
                        'numero_perception' => 'P2025100003',
                        'montant_chiffres' => '750000',
                        'montant' => '750000.000',
                        'banque' => 'BGFI Bank Cameroun',
                        'numero_compte' => '30003-00789-01234-56',
                        'mode_payement' => 'Espèces',
                        'nature_impo' => 'Redevances d\'utilisation des installations portuaires',
                        'receveur_drlu' => 'ATANGANA Joseph - PAD Finances'
                    ]
                ]
            ]
        )
    )]
    #[OA\Response(
        response: 500,
        description: 'Erreur serveur interne',
        content: new OA\JsonContent(
            type: 'object',
            properties: [
                new OA\Property(property: 'success', type: 'boolean', example: false),
                new OA\Property(property: 'message', type: 'string', example: 'Erreur lors de la récupération des données financières')
            ]
        )
    )]
    public function index(QuittanceRepository $quittanceRepository): JsonResponse
    {
        $quittances = $quittanceRepository->findAll();
        
        return $this->json([
            'success' => true,
            'data' => $quittances
        ], context: ['groups' => ['api_quittance']]);
    }















    
    #[Route('/new', name: 'app_quittance_new', methods: ['POST'])]
    #[OA\Post(
        path: '/api/quittance/new',
        summary: 'Crée une nouvelle quittance',
        description: 'Créer une nouvelle quittance de paiement pour taxes, droits de douane ou redevances diverses',
        tags: ['Quittance']
    )]
    #[OA\RequestBody(
        required: true,
        description: 'Données complètes de la quittance de paiement à créer',
        content: new OA\JsonContent(
            type: 'object',
            required: ['matricule', 'type_quittance', 'lieu_emission', 'date_emmision', 'assujettif', 'numero_perception', 'montant_chiffres', 'montant', 'banque', 'numero_compte', 'mode_payement', 'nature_impo', 'receveur_drlu'],
            properties: [
                new OA\Property(property: 'matricule', type: 'string', description: 'Matricule unique de la quittance (format: YYYYMMDDXXX)', example: '20251025004', maxLength: 20),
                new OA\Property(property: 'type_quittance', type: 'string', description: 'Type de quittance émise', enum: ['Taxe de circulation', 'Droits de douane', 'Redevance portuaire', 'Taxe foncière', 'Impôt sur le revenu', 'TVA', 'Patente commerciale'], example: 'Patente commerciale', maxLength: 255),
                new OA\Property(property: 'lieu_emission', type: 'string', description: 'Lieu précis d\'émission de la quittance', example: 'Centre des Impôts de Yaoundé III', maxLength: 255),
                new OA\Property(property: 'date_emmision', type: 'string', format: 'date', description: 'Date d\'émission de la quittance', example: '2025-10-25'),
                new OA\Property(property: 'assujettif', type: 'string', description: 'Nom complet de l\'assujetti/redevable', example: 'Société Camerounaise de Bâtiment et Travaux Publics (SCBTP)', maxLength: 255),
                new OA\Property(property: 'numero_perception', type: 'string', description: 'Numéro unique de perception fiscale', example: 'P2025100004', maxLength: 255),
                new OA\Property(property: 'montant_chiffres', type: 'string', description: 'Montant en chiffres (format entier)', example: '450000', maxLength: 255),
                new OA\Property(property: 'montant', type: 'string', description: 'Montant précis avec 3 décimales', example: '450000.000'),
                new OA\Property(property: 'banque', type: 'string', description: 'Nom de la banque de dépôt', example: 'Commercial Bank of Cameroon (CBC)', maxLength: 255),
                new OA\Property(property: 'numero_compte', type: 'string', description: 'Numéro de compte bancaire complet', example: '40004-00567-89012-34', maxLength: 255),
                new OA\Property(property: 'mode_payement', type: 'string', description: 'Mode de paiement utilisé', enum: ['Espèces', 'Chèque bancaire', 'Virement bancaire', 'Carte bancaire', 'Mandat postal', 'Mobile Money'], example: 'Mobile Money', maxLength: 255),
                new OA\Property(property: 'nature_impo', type: 'string', description: 'Description détaillée de la nature de l\'impôt ou taxe', example: 'Patente commerciale - Activité BTP et génie civil', maxLength: 255),
                new OA\Property(property: 'receveur_drlu', type: 'string', description: 'Nom complet du receveur et structure de rattachement', example: 'MENDOMO Élise - Centre des Impôts Yaoundé III', maxLength: 255)
            ],
            example: [
                'matricule' => '20251025004',
                'type_quittance' => 'Patente commerciale',
                'lieu_emission' => 'Centre des Impôts de Yaoundé III',
                'date_emmision' => '2025-10-25',
                'assujettif' => 'Société Camerounaise de Bâtiment et Travaux Publics (SCBTP)',
                'numero_perception' => 'P2025100004',
                'montant_chiffres' => '450000',
                'montant' => '450000.000',
                'banque' => 'Commercial Bank of Cameroon (CBC)',
                'numero_compte' => '40004-00567-89012-34',
                'mode_payement' => 'Mobile Money',
                'nature_impo' => 'Patente commerciale - Activité BTP et génie civil',
                'receveur_drlu' => 'MENDOMO Élise - Centre des Impôts Yaoundé III'
            ]
        )
    )]
    #[OA\Response(
        response: 201,
        description: 'Quittance créée avec succès',
        content: new OA\JsonContent(
            type: 'object',
            properties: [
                new OA\Property(property: 'success', type: 'boolean', description: 'Statut de la création', example: true),
                new OA\Property(property: 'message', type: 'string', description: 'Message de confirmation', example: 'Quittance créée avec succès'),
                new OA\Property(
                    property: 'data', 
                    type: 'object',
                    description: 'Données de la quittance créée avec ID généré',
                    example: [
                        'id' => 4,
                        'matricule' => '20251025004',
                        'type_quittance' => 'Patente commerciale',
                        'lieu_emission' => 'Centre des Impôts de Yaoundé III',
                        'date_emmision' => '2025-10-25',
                        'assujettif' => 'Société Camerounaise de Bâtiment et Travaux Publics (SCBTP)',
                        'numero_perception' => 'P2025100004',
                        'montant_chiffres' => '450000',
                        'montant' => '450000.000',
                        'banque' => 'Commercial Bank of Cameroon (CBC)',
                        'numero_compte' => '40004-00567-89012-34',
                        'mode_payement' => 'Mobile Money',
                        'nature_impo' => 'Patente commerciale - Activité BTP et génie civil',
                        'receveur_drlu' => 'MENDOMO Élise - Centre des Impôts Yaoundé III'
                    ]
                )
            ]
        )
    )]
    #[OA\Response(
        response: 400,
        description: 'Données de requête invalides',
        content: new OA\JsonContent(
            type: 'object',
            properties: [
                new OA\Property(property: 'success', type: 'boolean', example: false),
                new OA\Property(property: 'message', type: 'string', example: 'Erreur de validation: matricule déjà existant ou montant invalide')
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
                new OA\Property(property: 'message', type: 'string', example: 'Erreur lors de la création: violation de contrainte de base de données')
            ]
        )
    )]
    public function new(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        try {
            $quittance = $this->serializer->deserialize(
                $request->getContent(),
                Quittance::class,
                'json',
                ['groups' => ['api_quittance']]
            );

            $entityManager->persist($quittance);
            $entityManager->flush();

            return $this->json([
                'success' => true,
                'message' => 'Quittance créée avec succès',
                'data' => $quittance
            ], JsonResponse::HTTP_CREATED, context: ['groups' => ['api_quittance']]);
            
        } catch (\Exception $e) {
            return $this->json([
                'success' => false,
                'message' => 'Erreur lors de la création: ' . $e->getMessage()
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }















    
    #[Route('/{id}', name: 'app_quittance_show', methods: ['GET'])]
    #[OA\Get(
        path: '/api/quittance/{id}',
        summary: 'Récupère une quittance spécifique',
        description: 'Affiche toutes les informations détaillées d\'une quittance de paiement par son ID',
        tags: ['Quittance']
    )]
    #[OA\Parameter(
        name: 'id',
        description: 'ID unique de la quittance à récupérer',
        in: 'path',
        required: true,
        schema: new OA\Schema(type: 'integer', minimum: 1),
        example: 1
    )]
    #[OA\Response(
        response: 200,
        description: 'Quittance trouvée avec succès',
        content: new OA\JsonContent(
            type: 'object',
            properties: [
                new OA\Property(property: 'success', type: 'boolean', description: 'Statut de la requête', example: true),
                new OA\Property(
                    property: 'data', 
                    type: 'object',
                    description: 'Données complètes de la quittance',
                    properties: [
                        new OA\Property(property: 'id', type: 'integer', description: 'ID de la quittance', example: 1),
                        new OA\Property(property: 'matricule', type: 'string', description: 'Matricule unique', example: '20251025001'),
                        new OA\Property(property: 'type_quittance', type: 'string', description: 'Type de quittance', example: 'Taxe de circulation'),
                        new OA\Property(property: 'lieu_emission', type: 'string', description: 'Lieu d\'émission', example: 'Trésor Public de Douala'),
                        new OA\Property(property: 'date_emmision', type: 'string', format: 'date', description: 'Date d\'émission', example: '2025-10-25'),
                        new OA\Property(property: 'assujettif', type: 'string', description: 'Nom de l\'assujetti', example: 'SARL Transport Express Cameroun'),
                        new OA\Property(property: 'numero_perception', type: 'string', description: 'Numéro de perception', example: 'P2025100001'),
                        new OA\Property(property: 'montant_chiffres', type: 'string', description: 'Montant en chiffres', example: '125000'),
                        new OA\Property(property: 'montant', type: 'string', description: 'Montant précis', example: '125000.000'),
                        new OA\Property(property: 'banque', type: 'string', description: 'Banque de dépôt', example: 'Banque Atlantique Cameroun'),
                        new OA\Property(property: 'numero_compte', type: 'string', description: 'Numéro de compte', example: '10001-00123-45678-90'),
                        new OA\Property(property: 'mode_payement', type: 'string', description: 'Mode de paiement', example: 'Virement bancaire'),
                        new OA\Property(property: 'nature_impo', type: 'string', description: 'Nature de l\'impôt', example: 'Taxe sur les véhicules de transport'),
                        new OA\Property(property: 'receveur_drlu', type: 'string', description: 'Receveur responsable', example: 'NGONO Pierre - DR Littoral')
                    ],
                    example: [
                        'id' => 1,
                        'matricule' => '20251025001',
                        'type_quittance' => 'Taxe de circulation',
                        'lieu_emission' => 'Trésor Public de Douala',
                        'date_emmision' => '2025-10-25',
                        'assujettif' => 'SARL Transport Express Cameroun',
                        'numero_perception' => 'P2025100001',
                        'montant_chiffres' => '125000',
                        'montant' => '125000.000',
                        'banque' => 'Banque Atlantique Cameroun',
                        'numero_compte' => '10001-00123-45678-90',
                        'mode_payement' => 'Virement bancaire',
                        'nature_impo' => 'Taxe sur les véhicules de transport',
                        'receveur_drlu' => 'NGONO Pierre - DR Littoral'
                    ]
                )
            ]
        )
    )]
    #[OA\Response(
        response: 404, 
        description: 'Quittance non trouvée',
        content: new OA\JsonContent(
            type: 'object',
            properties: [
                new OA\Property(property: 'success', type: 'boolean', example: false),
                new OA\Property(property: 'message', type: 'string', example: 'Quittance avec l\'ID 999 non trouvée')
            ]
        )
    )]
    public function show(Quittance $quittance): JsonResponse
    {
        return $this->json([
            'success' => true,
            'data' => $quittance
        ], context: ['groups' => ['api_quittance']]);
    }















    
    #[Route('/{id}/edit', name: 'app_quittance_edit', methods: ['PUT', 'PATCH'])]
    #[OA\Put(
        path: '/api/quittance/{id}/edit',
        summary: 'Met à jour une quittance existante',
        description: 'Modifie les informations d\'une quittance existante. Mise à jour partielle ou complète autorisée.',
        tags: ['Quittance']
    )]
    #[OA\Parameter(
        name: 'id',
        description: 'ID unique de la quittance à modifier',
        in: 'path',
        required: true,
        schema: new OA\Schema(type: 'integer', minimum: 1),
        example: 1
    )]
    #[OA\RequestBody(
        required: true,
        description: 'Données à mettre à jour (mise à jour partielle autorisée)',
        content: new OA\JsonContent(
            type: 'object',
            properties: [
                new OA\Property(property: 'type_quittance', type: 'string', description: 'Nouveau type de quittance', example: 'TVA sur services', maxLength: 255),
                new OA\Property(property: 'lieu_emission', type: 'string', description: 'Nouveau lieu d\'émission', example: 'Centre des Impôts de Bafoussam', maxLength: 255),
                new OA\Property(property: 'assujettif', type: 'string', description: 'Nouveau nom de l\'assujetti', example: 'Coopérative Agricole des Hauts Plateaux', maxLength: 255),
                new OA\Property(property: 'numero_perception', type: 'string', description: 'Nouveau numéro de perception', example: 'P2025100005', maxLength: 255),
                new OA\Property(property: 'montant_chiffres', type: 'string', description: 'Nouveau montant en chiffres', example: '85000', maxLength: 255),
                new OA\Property(property: 'montant', type: 'string', description: 'Nouveau montant précis', example: '85000.000'),
                new OA\Property(property: 'banque', type: 'string', description: 'Nouvelle banque', example: 'Société Générale Cameroun', maxLength: 255),
                new OA\Property(property: 'numero_compte', type: 'string', description: 'Nouveau numéro de compte', example: '50005-00890-12345-67', maxLength: 255),
                new OA\Property(property: 'mode_payement', type: 'string', description: 'Nouveau mode de paiement', example: 'Chèque bancaire', maxLength: 255),
                new OA\Property(property: 'nature_impo', type: 'string', description: 'Nouvelle nature d\'impôt', example: 'TVA sur prestations de services agricoles', maxLength: 255),
                new OA\Property(property: 'receveur_drlu', type: 'string', description: 'Nouveau receveur', example: 'TCHINDA Paul - Centre des Impôts Bafoussam', maxLength: 255)
            ],
            example: [
                'type_quittance' => 'TVA sur services',
                'lieu_emission' => 'Centre des Impôts de Bafoussam',
                'assujettif' => 'Coopérative Agricole des Hauts Plateaux',
                'montant_chiffres' => '85000',
                'montant' => '85000.000',
                'banque' => 'Société Générale Cameroun',
                'mode_payement' => 'Chèque bancaire',
                'nature_impo' => 'TVA sur prestations de services agricoles',
                'receveur_drlu' => 'TCHINDA Paul - Centre des Impôts Bafoussam'
            ]
        )
    )]
    #[OA\Response(
        response: 200,
        description: 'Quittance mise à jour avec succès',
        content: new OA\JsonContent(
            type: 'object',
            properties: [
                new OA\Property(property: 'success', type: 'boolean', description: 'Statut de la mise à jour', example: true),
                new OA\Property(property: 'message', type: 'string', description: 'Message de confirmation', example: 'Quittance mise à jour avec succès'),
                new OA\Property(
                    property: 'data', 
                    type: 'object',
                    description: 'Données de la quittance mise à jour',
                    example: [
                        'id' => 1,
                        'matricule' => '20251025001',
                        'type_quittance' => 'TVA sur services',
                        'lieu_emission' => 'Centre des Impôts de Bafoussam',
                        'date_emmision' => '2025-10-25',
                        'assujettif' => 'Coopérative Agricole des Hauts Plateaux',
                        'numero_perception' => 'P2025100001',
                        'montant_chiffres' => '85000',
                        'montant' => '85000.000',
                        'banque' => 'Société Générale Cameroun',
                        'numero_compte' => '10001-00123-45678-90',
                        'mode_payement' => 'Chèque bancaire',
                        'nature_impo' => 'TVA sur prestations de services agricoles',
                        'receveur_drlu' => 'TCHINDA Paul - Centre des Impôts Bafoussam'
                    ]
                )
            ]
        )
    )]
    #[OA\Response(
        response: 404, 
        description: 'Quittance non trouvée',
        content: new OA\JsonContent(
            type: 'object',
            properties: [
                new OA\Property(property: 'success', type: 'boolean', example: false),
                new OA\Property(property: 'message', type: 'string', example: 'Quittance avec l\'ID 999 non trouvée')
            ]
        )
    )]
    #[OA\Response(
        response: 400,
        description: 'Données de requête invalides',
        content: new OA\JsonContent(
            type: 'object',
            properties: [
                new OA\Property(property: 'success', type: 'boolean', example: false),
                new OA\Property(property: 'message', type: 'string', example: 'Erreur de validation: montant invalide ou numéro de compte incorrect')
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
                new OA\Property(property: 'message', type: 'string', example: 'Erreur lors de la mise à jour: violation de contrainte de base de données')
            ]
        )
    )]
    public function edit(Request $request, Quittance $quittance, EntityManagerInterface $entityManager): JsonResponse
    {
        try {
            $this->serializer->deserialize(
                $request->getContent(),
                Quittance::class,
                'json',
                ['object_to_populate' => $quittance, 'groups' => ['api_quittance']]
            );

            $entityManager->flush();

            return $this->json([
                'success' => true,
                'message' => 'Quittance mise à jour avec succès',
                'data' => $quittance
            ], context: ['groups' => ['api_quittance']]);
            
        } catch (\Exception $e) {
            return $this->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour: ' . $e->getMessage()
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }















    
    #[Route('/{id}', name: 'app_quittance_delete', methods: ['DELETE'])]
    #[OA\Delete(
        path: '/api/quittance/{id}',
        summary: 'Supprime une quittance',
        description: 'Supprime définitivement une quittance du système (opération irréversible)',
        tags: ['Quittance']
    )]
    #[OA\Parameter(
        name: 'id',
        description: 'ID unique de la quittance à supprimer',
        in: 'path',
        required: true,
        schema: new OA\Schema(type: 'integer', minimum: 1),
        example: 1
    )]
    #[OA\Response(
        response: 200,
        description: 'Quittance supprimée avec succès',
        content: new OA\JsonContent(
            type: 'object',
            properties: [
                new OA\Property(property: 'success', type: 'boolean', description: 'Statut de la suppression', example: true),
                new OA\Property(property: 'message', type: 'string', description: 'Message de confirmation', example: 'Quittance supprimée avec succès')
            ],
            example: [
                'success' => true,
                'message' => 'Quittance supprimée avec succès'
            ]
        )
    )]
    #[OA\Response(
        response: 404, 
        description: 'Quittance non trouvée',
        content: new OA\JsonContent(
            type: 'object',
            properties: [
                new OA\Property(property: 'success', type: 'boolean', example: false),
                new OA\Property(property: 'message', type: 'string', example: 'Quittance avec l\'ID 999 non trouvée')
            ]
        )
    )]
    #[OA\Response(
        response: 409,
        description: 'Conflit - Suppression interdite',
        content: new OA\JsonContent(
            type: 'object',
            properties: [
                new OA\Property(property: 'success', type: 'boolean', example: false),
                new OA\Property(property: 'message', type: 'string', example: 'Impossible de supprimer: quittance référencée dans des documents comptables')
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
                new OA\Property(property: 'message', type: 'string', example: 'Erreur lors de la suppression: contrainte de base de données ou archive comptable')
            ]
        )
    )]
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
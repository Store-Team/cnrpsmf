<?php

namespace App\Controller\api;

use App\Entity\SurveillanceChargement;
use App\Repository\SurveillanceChargementRepository;
use Doctrine\ORM\EntityManagerInterface;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/surveillance/chargement')]
#[OA\Tag(name: 'Surveillance Chargement')]
final class ApiSurveillanceChargementController extends AbstractController
{
    public function __construct(private SerializerInterface $serializer)
    {
    }

    #[Route(name: 'app_surveillance_chargement_index', methods: ['GET'])]
    #[OA\Get(
        path: '/api/surveillance/chargement',
        summary: 'Liste toutes les surveillances de chargement',
        description: 'Récupère la liste complète des surveillances de chargement avec informations détaillées sur les opérations portuaires et de transport',
        tags: ['Surveillance Chargement']
    )]
    #[OA\Response(
        response: 200,
        description: 'Liste des surveillances récupérée avec succès',
        content: new OA\JsonContent(
            type: 'object',
            properties: [
                new OA\Property(property: 'success', type: 'boolean', description: 'Statut de la requête', example: true),
                new OA\Property(
                    property: 'data', 
                    type: 'array',
                    description: 'Liste des surveillances de chargement',
                    items: new OA\Items(
                        type: 'object',
                        properties: [
                            new OA\Property(property: 'id', type: 'integer', description: 'ID auto-généré', example: 1),
                            new OA\Property(property: 'matricule', type: 'string', description: 'Matricule unique de l\'opération', example: '20251025001'),
                            new OA\Property(property: 'numero_recu', type: 'string', description: 'Numéro du reçu de chargement', example: 'RC20251025001'),
                            new OA\Property(property: 'lieu_emission', type: 'string', description: 'Lieu d\'émission du document', example: 'Terminal à Conteneurs du Port de Douala'),
                            new OA\Property(property: 'date_emission', type: 'string', format: 'date', description: 'Date d\'émission', example: '2025-10-25'),
                            new OA\Property(property: 'r_organisation', type: 'string', description: 'Organisation responsable', example: 'SARL Transport Cameroun'),
                            new OA\Property(property: 'r_nationalite', type: 'string', description: 'Nationalité de l\'organisation', example: 'Camerounaise'),
                            new OA\Property(property: 'r_addresse', type: 'string', description: 'Adresse de l\'organisation', example: 'Zone Portuaire Bonabéri, BP 2345 Douala'),
                            new OA\Property(property: 'r_telephone', type: 'string', description: 'Téléphone de contact', example: '+237690234567'),
                            new OA\Property(property: 'v_matricule', type: 'string', description: 'Matricule du véhicule de transport', example: 'CM-2025-TR-4567'),
                            new OA\Property(property: 'type_charge', type: 'string', description: 'Type de marchandise transportée', example: 'Conteneurs frigorifiques'),
                            new OA\Property(property: 'tonnage_kg', type: 'string', description: 'Poids total en kilogrammes', example: '25000'),
                            new OA\Property(property: 'signalisation', type: 'boolean', description: 'Conformité signalisation', example: true),
                            new OA\Property(property: 'couverture', type: 'boolean', description: 'Conformité protection/couverture', example: true),
                            new OA\Property(property: 'p_depart', type: 'string', description: 'Point de départ du transport', example: 'Quai 5 - Terminal Conteneurs'),
                            new OA\Property(property: 'p_arrivee', type: 'string', description: 'Destination finale', example: 'Entrepôt Frigombal Yaoundé'),
                            new OA\Property(property: 'h_depart', type: 'string', format: 'time', description: 'Heure de départ prévue', example: '07:30:00'),
                            new OA\Property(property: 'h_arrivee', type: 'string', format: 'time', description: 'Heure d\'arrivée prévue', example: '15:45:00'),
                            new OA\Property(property: 'nom_inspecteur', type: 'string', description: 'Nom de l\'inspecteur responsable', example: 'Ongolo Marie Thérèse'),
                            new OA\Property(property: 'approuvee', type: 'boolean', description: 'Statut d\'approbation de la surveillance', example: true)
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
                        'numero_recu' => 'RC20251025001',
                        'lieu_emission' => 'Terminal à Conteneurs du Port de Douala',
                        'date_emission' => '2025-10-25',
                        'r_organisation' => 'SARL Transport Cameroun',
                        'r_nationalite' => 'Camerounaise',
                        'r_addresse' => 'Zone Portuaire Bonabéri, BP 2345 Douala',
                        'r_telephone' => '+237690234567',
                        'v_matricule' => 'CM-2025-TR-4567',
                        'type_charge' => 'Conteneurs frigorifiques',
                        'tonnage_kg' => '25000',
                        'signalisation' => true,
                        'couverture' => true,
                        'p_depart' => 'Quai 5 - Terminal Conteneurs',
                        'p_arrivee' => 'Entrepôt Frigombal Yaoundé',
                        'h_depart' => '07:30:00',
                        'h_arrivee' => '15:45:00',
                        'nom_inspecteur' => 'Ongolo Marie Thérèse',
                        'approuvee' => true
                    ],
                    [
                        'id' => 2,
                        'matricule' => '20251025002',
                        'numero_recu' => 'RC20251025002',
                        'lieu_emission' => 'Port de Kribi',
                        'date_emission' => '2025-10-25',
                        'r_organisation' => 'Entreprise Bois du Cameroun',
                        'r_nationalite' => 'Camerounaise',
                        'r_addresse' => 'Route de Lolodorf, Kribi',
                        'r_telephone' => '+237677345678',
                        'v_matricule' => 'CM-2025-KB-7890',
                        'type_charge' => 'Grumes de bois exotique',
                        'tonnage_kg' => '30000',
                        'signalisation' => true,
                        'couverture' => false,
                        'p_depart' => 'Terminal Bois Kribi',
                        'p_arrivee' => 'Port de Hambourg',
                        'h_depart' => '09:00:00',
                        'h_arrivee' => '12:30:00',
                        'nom_inspecteur' => 'Essono Jacques',
                        'approuvee' => true
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
                new OA\Property(property: 'message', type: 'string', example: 'Erreur lors de la récupération des données de surveillance')
            ]
        )
    )]
    public function index(SurveillanceChargementRepository $surveillanceChargementRepository): JsonResponse
    {
        $surveillances = $surveillanceChargementRepository->findAll();
        
        return $this->json([
            'success' => true,
            'data' => $surveillances
        ], context: ['groups' => ['api_surveillance_chargement']]);
    }








    #[Route('/new', name: 'app_surveillance_chargement_new', methods: ['POST'])]
    #[OA\Post(
        path: '/api/surveillance/chargement/new',
        summary: 'Crée une nouvelle surveillance de chargement',
        description: 'Créer une nouvelle surveillance de chargement pour les opérations portuaires et de transport de marchandises',
        tags: ['Surveillance Chargement']
    )]
    #[OA\RequestBody(
        required: true,
        description: 'Données complètes de la surveillance de chargement à créer',
        content: new OA\JsonContent(
            type: 'object',
            required: ['matricule', 'numero_recu', 'lieu_emission', 'date_emission', 'r_organisation', 'r_nationalite', 'r_addresse', 'r_telephone', 'v_matricule', 'type_charge', 'tonnage_kg', 'signalisation', 'couverture', 'p_depart', 'p_arrivee', 'h_depart', 'h_arrivee', 'nom_inspecteur'],
            properties: [
                new OA\Property(property: 'matricule', type: 'string', description: 'Matricule unique de l\'opération (format: YYYYMMDDXXX)', example: '20251025003', maxLength: 20),
                new OA\Property(property: 'numero_recu', type: 'string', description: 'Numéro du reçu de chargement', example: 'RC20251025003', maxLength: 20),
                new OA\Property(property: 'lieu_emission', type: 'string', description: 'Lieu précis d\'émission du document', example: 'Terminal Vraquier Port Autonome de Douala', maxLength: 255),
                new OA\Property(property: 'date_emission', type: 'string', format: 'date', description: 'Date d\'émission du document de surveillance', example: '2025-10-25'),
                new OA\Property(property: 'r_organisation', type: 'string', description: 'Nom de l\'organisation/entreprise responsable du transport', example: 'Société Camerounaise de Manutention (SCM)', maxLength: 255),
                new OA\Property(property: 'r_nationalite', type: 'string', description: 'Nationalité de l\'organisation', example: 'Camerounaise', maxLength: 255),
                new OA\Property(property: 'r_addresse', type: 'string', description: 'Adresse complète de l\'organisation', example: 'Boulevard du 20 Mai, Quartier Akwa, BP 4052 Douala', maxLength: 255),
                new OA\Property(property: 'r_telephone', type: 'string', description: 'Numéro de téléphone de contact (format international)', example: '+237699456789', maxLength: 13),
                new OA\Property(property: 'v_matricule', type: 'string', description: 'Matricule du véhicule de transport principal', example: 'CM-2025-SC-1122', maxLength: 255),
                new OA\Property(property: 'type_charge', type: 'string', description: 'Description détaillée du type de marchandise', example: 'Cacao en sacs de 60kg + café Arabica', maxLength: 255),
                new OA\Property(property: 'tonnage_kg', type: 'string', description: 'Poids total de la cargaison en kilogrammes', example: '18000', maxLength: 255),
                new OA\Property(property: 'signalisation', type: 'boolean', description: 'Conformité de la signalisation du transport', example: true),
                new OA\Property(property: 'couverture', type: 'boolean', description: 'Conformité de la protection/bâchage de la marchandise', example: true),
                new OA\Property(property: 'p_depart', type: 'string', description: 'Point de départ précis (quai, zone, terminal)', example: 'Magasin 12 - Zone Export Cacao', maxLength: 255),
                new OA\Property(property: 'p_arrivee', type: 'string', description: 'Destination finale du transport', example: 'Usine Chocolaterie Nationale Yaoundé', maxLength: 255),
                new OA\Property(property: 'h_depart', type: 'string', format: 'time', description: 'Heure prévue de départ du chargement', example: '14:00:00'),
                new OA\Property(property: 'h_arrivee', type: 'string', format: 'time', description: 'Heure prévue d\'arrivée à destination', example: '22:30:00'),
                new OA\Property(property: 'nom_inspecteur', type: 'string', description: 'Nom complet de l\'inspecteur en charge', example: 'Ateba Rose Pauline', maxLength: 255),
                new OA\Property(property: 'approuvee', type: 'boolean', description: 'Statut d\'approbation de la surveillance', example: false)
            ],
            example: [
                'matricule' => '20251025003',
                'numero_recu' => 'RC20251025003',
                'lieu_emission' => 'Terminal Vraquier Port Autonome de Douala',
                'date_emission' => '2025-10-25',
                'r_organisation' => 'Société Camerounaise de Manutention (SCM)',
                'r_nationalite' => 'Camerounaise',
                'r_addresse' => 'Boulevard du 20 Mai, Quartier Akwa, BP 4052 Douala',
                'r_telephone' => '+237699456789',
                'v_matricule' => 'CM-2025-SC-1122',
                'type_charge' => 'Cacao en sacs de 60kg + café Arabica',
                'tonnage_kg' => '18000',
                'signalisation' => true,
                'couverture' => true,
                'p_depart' => 'Magasin 12 - Zone Export Cacao',
                'p_arrivee' => 'Usine Chocolaterie Nationale Yaoundé',
                'h_depart' => '14:00:00',
                'h_arrivee' => '22:30:00',
                'nom_inspecteur' => 'Ateba Rose Pauline',
                'approuvee' => false
            ]
        )
    )]
    #[OA\Response(
        response: 201,
        description: 'Surveillance créée avec succès',
        content: new OA\JsonContent(
            type: 'object',
            properties: [
                new OA\Property(property: 'success', type: 'boolean', description: 'Statut de la création', example: true),
                new OA\Property(property: 'message', type: 'string', description: 'Message de confirmation', example: 'Surveillance Chargement créée avec succès'),
                new OA\Property(
                    property: 'data', 
                    type: 'object',
                    description: 'Données de la surveillance créée avec ID généré',
                    example: [
                        'id' => 3,
                        'matricule' => '20251025003',
                        'numero_recu' => 'RC20251025003',
                        'lieu_emission' => 'Terminal Vraquier Port Autonome de Douala',
                        'date_emission' => '2025-10-25',
                        'r_organisation' => 'Société Camerounaise de Manutention (SCM)',
                        'r_nationalite' => 'Camerounaise',
                        'r_addresse' => 'Boulevard du 20 Mai, Quartier Akwa, BP 4052 Douala',
                        'r_telephone' => '+237699456789',
                        'v_matricule' => 'CM-2025-SC-1122',
                        'type_charge' => 'Cacao en sacs de 60kg + café Arabica',
                        'tonnage_kg' => '18000',
                        'signalisation' => true,
                        'couverture' => true,
                        'p_depart' => 'Magasin 12 - Zone Export Cacao',
                        'p_arrivee' => 'Usine Chocolaterie Nationale Yaoundé',
                        'h_depart' => '14:00:00',
                        'h_arrivee' => '22:30:00',
                        'nom_inspecteur' => 'Ateba Rose Pauline',
                        'approuvee' => false
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
                new OA\Property(property: 'message', type: 'string', example: 'Erreur de validation: matricule déjà existant ou format de téléphone invalide')
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
            $surveillance = $this->serializer->deserialize(
                $request->getContent(),
                SurveillanceChargement::class,
                'json',
                ['groups' => ['api_surveillance_chargement']]
            );

            $entityManager->persist($surveillance);
            $entityManager->flush();

            return $this->json([
                'success' => true,
                'message' => 'Surveillance Chargement créée avec succès',
                'data' => $surveillance
            ], JsonResponse::HTTP_CREATED, context: ['groups' => ['api_surveillance_chargement']]);
            
        } catch (\Exception $e) {
            return $this->json([
                'success' => false,
                'message' => 'Erreur lors de la création: ' . $e->getMessage()
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }














    #[Route('/{id}', name: 'app_surveillance_chargement_show', methods: ['GET'])]
    #[OA\Get(
        path: '/api/surveillance/chargement/{id}',
        summary: 'Récupère une surveillance spécifique',
        description: 'Affiche toutes les informations détaillées d\'une surveillance de chargement par son ID',
        tags: ['Surveillance Chargement']
    )]
    #[OA\Parameter(
        name: 'id',
        description: 'ID unique de la surveillance à récupérer',
        in: 'path',
        required: true,
        schema: new OA\Schema(type: 'integer', minimum: 1),
        example: 1
    )]
    #[OA\Response(
        response: 200,
        description: 'Surveillance trouvée avec succès',
        content: new OA\JsonContent(
            type: 'object',
            properties: [
                new OA\Property(property: 'success', type: 'boolean', description: 'Statut de la requête', example: true),
                new OA\Property(
                    property: 'data', 
                    type: 'object',
                    description: 'Données complètes de la surveillance de chargement',
                    properties: [
                        new OA\Property(property: 'id', type: 'integer', description: 'ID de la surveillance', example: 1),
                        new OA\Property(property: 'matricule', type: 'string', description: 'Matricule de l\'opération', example: '20251025001'),
                        new OA\Property(property: 'numero_recu', type: 'string', description: 'Numéro du reçu', example: 'RC20251025001'),
                        new OA\Property(property: 'lieu_emission', type: 'string', description: 'Lieu d\'émission', example: 'Terminal à Conteneurs du Port de Douala'),
                        new OA\Property(property: 'date_emission', type: 'string', format: 'date', description: 'Date d\'émission', example: '2025-10-25'),
                        new OA\Property(property: 'r_organisation', type: 'string', description: 'Organisation responsable', example: 'SARL Transport Cameroun'),
                        new OA\Property(property: 'r_nationalite', type: 'string', description: 'Nationalité', example: 'Camerounaise'),
                        new OA\Property(property: 'r_addresse', type: 'string', description: 'Adresse complète', example: 'Zone Portuaire Bonabéri, BP 2345 Douala'),
                        new OA\Property(property: 'r_telephone', type: 'string', description: 'Téléphone de contact', example: '+237690234567'),
                        new OA\Property(property: 'v_matricule', type: 'string', description: 'Matricule véhicule', example: 'CM-2025-TR-4567'),
                        new OA\Property(property: 'type_charge', type: 'string', description: 'Type de marchandise', example: 'Conteneurs frigorifiques'),
                        new OA\Property(property: 'tonnage_kg', type: 'string', description: 'Poids total en kg', example: '25000'),
                        new OA\Property(property: 'signalisation', type: 'boolean', description: 'Conformité signalisation', example: true),
                        new OA\Property(property: 'couverture', type: 'boolean', description: 'Conformité protection', example: true),
                        new OA\Property(property: 'p_depart', type: 'string', description: 'Point de départ', example: 'Quai 5 - Terminal Conteneurs'),
                        new OA\Property(property: 'p_arrivee', type: 'string', description: 'Destination', example: 'Entrepôt Frigombal Yaoundé'),
                        new OA\Property(property: 'h_depart', type: 'string', format: 'time', description: 'Heure départ', example: '07:30:00'),
                        new OA\Property(property: 'h_arrivee', type: 'string', format: 'time', description: 'Heure arrivée', example: '15:45:00'),
                        new OA\Property(property: 'nom_inspecteur', type: 'string', description: 'Nom inspecteur', example: 'Ongolo Marie Thérèse'),
                        new OA\Property(property: 'approuvee', type: 'boolean', description: 'Statut approbation', example: true)
                    ],
                    example: [
                        'id' => 1,
                        'matricule' => '20251025001',
                        'numero_recu' => 'RC20251025001',
                        'lieu_emission' => 'Terminal à Conteneurs du Port de Douala',
                        'date_emission' => '2025-10-25',
                        'r_organisation' => 'SARL Transport Cameroun',
                        'r_nationalite' => 'Camerounaise',
                        'r_addresse' => 'Zone Portuaire Bonabéri, BP 2345 Douala',
                        'r_telephone' => '+237690234567',
                        'v_matricule' => 'CM-2025-TR-4567',
                        'type_charge' => 'Conteneurs frigorifiques',
                        'tonnage_kg' => '25000',
                        'signalisation' => true,
                        'couverture' => true,
                        'p_depart' => 'Quai 5 - Terminal Conteneurs',
                        'p_arrivee' => 'Entrepôt Frigombal Yaoundé',
                        'h_depart' => '07:30:00',
                        'h_arrivee' => '15:45:00',
                        'nom_inspecteur' => 'Ongolo Marie Thérèse',
                        'approuvee' => true
                    ]
                )
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
    public function show(SurveillanceChargement $surveillance): JsonResponse
    {
        return $this->json([
            'success' => true,
            'data' => $surveillance
        ], context: ['groups' => ['api_surveillance_chargement']]);
    }































    #[Route('/{id}/edit', name: 'app_surveillance_chargement_edit', methods: ['PUT', 'PATCH'])]
    #[OA\Put(
        path: '/api/surveillance/chargement/{id}/edit',
        summary: 'Met à jour une surveillance existante',
        description: 'Modifie les informations d\'une surveillance de chargement existante. Mise à jour partielle ou complète autorisée.',
        tags: ['Surveillance Chargement']
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
        description: 'Données à mettre à jour (mise à jour partielle autorisée)',
        content: new OA\JsonContent(
            type: 'object',
            properties: [
                new OA\Property(property: 'lieu_emission', type: 'string', description: 'Nouveau lieu d\'émission', example: 'Terminal Pétrolier de Limbe', maxLength: 255),
                new OA\Property(property: 'r_organisation', type: 'string', description: 'Nouvelle organisation responsable', example: 'Cameroon Oil Transportation Ltd', maxLength: 255),
                new OA\Property(property: 'r_addresse', type: 'string', description: 'Nouvelle adresse', example: 'Zone Industrielle de Limbe, BP 567 Limbe', maxLength: 255),
                new OA\Property(property: 'r_telephone', type: 'string', description: 'Nouveau téléphone', example: '+237655987654', maxLength: 13),
                new OA\Property(property: 'v_matricule', type: 'string', description: 'Nouveau matricule véhicule', example: 'CM-2025-LB-3456', maxLength: 255),
                new OA\Property(property: 'type_charge', type: 'string', description: 'Nouveau type de marchandise', example: 'Produits pétroliers raffinés', maxLength: 255),
                new OA\Property(property: 'tonnage_kg', type: 'string', description: 'Nouveau tonnage', example: '35000', maxLength: 255),
                new OA\Property(property: 'signalisation', type: 'boolean', description: 'Mise à jour conformité signalisation', example: false),
                new OA\Property(property: 'couverture', type: 'boolean', description: 'Mise à jour conformité protection', example: true),
                new OA\Property(property: 'p_depart', type: 'string', description: 'Nouveau point de départ', example: 'Raffinerie SONARA Limbe', maxLength: 255),
                new OA\Property(property: 'p_arrivee', type: 'string', description: 'Nouvelle destination', example: 'Dépôt Total Garoua', maxLength: 255),
                new OA\Property(property: 'h_depart', type: 'string', format: 'time', description: 'Nouvelle heure de départ', example: '10:00:00'),
                new OA\Property(property: 'h_arrivee', type: 'string', format: 'time', description: 'Nouvelle heure d\'arrivée', example: '20:15:00'),
                new OA\Property(property: 'nom_inspecteur', type: 'string', description: 'Nouvel inspecteur', example: 'Kamga Vincent', maxLength: 255),
                new OA\Property(property: 'approuvee', type: 'boolean', description: 'Nouveau statut d\'approbation', example: false)
            ],
            example: [
                'lieu_emission' => 'Terminal Pétrolier de Limbe',
                'r_organisation' => 'Cameroon Oil Transportation Ltd',
                'r_addresse' => 'Zone Industrielle de Limbe, BP 567 Limbe',
                'r_telephone' => '+237655987654',
                'type_charge' => 'Produits pétroliers raffinés',
                'tonnage_kg' => '35000',
                'signalisation' => false,
                'p_arrivee' => 'Dépôt Total Garoua',
                'h_arrivee' => '20:15:00',
                'nom_inspecteur' => 'Kamga Vincent',
                'approuvee' => false
            ]
        )
    )]
    #[OA\Response(
        response: 200,
        description: 'Surveillance mise à jour avec succès',
        content: new OA\JsonContent(
            type: 'object',
            properties: [
                new OA\Property(property: 'success', type: 'boolean', description: 'Statut de la mise à jour', example: true),
                new OA\Property(property: 'message', type: 'string', description: 'Message de confirmation', example: 'Surveillance Chargement mise à jour avec succès'),
                new OA\Property(
                    property: 'data', 
                    type: 'object',
                    description: 'Données de la surveillance mise à jour',
                    example: [
                        'id' => 1,
                        'matricule' => '20251025001',
                        'numero_recu' => 'RC20251025001',
                        'lieu_emission' => 'Terminal Pétrolier de Limbe',
                        'date_emission' => '2025-10-25',
                        'r_organisation' => 'Cameroon Oil Transportation Ltd',
                        'r_nationalite' => 'Camerounaise',
                        'r_addresse' => 'Zone Industrielle de Limbe, BP 567 Limbe',
                        'r_telephone' => '+237655987654',
                        'v_matricule' => 'CM-2025-TR-4567',
                        'type_charge' => 'Produits pétroliers raffinés',
                        'tonnage_kg' => '35000',
                        'signalisation' => false,
                        'couverture' => true,
                        'p_depart' => 'Quai 5 - Terminal Conteneurs',
                        'p_arrivee' => 'Dépôt Total Garoua',
                        'h_depart' => '07:30:00',
                        'h_arrivee' => '20:15:00',
                        'nom_inspecteur' => 'Kamga Vincent',
                        'approuvee' => false
                    ]
                )
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
        response: 400,
        description: 'Données de requête invalides',
        content: new OA\JsonContent(
            type: 'object',
            properties: [
                new OA\Property(property: 'success', type: 'boolean', example: false),
                new OA\Property(property: 'message', type: 'string', example: 'Erreur de validation: format de téléphone invalide ou tonnage non numérique')
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
    public function edit(Request $request, SurveillanceChargement $surveillance, EntityManagerInterface $entityManager): JsonResponse
    {
        try {
            $this->serializer->deserialize(
                $request->getContent(),
                SurveillanceChargement::class,
                'json',
                ['object_to_populate' => $surveillance, 'groups' => ['api_surveillance_chargement']]
            );

            $entityManager->flush();

            return $this->json([
                'success' => true,
                'message' => 'Surveillance Chargement mise à jour avec succès',
                'data' => $surveillance
            ], context: ['groups' => ['api_surveillance_chargement']]);
            
        } catch (\Exception $e) {
            return $this->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour: ' . $e->getMessage()
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

























    #[Route('/{id}', name: 'app_surveillance_chargement_delete', methods: ['DELETE'])]
    #[OA\Delete(
        path: '/api/surveillance/chargement/{id}',
        summary: 'Supprime une surveillance',
        description: 'Supprime définitivement une surveillance de chargement du système',
        tags: ['Surveillance Chargement']
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
                new OA\Property(property: 'success', type: 'boolean', description: 'Statut de la suppression', example: true),
                new OA\Property(property: 'message', type: 'string', description: 'Message de confirmation', example: 'Surveillance Chargement supprimée avec succès')
            ],
            example: [
                'success' => true,
                'message' => 'Surveillance Chargement supprimée avec succès'
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
                new OA\Property(property: 'message', type: 'string', example: 'Erreur lors de la suppression: contrainte de base de données ou surveillance référencée')
            ]
        )
    )]
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
<?php

namespace App\Controller\api;

use App\Entity\AutorisationMateriauxConstruction;
use App\Repository\AutorisationMateriauxConstructionRepository;
use Doctrine\ORM\EntityManagerInterface;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;


    
#[Route('/api/autorisation/materiauxconstruction')]
#[OA\Tag(name: 'Autorisation Matériaux Construction')]
final class ApiAutorisationMateriauxConstructionController extends AbstractController
{
    public function __construct(private SerializerInterface $serializer)
    {
    }


    #[Route(name: 'app_autorisation_materiaux_construction_index', methods: ['GET'])]
    #[OA\Get(
        path: '/api/autorisation/materiauxconstruction',
        summary: 'Liste toutes les autorisations de matériaux de construction',
        description: 'Récupère la liste complète des autorisations pour l\'importation et le transport de matériaux de construction (ciment, fer à béton, bois, etc.)',
        tags: ['Autorisation Matériaux Construction']
    )]
    #[OA\Response(
        response: 200,
        description: 'Liste des autorisations récupérée avec succès',
        content: new OA\JsonContent(
            type: 'object',
            properties: [
                new OA\Property(property: 'success', type: 'boolean', description: 'Statut de la requête', example: true),
                new OA\Property(
                    property: 'data', 
                    type: 'array', 
                    description: 'Liste des autorisations de matériaux',
                    items: new OA\Items(
                        type: 'object',
                        properties: [
                            new OA\Property(property: 'id', type: 'integer', description: 'ID unique de l\'autorisation', example: 1),
                            new OA\Property(property: 'matricule', type: 'string', description: 'Numéro de matricule', example: '202412001'),
                            new OA\Property(property: 'lieu_emission', type: 'string', description: 'Lieu d\'émission', example: 'Port de Douala'),
                            new OA\Property(property: 'date_emission', type: 'string', format: 'date', description: 'Date d\'émission', example: '2024-12-15'),
                            new OA\Property(property: 'r_type', type: 'string', description: 'Type de requérant', example: 'Entreprise'),
                            new OA\Property(property: 'r_nationalite', type: 'string', description: 'Nationalité du requérant', example: 'Camerounaise'),
                            new OA\Property(property: 'r_addresse', type: 'string', description: 'Adresse complète', example: 'Quartier Bonanjo, Rue des Cocotiers, BP 1234 Douala'),
                            new OA\Property(property: 'r_telephone', type: 'string', description: 'Numéro de téléphone', example: '+237699123456'),
                            new OA\Property(property: 'v_matricule', type: 'string', description: 'Matricule du véhicule', example: 'LT-234-CD'),
                            new OA\Property(property: 'v_marque', type: 'string', description: 'Marque du véhicule', example: 'Mercedes Actros'),
                            new OA\Property(property: 'v_type', type: 'string', description: 'Type de véhicule', example: 'Camion benne'),
                            new OA\Property(property: 'type_charge', type: 'string', description: 'Type de matériaux', example: 'Ciment Portland - Sacs de 50kg'),
                            new OA\Property(property: 'tonnage_kg', type: 'string', description: 'Tonnage en kg', example: '25000'),
                            new OA\Property(property: 'r_securite', type: 'string', description: 'Mesures de sécurité', example: 'Bâchage étanche + Arrimage renforcé'),
                            new OA\Property(property: 'heure_circulation', type: 'string', description: 'Heures autorisées', example: '06h00 - 18h00'),
                            new OA\Property(property: 'p_depart', type: 'string', description: 'Point de départ', example: 'Cimenterie CIMENCAM Bonabéri'),
                            new OA\Property(property: 'p_arrivee', type: 'string', description: 'Point d\'arrivée', example: 'Chantier Centre Commercial Akwa'),
                            new OA\Property(property: 'h_depart', type: 'string', format: 'time', description: 'Heure de départ', example: '07:30:00'),
                            new OA\Property(property: 'h_arrivee', type: 'string', format: 'time', description: 'Heure d\'arrivée prévue', example: '09:15:00'),
                            new OA\Property(property: 'arrimage', type: 'boolean', description: 'Arrimage conforme', example: true),
                            new OA\Property(property: 'centrage', type: 'boolean', description: 'Centrage vérifié', example: true),
                            new OA\Property(property: 'signalisation', type: 'boolean', description: 'Signalisation en place', example: true),
                            new OA\Property(property: 'charge_technique', type: 'string', description: 'Caractéristiques techniques', example: 'Ciment CEM II/B-LL 32.5R - Conditionnement palettisé')
                        ]
                    )
                )
            ],
            example: [
                'success' => true,
                'data' => [
                    [
                        'id' => 1,
                        'matricule' => '202412001',
                        'lieu_emission' => 'Port de Douala',
                        'date_emission' => '2024-12-15',
                        'r_type' => 'Entreprise',
                        'r_nationalite' => 'Camerounaise',
                        'r_addresse' => 'Quartier Bonanjo, Rue des Cocotiers, BP 1234 Douala',
                        'r_telephone' => '+237699123456',
                        'v_matricule' => 'LT-234-CD',
                        'v_marque' => 'Mercedes Actros',
                        'v_type' => 'Camion benne',
                        'type_charge' => 'Ciment Portland - Sacs de 50kg',
                        'tonnage_kg' => '25000',
                        'r_securite' => 'Bâchage étanche + Arrimage renforcé',
                        'heure_circulation' => '06h00 - 18h00',
                        'p_depart' => 'Cimenterie CIMENCAM Bonabéri',
                        'p_arrivee' => 'Chantier Centre Commercial Akwa',
                        'h_depart' => '07:30:00',
                        'h_arrivee' => '09:15:00',
                        'arrimage' => true,
                        'centrage' => true,
                        'signalisation' => true,
                        'charge_technique' => 'Ciment CEM II/B-LL 32.5R - Conditionnement palettisé'
                    ],
                    [
                        'id' => 2,
                        'matricule' => '202412002',
                        'lieu_emission' => 'Bureau Régional Centre',
                        'date_emission' => '2024-12-15',
                        'r_type' => 'Société',
                        'r_nationalite' => 'Camerounaise',
                        'r_addresse' => 'Zone Industrielle Bassa, Route de Kribi, BP 5678 Douala',
                        'r_telephone' => '+237677987654',
                        'v_matricule' => 'CE-567-AB',
                        'v_marque' => 'Volvo FH16',
                        'v_type' => 'Semi-remorque plateau',
                        'type_charge' => 'Fer à béton HA - Barres de 12m',
                        'tonnage_kg' => '40000',
                        'r_securite' => 'Sangles métalliques + Protection anti-rouille',
                        'heure_circulation' => '05h00 - 19h00',
                        'p_depart' => 'Aciérie ALUCAM Edéa',
                        'p_arrivee' => 'Projet Logements Sociaux Yaoundé',
                        'h_depart' => '05:30:00',
                        'h_arrivee' => '11:45:00',
                        'arrimage' => true,
                        'centrage' => true,
                        'signalisation' => true,
                        'charge_technique' => 'Acier haute adhérence FeE500 - Ø10-Ø32mm'
                    ]
                ]
            ]
        )
    )]
    #[OA\Response(
        response: 500,
        description: 'Erreur serveur lors de la récupération',
        content: new OA\JsonContent(
            type: 'object',
            properties: [
                new OA\Property(property: 'success', type: 'boolean', example: false),
                new OA\Property(property: 'message', type: 'string', example: 'Erreur lors de la récupération des autorisations')
            ]
        )
    )]
    public function index(AutorisationMateriauxConstructionRepository $autorisationMateriauxConstructionRepository): JsonResponse
    {
        $autorisations = $autorisationMateriauxConstructionRepository->findAll();
        
        return $this->json([
            'success' => true,
            'data' => $autorisations
        ], context: ['groups' => ['api_autorisation_materiaux']]);
    }
















    
    #[Route('/new', name: 'app_autorisation_materiaux_construction_new', methods: ['POST'])]
    #[OA\Post(
        path: '/api/autorisation/materiauxconstruction/new',
        summary: 'Crée une nouvelle autorisation de matériaux de construction',
        description: 'Génère une autorisation pour l\'importation/transport de matériaux de construction avec validation des normes techniques et de sécurité',
        tags: ['Autorisation Matériaux Construction']
    )]
    #[OA\RequestBody(
        required: true,
        description: 'Informations complètes pour l\'autorisation de matériaux',
        content: new OA\JsonContent(
            type: 'object',
            required: ['matricule', 'lieu_emission', 'date_emission', 'r_type', 'r_nationalite', 'r_addresse', 'r_telephone', 'v_matricule', 'v_marque', 'v_type', 'type_charge', 'tonnage_kg', 'r_securite', 'heure_circulation', 'p_depart', 'p_arrivee', 'h_depart', 'h_arrivee', 'arrimage', 'centrage', 'signalisation', 'charge_technique'],
            properties: [
                new OA\Property(property: 'matricule', type: 'string', description: 'Numéro de matricule unique', example: '202412003'),
                new OA\Property(property: 'lieu_emission', type: 'string', description: 'Bureau d\'émission', example: 'Direction Régionale du Littoral'),
                new OA\Property(property: 'date_emission', type: 'string', format: 'date', description: 'Date d\'émission', example: '2024-12-16'),
                new OA\Property(property: 'r_type', type: 'string', description: 'Type de requérant', example: 'SARL'),
                new OA\Property(property: 'r_nationalite', type: 'string', description: 'Nationalité', example: 'Camerounaise'),
                new OA\Property(property: 'r_addresse', type: 'string', description: 'Adresse complète du requérant', example: 'Zone Industrielle Japoma, Avenue des Bâtisseurs, BP 9876 Douala'),
                new OA\Property(property: 'r_telephone', type: 'string', description: 'Contact téléphonique', example: '+237655443322'),
                new OA\Property(property: 'v_matricule', type: 'string', description: 'Immatriculation du véhicule', example: 'BT-789-XY'),
                new OA\Property(property: 'v_marque', type: 'string', description: 'Marque et modèle', example: 'Scania R450'),
                new OA\Property(property: 'v_type', type: 'string', description: 'Type de véhicule', example: 'Camion citerne'),
                new OA\Property(property: 'type_charge', type: 'string', description: 'Nature des matériaux', example: 'Bitume routier - Grade 60/70'),
                new OA\Property(property: 'tonnage_kg', type: 'string', description: 'Poids total en kg', example: '32000'),
                new OA\Property(property: 'r_securite', type: 'string', description: 'Dispositifs de sécurité', example: 'Citerne étanche + Vannes anti-débordement + Kit anti-pollution'),
                new OA\Property(property: 'heure_circulation', type: 'string', description: 'Créneaux autorisés', example: '22h00 - 05h00 (circulation nocturne obligatoire)'),
                new OA\Property(property: 'p_depart', type: 'string', description: 'Point de chargement', example: 'Raffinerie SONARA Limbé'),
                new OA\Property(property: 'p_arrivee', type: 'string', description: 'Destination finale', example: 'Chantier Autoroute Yaoundé-Douala Km 15'),
                new OA\Property(property: 'h_depart', type: 'string', format: 'time', description: 'Heure de départ', example: '22:30:00'),
                new OA\Property(property: 'h_arrivee', type: 'string', format: 'time', description: 'Heure d\'arrivée estimée', example: '04:15:00'),
                new OA\Property(property: 'arrimage', type: 'boolean', description: 'Arrimage conforme aux normes', example: true),
                new OA\Property(property: 'centrage', type: 'boolean', description: 'Répartition équilibrée de la charge', example: true),
                new OA\Property(property: 'signalisation', type: 'boolean', description: 'Signalisation matières dangereuses', example: true),
                new OA\Property(property: 'charge_technique', type: 'string', description: 'Spécifications techniques détaillées', example: 'Bitume routier 60/70 - Température transport 140-160°C - Citerne chauffante isolée')
            ],
            example: [
                'matricule' => '202412003',
                'lieu_emission' => 'Direction Régionale du Littoral',
                'date_emission' => '2024-12-16',
                'r_type' => 'SARL',
                'r_nationalite' => 'Camerounaise',
                'r_addresse' => 'Zone Industrielle Japoma, Avenue des Bâtisseurs, BP 9876 Douala',
                'r_telephone' => '+237655443322',
                'v_matricule' => 'BT-789-XY',
                'v_marque' => 'Scania R450',
                'v_type' => 'Camion citerne',
                'type_charge' => 'Bitume routier - Grade 60/70',
                'tonnage_kg' => '32000',
                'r_securite' => 'Citerne étanche + Vannes anti-débordement + Kit anti-pollution',
                'heure_circulation' => '22h00 - 05h00 (circulation nocturne obligatoire)',
                'p_depart' => 'Raffinerie SONARA Limbé',
                'p_arrivee' => 'Chantier Autoroute Yaoundé-Douala Km 15',
                'h_depart' => '22:30:00',
                'h_arrivee' => '04:15:00',
                'arrimage' => true,
                'centrage' => true,
                'signalisation' => true,
                'charge_technique' => 'Bitume routier 60/70 - Température transport 140-160°C - Citerne chauffante isolée'
            ]
        )
    )]
    #[OA\Response(
        response: 201,
        description: 'Autorisation créée avec succès',
        content: new OA\JsonContent(
            type: 'object',
            properties: [
                new OA\Property(property: 'success', type: 'boolean', description: 'Statut de création', example: true),
                new OA\Property(property: 'message', type: 'string', description: 'Message de confirmation', example: 'Autorisation Matériaux Construction créée avec succès'),
                new OA\Property(
                    property: 'data', 
                    type: 'object',
                    description: 'Autorisation créée avec ID généré',
                    example: [
                        'id' => 3,
                        'matricule' => '202412003',
                        'lieu_emission' => 'Direction Régionale du Littoral',
                        'date_emission' => '2024-12-16',
                        'r_type' => 'SARL',
                        'r_nationalite' => 'Camerounaise',
                        'r_addresse' => 'Zone Industrielle Japoma, Avenue des Bâtisseurs, BP 9876 Douala',
                        'r_telephone' => '+237655443322',
                        'v_matricule' => 'BT-789-XY',
                        'v_marque' => 'Scania R450',
                        'v_type' => 'Camion citerne',
                        'type_charge' => 'Bitume routier - Grade 60/70',
                        'tonnage_kg' => '32000',
                        'r_securite' => 'Citerne étanche + Vannes anti-débordement + Kit anti-pollution',
                        'heure_circulation' => '22h00 - 05h00 (circulation nocturne obligatoire)',
                        'p_depart' => 'Raffinerie SONARA Limbé',
                        'p_arrivee' => 'Chantier Autoroute Yaoundé-Douala Km 15',
                        'h_depart' => '22:30:00',
                        'h_arrivee' => '04:15:00',
                        'arrimage' => true,
                        'centrage' => true,
                        'signalisation' => true,
                        'charge_technique' => 'Bitume routier 60/70 - Température transport 140-160°C - Citerne chauffante isolée'
                    ]
                )
            ]
        )
    )]
    #[OA\Response(
        response: 400,
        description: 'Données invalides',
        content: new OA\JsonContent(
            type: 'object',
            properties: [
                new OA\Property(property: 'success', type: 'boolean', example: false),
                new OA\Property(property: 'message', type: 'string', example: 'Données manquantes: tonnage_kg requis, véhicule non conforme aux normes de transport de matériaux')
            ]
        )
    )]
    #[OA\Response(
        response: 409,
        description: 'Conflit - Matricule déjà existant',
        content: new OA\JsonContent(
            type: 'object',
            properties: [
                new OA\Property(property: 'success', type: 'boolean', example: false),
                new OA\Property(property: 'message', type: 'string', example: 'Le matricule 202412003 existe déjà dans le système')
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
                new OA\Property(property: 'message', type: 'string', example: 'Erreur lors de la création: violation de contrainte base de données')
            ]
        )
    )]
    public function new(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        try {
            $autorisation = $this->serializer->deserialize(
                $request->getContent(),
                AutorisationMateriauxConstruction::class,
                'json',
                ['groups' => ['api_autorisation_materiaux']]
            );

            $entityManager->persist($autorisation);
            $entityManager->flush();

            return $this->json([
                'success' => true,
                'message' => 'Autorisation Matériaux Construction créée avec succès',
                'data' => $autorisation
            ], JsonResponse::HTTP_CREATED, context: ['groups' => ['api_autorisation_materiaux']]);
            
        } catch (\Exception $e) {
            return $this->json([
                'success' => false,
                'message' => 'Erreur lors de la création: ' . $e->getMessage()
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
















    
    #[Route('/{id}', name: 'app_autorisation_materiaux_construction_show', methods: ['GET'])]
    #[OA\Get(
        path: '/api/autorisation/materiauxconstruction/{id}',
        summary: 'Récupère une autorisation spécifique',
        description: 'Affiche les détails complets d\'une autorisation de matériaux de construction avec toutes les spécifications techniques et réglementaires',
        tags: ['Autorisation Matériaux Construction']
    )]
    #[OA\Parameter(
        name: 'id',
        description: 'Identifiant unique de l\'autorisation à consulter',
        in: 'path',
        required: true,
        schema: new OA\Schema(type: 'integer', minimum: 1),
        example: 1
    )]
    #[OA\Response(
        response: 200,
        description: 'Autorisation trouvée avec succès',
        content: new OA\JsonContent(
            type: 'object',
            properties: [
                new OA\Property(property: 'success', type: 'boolean', description: 'Statut de la requête', example: true),
                new OA\Property(
                    property: 'data', 
                    type: 'object',
                    description: 'Détails complets de l\'autorisation',
                    properties: [
                        new OA\Property(property: 'id', type: 'integer', description: 'ID unique', example: 1),
                        new OA\Property(property: 'matricule', type: 'string', description: 'Numéro de matricule', example: '202412001'),
                        new OA\Property(property: 'lieu_emission', type: 'string', description: 'Bureau émetteur', example: 'Port de Douala'),
                        new OA\Property(property: 'date_emission', type: 'string', format: 'date', description: 'Date d\'émission', example: '2024-12-15'),
                        new OA\Property(property: 'r_type', type: 'string', description: 'Type de requérant', example: 'Entreprise'),
                        new OA\Property(property: 'r_nationalite', type: 'string', description: 'Nationalité', example: 'Camerounaise'),
                        new OA\Property(property: 'r_addresse', type: 'string', description: 'Adresse complète', example: 'Quartier Bonanjo, Rue des Cocotiers, BP 1234 Douala'),
                        new OA\Property(property: 'r_telephone', type: 'string', description: 'Contact téléphonique', example: '+237699123456'),
                        new OA\Property(property: 'v_matricule', type: 'string', description: 'Immatriculation véhicule', example: 'LT-234-CD'),
                        new OA\Property(property: 'v_marque', type: 'string', description: 'Marque du véhicule', example: 'Mercedes Actros'),
                        new OA\Property(property: 'v_type', type: 'string', description: 'Type de véhicule', example: 'Camion benne'),
                        new OA\Property(property: 'type_charge', type: 'string', description: 'Type de matériaux transportés', example: 'Ciment Portland - Sacs de 50kg'),
                        new OA\Property(property: 'tonnage_kg', type: 'string', description: 'Tonnage autorisé', example: '25000'),
                        new OA\Property(property: 'r_securite', type: 'string', description: 'Mesures de sécurité', example: 'Bâchage étanche + Arrimage renforcé'),
                        new OA\Property(property: 'heure_circulation', type: 'string', description: 'Heures de circulation', example: '06h00 - 18h00'),
                        new OA\Property(property: 'p_depart', type: 'string', description: 'Point de départ', example: 'Cimenterie CIMENCAM Bonabéri'),
                        new OA\Property(property: 'p_arrivee', type: 'string', description: 'Destination', example: 'Chantier Centre Commercial Akwa'),
                        new OA\Property(property: 'h_depart', type: 'string', format: 'time', description: 'Heure de départ', example: '07:30:00'),
                        new OA\Property(property: 'h_arrivee', type: 'string', format: 'time', description: 'Heure d\'arrivée', example: '09:15:00'),
                        new OA\Property(property: 'arrimage', type: 'boolean', description: 'Arrimage conforme', example: true),
                        new OA\Property(property: 'centrage', type: 'boolean', description: 'Centrage vérifié', example: true),
                        new OA\Property(property: 'signalisation', type: 'boolean', description: 'Signalisation en place', example: true),
                        new OA\Property(property: 'charge_technique', type: 'string', description: 'Caractéristiques techniques', example: 'Ciment CEM II/B-LL 32.5R - Conditionnement palettisé')
                    ],
                    example: [
                        'id' => 1,
                        'matricule' => '202412001',
                        'lieu_emission' => 'Port de Douala',
                        'date_emission' => '2024-12-15',
                        'r_type' => 'Entreprise',
                        'r_nationalite' => 'Camerounaise',
                        'r_addresse' => 'Quartier Bonanjo, Rue des Cocotiers, BP 1234 Douala',
                        'r_telephone' => '+237699123456',
                        'v_matricule' => 'LT-234-CD',
                        'v_marque' => 'Mercedes Actros',
                        'v_type' => 'Camion benne',
                        'type_charge' => 'Ciment Portland - Sacs de 50kg',
                        'tonnage_kg' => '25000',
                        'r_securite' => 'Bâchage étanche + Arrimage renforcé',
                        'heure_circulation' => '06h00 - 18h00',
                        'p_depart' => 'Cimenterie CIMENCAM Bonabéri',
                        'p_arrivee' => 'Chantier Centre Commercial Akwa',
                        'h_depart' => '07:30:00',
                        'h_arrivee' => '09:15:00',
                        'arrimage' => true,
                        'centrage' => true,
                        'signalisation' => true,
                        'charge_technique' => 'Ciment CEM II/B-LL 32.5R - Conditionnement palettisé'
                    ]
                )
            ]
        )
    )]
    #[OA\Response(
        response: 404, 
        description: 'Autorisation non trouvée',
        content: new OA\JsonContent(
            type: 'object',
            properties: [
                new OA\Property(property: 'success', type: 'boolean', example: false),
                new OA\Property(property: 'message', type: 'string', example: 'Aucune autorisation trouvée avec l\'ID 999')
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
                new OA\Property(property: 'message', type: 'string', example: 'Erreur lors de la récupération des données')
            ]
        )
    )]
    public function show(AutorisationMateriauxConstruction $autorisation): JsonResponse
    {
        return $this->json([
            'success' => true,
            'data' => $autorisation
        ], context: ['groups' => ['api_autorisation_materiaux']]);
    }
















    
    #[Route('/{id}/edit', name: 'app_autorisation_materiaux_construction_edit', methods: ['PUT', 'PATCH'])]
    #[OA\Put(
        path: '/api/autorisation/materiauxconstruction/{id}/edit',
        summary: 'Met à jour une autorisation existante',
        description: 'Modifie les informations d\'une autorisation de matériaux (changement d\'itinéraire, horaires, tonnage, spécifications techniques)',
        tags: ['Autorisation Matériaux Construction']
    )]
    #[OA\Parameter(
        name: 'id',
        description: 'Identifiant de l\'autorisation à modifier',
        in: 'path',
        required: true,
        schema: new OA\Schema(type: 'integer', minimum: 1),
        example: 1
    )]
    #[OA\RequestBody(
        required: true,
        description: 'Champs à mettre à jour (modification partielle autorisée)',
        content: new OA\JsonContent(
            type: 'object',
            properties: [
                new OA\Property(property: 'tonnage_kg', type: 'string', description: 'Nouveau tonnage autorisé', example: '30000'),
                new OA\Property(property: 'type_charge', type: 'string', description: 'Matériaux modifiés', example: 'Ciment Portland + Sable fin de rivière - Mélange chantier'),
                new OA\Property(property: 'p_arrivee', type: 'string', description: 'Nouvelle destination', example: 'Chantier Résidence Les Palmiers Bonapriso'),
                new OA\Property(property: 'h_depart', type: 'string', format: 'time', description: 'Nouvel horaire de départ', example: '06:00:00'),
                new OA\Property(property: 'h_arrivee', type: 'string', format: 'time', description: 'Nouvel horaire d\'arrivée', example: '08:30:00'),
                new OA\Property(property: 'r_securite', type: 'string', description: 'Mesures de sécurité renforcées', example: 'Bâchage étanche + Arrimage renforcé + Escort sécurisé'),
                new OA\Property(property: 'charge_technique', type: 'string', description: 'Spécifications techniques actualisées', example: 'Ciment CEM II/B-LL 32.5R + Sable 0/4mm - Conditionnement Big-Bag et palettes')
            ],
            example: [
                'tonnage_kg' => '30000',
                'type_charge' => 'Ciment Portland + Sable fin de rivière - Mélange chantier',
                'p_arrivee' => 'Chantier Résidence Les Palmiers Bonapriso',
                'h_depart' => '06:00:00',
                'h_arrivee' => '08:30:00',
                'r_securite' => 'Bâchage étanche + Arrimage renforcé + Escort sécurisé',
                'charge_technique' => 'Ciment CEM II/B-LL 32.5R + Sable 0/4mm - Conditionnement Big-Bag et palettes'
            ]
        )
    )]
    #[OA\Response(
        response: 200,
        description: 'Autorisation mise à jour avec succès',
        content: new OA\JsonContent(
            type: 'object',
            properties: [
                new OA\Property(property: 'success', type: 'boolean', description: 'Statut de la modification', example: true),
                new OA\Property(property: 'message', type: 'string', description: 'Message de confirmation', example: 'Autorisation Matériaux Construction mise à jour avec succès'),
                new OA\Property(
                    property: 'data', 
                    type: 'object',
                    description: 'Autorisation modifiée',
                    example: [
                        'id' => 1,
                        'matricule' => '202412001',
                        'lieu_emission' => 'Port de Douala',
                        'date_emission' => '2024-12-15',
                        'r_type' => 'Entreprise',
                        'r_nationalite' => 'Camerounaise',
                        'r_addresse' => 'Quartier Bonanjo, Rue des Cocotiers, BP 1234 Douala',
                        'r_telephone' => '+237699123456',
                        'v_matricule' => 'LT-234-CD',
                        'v_marque' => 'Mercedes Actros',
                        'v_type' => 'Camion benne',
                        'type_charge' => 'Ciment Portland + Sable fin de rivière - Mélange chantier',
                        'tonnage_kg' => '30000',
                        'r_securite' => 'Bâchage étanche + Arrimage renforcé + Escort sécurisé',
                        'heure_circulation' => '06h00 - 18h00',
                        'p_depart' => 'Cimenterie CIMENCAM Bonabéri',
                        'p_arrivee' => 'Chantier Résidence Les Palmiers Bonapriso',
                        'h_depart' => '06:00:00',
                        'h_arrivee' => '08:30:00',
                        'arrimage' => true,
                        'centrage' => true,
                        'signalisation' => true,
                        'charge_technique' => 'Ciment CEM II/B-LL 32.5R + Sable 0/4mm - Conditionnement Big-Bag et palettes'
                    ]
                )
            ]
        )
    )]
    #[OA\Response(
        response: 400,
        description: 'Données de modification invalides',
        content: new OA\JsonContent(
            type: 'object',
            properties: [
                new OA\Property(property: 'success', type: 'boolean', example: false),
                new OA\Property(property: 'message', type: 'string', example: 'Tonnage dépassant la capacité autorisée du véhicule, horaires incompatibles avec les restrictions de circulation')
            ]
        )
    )]
    #[OA\Response(
        response: 404, 
        description: 'Autorisation non trouvée',
        content: new OA\JsonContent(
            type: 'object',
            properties: [
                new OA\Property(property: 'success', type: 'boolean', example: false),
                new OA\Property(property: 'message', type: 'string', example: 'Autorisation avec l\'ID 999 non trouvée')
            ]
        )
    )]
    #[OA\Response(
        response: 409,
        description: 'Conflit - Modification interdite',
        content: new OA\JsonContent(
            type: 'object',
            properties: [
                new OA\Property(property: 'success', type: 'boolean', example: false),
                new OA\Property(property: 'message', type: 'string', example: 'Impossible de modifier: transport en cours ou autorisation déjà utilisée')
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
                new OA\Property(property: 'message', type: 'string', example: 'Erreur lors de la mise à jour: contrainte réglementaire')
            ]
        )
    )]
    public function edit(Request $request, AutorisationMateriauxConstruction $autorisation, EntityManagerInterface $entityManager): JsonResponse
    {
        try {
            $this->serializer->deserialize(
                $request->getContent(),
                AutorisationMateriauxConstruction::class,
                'json',
                ['object_to_populate' => $autorisation, 'groups' => ['api_autorisation_materiaux']]
            );

            $entityManager->flush();

            return $this->json([
                'success' => true,
                'message' => 'Autorisation Matériaux Construction mise à jour avec succès',
                'data' => $autorisation
            ], context: ['groups' => ['api_autorisation_materiaux']]);
            
        } catch (\Exception $e) {
            return $this->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour: ' . $e->getMessage()
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
















    
    #[Route('/{id}', name: 'app_autorisation_materiaux_construction_delete', methods: ['DELETE'])]
    #[OA\Delete(
        path: '/api/autorisation/materiauxconstruction/{id}',
        summary: 'Supprime une autorisation',
        description: 'Suppression définitive d\'une autorisation de matériaux de construction (opération critique avec vérifications de sécurité)',
        tags: ['Autorisation Matériaux Construction']
    )]
    #[OA\Parameter(
        name: 'id',
        description: 'Identifiant unique de l\'autorisation à supprimer',
        in: 'path',
        required: true,
        schema: new OA\Schema(type: 'integer', minimum: 1),
        example: 1
    )]
    #[OA\Response(
        response: 200,
        description: 'Autorisation supprimée avec succès',
        content: new OA\JsonContent(
            type: 'object',
            properties: [
                new OA\Property(property: 'success', type: 'boolean', description: 'Statut de la suppression', example: true),
                new OA\Property(property: 'message', type: 'string', description: 'Message de confirmation', example: 'Autorisation Matériaux Construction supprimée avec succès')
            ],
            example: [
                'success' => true,
                'message' => 'Autorisation Matériaux Construction supprimée avec succès'
            ]
        )
    )]
    #[OA\Response(
        response: 404, 
        description: 'Autorisation non trouvée',
        content: new OA\JsonContent(
            type: 'object',
            properties: [
                new OA\Property(property: 'success', type: 'boolean', example: false),
                new OA\Property(property: 'message', type: 'string', example: 'Autorisation avec l\'ID 999 non trouvée')
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
                new OA\Property(property: 'message', type: 'string', example: 'Impossible de supprimer: transport de matériaux en cours ou autorisation référencée dans des rapports de chantier')
            ]
        )
    )]
    #[OA\Response(
        response: 422,
        description: 'Contraintes réglementaires',
        content: new OA\JsonContent(
            type: 'object',
            properties: [
                new OA\Property(property: 'success', type: 'boolean', example: false),
                new OA\Property(property: 'message', type: 'string', example: 'Suppression interdite: autorisation liée à un dossier d\'importation en cours de vérification douanière')
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
                new OA\Property(property: 'message', type: 'string', example: 'Erreur lors de la suppression: contrainte d\'intégrité base de données ou archive réglementaire obligatoire')
            ]
        )
    )]
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
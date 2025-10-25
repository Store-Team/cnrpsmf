<?php

namespace App\Controller\api;

use App\Entity\InspectionConvoi;
use App\Repository\InspectionConvoiRepository;
use Doctrine\ORM\EntityManagerInterface;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/inspection/convoi')]
#[OA\Tag(name: 'Inspection Convoi')]
final class ApiInspectionConvoiController extends AbstractController
{
    public function __construct(private SerializerInterface $serializer)
    {
    }

    #[Route(name: 'app_inspection_convoi_index', methods: ['GET'])]
    #[OA\Get(
        path: '/api/inspection/convoi',
        summary: 'Liste toutes les inspections de convoi',
        description: 'Récupère la liste complète des inspections de convoi avec toutes les informations détaillées',
        tags: ['Inspection Convoi']
    )]
    #[OA\Response(
        response: 200,
        description: 'Liste des inspections récupérée avec succès',
        content: new OA\JsonContent(
            type: 'object',
            properties: [
                new OA\Property(property: 'success', type: 'boolean', description: 'Statut de la requête', example: true),
                new OA\Property(
                    property: 'data', 
                    type: 'array',
                    description: 'Liste des inspections de convoi',
                    items: new OA\Items(
                        type: 'object',
                        properties: [
                            new OA\Property(property: 'id', type: 'integer', description: 'ID auto-généré', example: 1),
                            new OA\Property(property: 'matricule', type: 'string', description: 'Matricule unique du convoi', example: '20251025001'),
                            new OA\Property(property: 'lieu_emission', type: 'string', description: 'Lieu d\'émission du document', example: 'Port Autonome de Douala'),
                            new OA\Property(property: 'date_emission', type: 'string', format: 'date', description: 'Date d\'émission', example: '2025-10-25'),
                            new OA\Property(property: 'r_type', type: 'string', description: 'Type de responsable', example: 'Personne Physique'),
                            new OA\Property(property: 'r_nationalite', type: 'string', description: 'Nationalité du responsable', example: 'Camerounaise'),
                            new OA\Property(property: 'r_addresse', type: 'string', description: 'Adresse du responsable', example: 'Quartier Bonanjo, Rue des Cocotiers'),
                            new OA\Property(property: 'r_telephone', type: 'string', description: 'Téléphone du responsable', example: '+237690123456'),
                            new OA\Property(property: 'v_matricule', type: 'string', description: 'Matricule du véhicule', example: 'CM-2024-AB-1234'),
                            new OA\Property(property: 'v_marque', type: 'string', description: 'Marque du véhicule', example: 'Mercedes Actros'),
                            new OA\Property(property: 'v_type', type: 'string', description: 'Type de véhicule', example: 'Semi-remorque'),
                            new OA\Property(property: 'type_charge', type: 'string', description: 'Type de chargement', example: 'Conteneurs'),
                            new OA\Property(property: 'tonnage_kg', type: 'string', description: 'Tonnage en kilogrammes', example: '40000'),
                            new OA\Property(property: 'longueur', type: 'string', description: 'Longueur du convoi', example: '18.5'),
                            new OA\Property(property: 'v_largeur', type: 'string', description: 'Largeur du véhicule', example: '2.55'),
                            new OA\Property(property: 'hauteur', type: 'string', description: 'Hauteur totale', example: '4.2'),
                            new OA\Property(property: 'arrimage', type: 'boolean', description: 'Contrôle arrimage', example: true),
                            new OA\Property(property: 'centrage', type: 'boolean', description: 'Contrôle centrage', example: true),
                            new OA\Property(property: 'signalisation', type: 'boolean', description: 'Contrôle signalisation', example: true),
                            new OA\Property(property: 'p_depart', type: 'string', description: 'Point de départ', example: 'Port de Douala'),
                            new OA\Property(property: 'p_arrivee', type: 'string', description: 'Point d\'arrivée', example: 'Yaoundé Mvan'),
                            new OA\Property(property: 'h_depart', type: 'string', format: 'time', description: 'Heure de départ', example: '06:00:00'),
                            new OA\Property(property: 'h_arrivee', type: 'string', format: 'time', description: 'Heure d\'arrivée prévue', example: '14:30:00'),
                            new OA\Property(property: 'raison_arret', type: 'string', description: 'Raison de l\'arrêt', example: 'Contrôle de routine au poste de Edéa'),
                            new OA\Property(property: 'observations_generales', type: 'string', description: 'Observations générales', example: 'Convoi conforme aux normes, signalisation adéquate'),
                            new OA\Property(property: 'approuve', type: 'boolean', description: 'Statut d\'approbation', example: true),
                            new OA\Property(property: 'inspecteur_nom', type: 'string', description: 'Nom de l\'inspecteur', example: 'Mballa Jean Pierre'),
                            new OA\Property(property: 'equipe1', type: 'string', description: 'Membre équipe 1', example: 'Nkomo Paul'),
                            new OA\Property(property: 'equipe1_contact', type: 'string', description: 'Contact équipe 1', example: '+237675234567'),
                            new OA\Property(property: 'equipe2', type: 'string', description: 'Membre équipe 2', example: 'Fotso Marie'),
                            new OA\Property(property: 'equipe2_contact', type: 'string', description: 'Contact équipe 2', example: '+237655123789'),
                            new OA\Property(property: 'equipe3', type: 'string', description: 'Membre équipe 3', example: 'Biya Samuel'),
                            new OA\Property(property: 'euipe3_contact', type: 'string', description: 'Contact équipe 3', example: '+237692456123')
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
                        'lieu_emission' => 'Port Autonome de Douala',
                        'date_emission' => '2025-10-25',
                        'r_type' => 'Personne Physique',
                        'r_nationalite' => 'Camerounaise',
                        'r_addresse' => 'Quartier Bonanjo, Rue des Cocotiers',
                        'r_telephone' => '+237690123456',
                        'v_matricule' => 'CM-2024-AB-1234',
                        'v_marque' => 'Mercedes Actros',
                        'v_type' => 'Semi-remorque',
                        'type_charge' => 'Conteneurs',
                        'tonnage_kg' => '40000',
                        'longueur' => '18.5',
                        'v_largeur' => '2.55',
                        'hauteur' => '4.2',
                        'arrimage' => true,
                        'centrage' => true,
                        'signalisation' => true,
                        'p_depart' => 'Port de Douala',
                        'p_arrivee' => 'Yaoundé Mvan',
                        'h_depart' => '06:00:00',
                        'h_arrivee' => '14:30:00',
                        'raison_arret' => 'Contrôle de routine au poste de Edéa',
                        'observations_generales' => 'Convoi conforme aux normes, signalisation adéquate',
                        'approuve' => true,
                        'inspecteur_nom' => 'Mballa Jean Pierre',
                        'equipe1' => 'Nkomo Paul',
                        'equipe1_contact' => '+237675234567',
                        'equipe2' => 'Fotso Marie',
                        'equipe2_contact' => '+237655123789',
                        'equipe3' => 'Biya Samuel',
                        'euipe3_contact' => '+237692456123'
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
                new OA\Property(property: 'message', type: 'string', example: 'Erreur lors de la récupération des données')
            ]
        )
    )]
    public function index(InspectionConvoiRepository $inspectionConvoiRepository): JsonResponse
    {
        $inspections = $inspectionConvoiRepository->findAll();
        
        return $this->json([
            'success' => true,
            'data' => $inspections
        ], context: ['groups' => ['api_inspectionconvoi']]);
    }

















    
    #[Route('/new', name: 'app_inspection_convoi_new', methods: ['POST'])]
    #[OA\Post(
        path: '/api/inspection/convoi/new',
        summary: 'Crée une nouvelle inspection de convoi',
        description: 'Créer une nouvelle inspection de convoi avec toutes les informations du véhicule, du responsable et de l\'équipe d\'inspection',
        tags: ['Inspection Convoi']
    )]
    #[OA\RequestBody(
        required: true,
        description: 'Données complètes de l\'inspection de convoi à créer',
        content: new OA\JsonContent(
            type: 'object',
            required: ['matricule', 'lieu_emission', 'date_emission', 'r_type', 'r_nationalite', 'r_addresse', 'r_telephone', 'v_matricule', 'v_marque', 'v_type', 'type_charge', 'tonnage_kg', 'longueur', 'v_largeur', 'hauteur', 'arrimage', 'centrage', 'signalisation', 'p_depart', 'p_arrivee', 'h_depart', 'h_arrivee', 'inspecteur_nom'],
            properties: [
                new OA\Property(property: 'matricule', type: 'string', description: 'Matricule unique du convoi (format: YYYYMMDDXXX)', example: '20251025002', maxLength: 20),
                new OA\Property(property: 'lieu_emission', type: 'string', description: 'Lieu d\'émission du document d\'inspection', example: 'Direction Régionale du Littoral', maxLength: 255),
                new OA\Property(property: 'date_emission', type: 'string', format: 'date', description: 'Date d\'émission du document', example: '2025-10-25'),
                new OA\Property(property: 'r_type', type: 'string', description: 'Type de responsable du convoi', enum: ['Personne Physique', 'Personne Morale', 'Entreprise'], example: 'Entreprise'),
                new OA\Property(property: 'r_nationalite', type: 'string', description: 'Nationalité du responsable', example: 'Camerounaise', maxLength: 255),
                new OA\Property(property: 'r_addresse', type: 'string', description: 'Adresse complète du responsable', example: 'Zone Industrielle de Bonabéri, BP 1234 Douala', maxLength: 255),
                new OA\Property(property: 'r_telephone', type: 'string', description: 'Numéro de téléphone (format international)', example: '+237699887766', maxLength: 13),
                new OA\Property(property: 'v_matricule', type: 'string', description: 'Matricule du véhicule tracteur', example: 'CM-2025-BC-5678', maxLength: 255),
                new OA\Property(property: 'v_marque', type: 'string', description: 'Marque et modèle du véhicule', example: 'Volvo FH16', maxLength: 255),
                new OA\Property(property: 'v_type', type: 'string', description: 'Type de véhicule', enum: ['Tracteur routier', 'Camion porteur', 'Semi-remorque', 'Ensemble routier'], example: 'Tracteur routier'),
                new OA\Property(property: 'type_charge', type: 'string', description: 'Nature du chargement transporté', example: 'Matériaux de construction', maxLength: 255),
                new OA\Property(property: 'tonnage_kg', type: 'string', description: 'Poids total autorisé en charge (PTAC) en kg', example: '44000', maxLength: 255),
                new OA\Property(property: 'longueur', type: 'string', description: 'Longueur totale du convoi en mètres', example: '16.5', maxLength: 255),
                new OA\Property(property: 'v_largeur', type: 'string', description: 'Largeur du véhicule en mètres', example: '2.55'),
                new OA\Property(property: 'hauteur', type: 'string', description: 'Hauteur totale avec chargement en mètres', example: '4.0'),
                new OA\Property(property: 'arrimage', type: 'boolean', description: 'Conformité de l\'arrimage de la charge', example: true),
                new OA\Property(property: 'centrage', type: 'boolean', description: 'Conformité du centrage de la charge', example: true),
                new OA\Property(property: 'signalisation', type: 'boolean', description: 'Conformité de la signalisation du convoi', example: true),
                new OA\Property(property: 'p_depart', type: 'string', description: 'Point de départ du convoi', example: 'Usine Cimenterie de Figuil', maxLength: 255),
                new OA\Property(property: 'p_arrivee', type: 'string', description: 'Point de destination du convoi', example: 'Chantier BTP Garoua', maxLength: 255),
                new OA\Property(property: 'h_depart', type: 'string', format: 'time', description: 'Heure prévue de départ', example: '05:30:00'),
                new OA\Property(property: 'h_arrivee', type: 'string', format: 'time', description: 'Heure prévue d\'arrivée', example: '16:45:00'),
                new OA\Property(property: 'raison_arret', type: 'string', description: 'Motif de l\'arrêt pour inspection', example: 'Contrôle systématique sortie d\'usine', maxLength: 500),
                new OA\Property(property: 'observations_generales', type: 'string', description: 'Observations détaillées de l\'inspecteur', example: 'Convoi en règle, documentation complète, équipements de sécurité conformes', maxLength: 5000),
                new OA\Property(property: 'approuve', type: 'boolean', description: 'Statut d\'approbation de l\'inspection', example: true),
                new OA\Property(property: 'inspecteur_nom', type: 'string', description: 'Nom complet de l\'inspecteur responsable', example: 'Ahmadou Bello', maxLength: 255),
                new OA\Property(property: 'equipe1', type: 'string', description: 'Nom du premier membre de l\'équipe', example: 'Ngono Pierre', maxLength: 255),
                new OA\Property(property: 'equipe1_contact', type: 'string', description: 'Contact du premier membre', example: '+237670111222', maxLength: 255),
                new OA\Property(property: 'equipe2', type: 'string', description: 'Nom du deuxième membre de l\'équipe', example: 'Aissatou Diallo', maxLength: 255),
                new OA\Property(property: 'equipe2_contact', type: 'string', description: 'Contact du deuxième membre', example: '+237650333444', maxLength: 255),
                new OA\Property(property: 'equipe3', type: 'string', description: 'Nom du troisième membre de l\'équipe', example: 'Manga François', maxLength: 255),
                new OA\Property(property: 'euipe3_contact', type: 'string', description: 'Contact du troisième membre', example: '+237695555666', maxLength: 255)
            ],
            example: [
                'matricule' => '20251025002',
                'lieu_emission' => 'Direction Régionale du Littoral',
                'date_emission' => '2025-10-25',
                'r_type' => 'Entreprise',
                'r_nationalite' => 'Camerounaise',
                'r_addresse' => 'Zone Industrielle de Bonabéri, BP 1234 Douala',
                'r_telephone' => '+237699887766',
                'v_matricule' => 'CM-2025-BC-5678',
                'v_marque' => 'Volvo FH16',
                'v_type' => 'Tracteur routier',
                'type_charge' => 'Matériaux de construction',
                'tonnage_kg' => '44000',
                'longueur' => '16.5',
                'v_largeur' => '2.55',
                'hauteur' => '4.0',
                'arrimage' => true,
                'centrage' => true,
                'signalisation' => true,
                'p_depart' => 'Usine Cimenterie de Figuil',
                'p_arrivee' => 'Chantier BTP Garoua',
                'h_depart' => '05:30:00',
                'h_arrivee' => '16:45:00',
                'raison_arret' => 'Contrôle systématique sortie d\'usine',
                'observations_generales' => 'Convoi en règle, documentation complète, équipements de sécurité conformes',
                'approuve' => true,
                'inspecteur_nom' => 'Ahmadou Bello',
                'equipe1' => 'Ngono Pierre',
                'equipe1_contact' => '+237670111222',
                'equipe2' => 'Aissatou Diallo',
                'equipe2_contact' => '+237650333444',
                'equipe3' => 'Manga François',
                'euipe3_contact' => '+237695555666'
            ]
        )
    )]
    #[OA\Response(
        response: 201,
        description: 'Inspection créée avec succès',
        content: new OA\JsonContent(
            type: 'object',
            properties: [
                new OA\Property(property: 'success', type: 'boolean', description: 'Statut de la création', example: true),
                new OA\Property(property: 'message', type: 'string', description: 'Message de confirmation', example: 'Inspection Convoi créée avec succès'),
                new OA\Property(
                    property: 'data', 
                    type: 'object',
                    description: 'Données de l\'inspection créée avec ID généré',
                    example: [
                        'id' => 2,
                        'matricule' => '20251025002',
                        'lieu_emission' => 'Direction Régionale du Littoral',
                        'date_emission' => '2025-10-25',
                        'r_type' => 'Entreprise',
                        'r_nationalite' => 'Camerounaise',
                        'r_addresse' => 'Zone Industrielle de Bonabéri, BP 1234 Douala',
                        'r_telephone' => '+237699887766',
                        'v_matricule' => 'CM-2025-BC-5678',
                        'v_marque' => 'Volvo FH16',
                        'v_type' => 'Tracteur routier',
                        'type_charge' => 'Matériaux de construction',
                        'tonnage_kg' => '44000',
                        'longueur' => '16.5',
                        'v_largeur' => '2.55',
                        'hauteur' => '4.0',
                        'arrimage' => true,
                        'centrage' => true,
                        'signalisation' => true,
                        'p_depart' => 'Usine Cimenterie de Figuil',
                        'p_arrivee' => 'Chantier BTP Garoua',
                        'h_depart' => '05:30:00',
                        'h_arrivee' => '16:45:00',
                        'raison_arret' => 'Contrôle systématique sortie d\'usine',
                        'observations_generales' => 'Convoi en règle, documentation complète, équipements de sécurité conformes',
                        'approuve' => true,
                        'inspecteur_nom' => 'Ahmadou Bello',
                        'equipe1' => 'Ngono Pierre',
                        'equipe1_contact' => '+237670111222',
                        'equipe2' => 'Aissatou Diallo',
                        'equipe2_contact' => '+237650333444',
                        'equipe3' => 'Manga François',
                        'euipe3_contact' => '+237695555666'
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
                new OA\Property(property: 'message', type: 'string', example: 'Erreur de validation: matricule déjà existant')
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
















    
    #[Route('/{id}', name: 'app_inspection_convoi_show', methods: ['GET'])]
    #[OA\Get(
        path: '/api/inspection/convoi/{id}',
        summary: 'Récupère une inspection spécifique',
        description: 'Récupère toutes les informations détaillées d\'une inspection de convoi par son ID',
        tags: ['Inspection Convoi']
    )]
    #[OA\Parameter(
        name: 'id',
        description: 'ID unique de l\'inspection à récupérer',
        in: 'path',
        required: true,
        schema: new OA\Schema(type: 'integer', minimum: 1),
        example: 1
    )]
    #[OA\Response(
        response: 200,
        description: 'Inspection trouvée avec succès',
        content: new OA\JsonContent(
            type: 'object',
            properties: [
                new OA\Property(property: 'success', type: 'boolean', description: 'Statut de la requête', example: true),
                new OA\Property(
                    property: 'data', 
                    type: 'object',
                    description: 'Données complètes de l\'inspection de convoi',
                    properties: [
                        new OA\Property(property: 'id', type: 'integer', description: 'ID de l\'inspection', example: 1),
                        new OA\Property(property: 'matricule', type: 'string', description: 'Matricule du convoi', example: '20251025001'),
                        new OA\Property(property: 'lieu_emission', type: 'string', description: 'Lieu d\'émission', example: 'Port Autonome de Douala'),
                        new OA\Property(property: 'date_emission', type: 'string', format: 'date', description: 'Date d\'émission', example: '2025-10-25'),
                        new OA\Property(property: 'r_type', type: 'string', description: 'Type de responsable', example: 'Personne Physique'),
                        new OA\Property(property: 'r_nationalite', type: 'string', description: 'Nationalité', example: 'Camerounaise'),
                        new OA\Property(property: 'r_addresse', type: 'string', description: 'Adresse du responsable', example: 'Quartier Bonanjo, Rue des Cocotiers'),
                        new OA\Property(property: 'r_telephone', type: 'string', description: 'Téléphone', example: '+237690123456'),
                        new OA\Property(property: 'v_matricule', type: 'string', description: 'Matricule véhicule', example: 'CM-2024-AB-1234'),
                        new OA\Property(property: 'v_marque', type: 'string', description: 'Marque véhicule', example: 'Mercedes Actros'),
                        new OA\Property(property: 'v_type', type: 'string', description: 'Type véhicule', example: 'Semi-remorque'),
                        new OA\Property(property: 'type_charge', type: 'string', description: 'Type de charge', example: 'Conteneurs'),
                        new OA\Property(property: 'tonnage_kg', type: 'string', description: 'Tonnage en kg', example: '40000'),
                        new OA\Property(property: 'longueur', type: 'string', description: 'Longueur en m', example: '18.5'),
                        new OA\Property(property: 'v_largeur', type: 'string', description: 'Largeur en m', example: '2.55'),
                        new OA\Property(property: 'hauteur', type: 'string', description: 'Hauteur en m', example: '4.2'),
                        new OA\Property(property: 'arrimage', type: 'boolean', description: 'Conformité arrimage', example: true),
                        new OA\Property(property: 'centrage', type: 'boolean', description: 'Conformité centrage', example: true),
                        new OA\Property(property: 'signalisation', type: 'boolean', description: 'Conformité signalisation', example: true),
                        new OA\Property(property: 'p_depart', type: 'string', description: 'Point de départ', example: 'Port de Douala'),
                        new OA\Property(property: 'p_arrivee', type: 'string', description: 'Point d\'arrivée', example: 'Yaoundé Mvan'),
                        new OA\Property(property: 'h_depart', type: 'string', format: 'time', description: 'Heure départ', example: '06:00:00'),
                        new OA\Property(property: 'h_arrivee', type: 'string', format: 'time', description: 'Heure arrivée', example: '14:30:00'),
                        new OA\Property(property: 'raison_arret', type: 'string', description: 'Raison arrêt', example: 'Contrôle de routine au poste de Edéa'),
                        new OA\Property(property: 'observations_generales', type: 'string', description: 'Observations', example: 'Convoi conforme aux normes, signalisation adéquate'),
                        new OA\Property(property: 'approuve', type: 'boolean', description: 'Statut approbation', example: true),
                        new OA\Property(property: 'inspecteur_nom', type: 'string', description: 'Nom inspecteur', example: 'Mballa Jean Pierre'),
                        new OA\Property(property: 'equipe1', type: 'string', description: 'Équipe membre 1', example: 'Nkomo Paul'),
                        new OA\Property(property: 'equipe1_contact', type: 'string', description: 'Contact équipe 1', example: '+237675234567'),
                        new OA\Property(property: 'equipe2', type: 'string', description: 'Équipe membre 2', example: 'Fotso Marie'),
                        new OA\Property(property: 'equipe2_contact', type: 'string', description: 'Contact équipe 2', example: '+237655123789'),
                        new OA\Property(property: 'equipe3', type: 'string', description: 'Équipe membre 3', example: 'Biya Samuel'),
                        new OA\Property(property: 'euipe3_contact', type: 'string', description: 'Contact équipe 3', example: '+237692456123')
                    ],
                    example: [
                        'id' => 1,
                        'matricule' => '20251025001',
                        'lieu_emission' => 'Port Autonome de Douala',
                        'date_emission' => '2025-10-25',
                        'r_type' => 'Personne Physique',
                        'r_nationalite' => 'Camerounaise',
                        'r_addresse' => 'Quartier Bonanjo, Rue des Cocotiers',
                        'r_telephone' => '+237690123456',
                        'v_matricule' => 'CM-2024-AB-1234',
                        'v_marque' => 'Mercedes Actros',
                        'v_type' => 'Semi-remorque',
                        'type_charge' => 'Conteneurs',
                        'tonnage_kg' => '40000',
                        'longueur' => '18.5',
                        'v_largeur' => '2.55',
                        'hauteur' => '4.2',
                        'arrimage' => true,
                        'centrage' => true,
                        'signalisation' => true,
                        'p_depart' => 'Port de Douala',
                        'p_arrivee' => 'Yaoundé Mvan',
                        'h_depart' => '06:00:00',
                        'h_arrivee' => '14:30:00',
                        'raison_arret' => 'Contrôle de routine au poste de Edéa',
                        'observations_generales' => 'Convoi conforme aux normes, signalisation adéquate',
                        'approuve' => true,
                        'inspecteur_nom' => 'Mballa Jean Pierre',
                        'equipe1' => 'Nkomo Paul',
                        'equipe1_contact' => '+237675234567',
                        'equipe2' => 'Fotso Marie',
                        'equipe2_contact' => '+237655123789',
                        'equipe3' => 'Biya Samuel',
                        'euipe3_contact' => '+237692456123'
                    ]
                )
            ]
        )
    )]
    #[OA\Response(
        response: 404, 
        description: 'Inspection non trouvée',
        content: new OA\JsonContent(
            type: 'object',
            properties: [
                new OA\Property(property: 'success', type: 'boolean', example: false),
                new OA\Property(property: 'message', type: 'string', example: 'Inspection avec l\'ID 999 non trouvée')
            ]
        )
    )]
    public function show(InspectionConvoi $inspection): JsonResponse
    {
        return $this->json([
            'success' => true,
            'data' => $inspection
        ], context: ['groups' => ['api_inspectionconvoi']]);
    }
















    
    #[Route('/{id}/edit', name: 'app_inspection_convoi_edit', methods: ['PUT', 'PATCH'])]
    #[OA\Put(
        path: '/api/inspection/convoi/{id}/edit',
        summary: 'Met à jour une inspection existante',
        description: 'Met à jour partiellement ou complètement les informations d\'une inspection de convoi',
        tags: ['Inspection Convoi']
    )]
    #[OA\Parameter(
        name: 'id',
        description: 'ID unique de l\'inspection à modifier',
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
                new OA\Property(property: 'lieu_emission', type: 'string', description: 'Nouveau lieu d\'émission', example: 'Direction Régionale du Centre', maxLength: 255),
                new OA\Property(property: 'r_addresse', type: 'string', description: 'Nouvelle adresse du responsable', example: 'Quartier Mvan, Rue des Palmiers, Yaoundé', maxLength: 255),
                new OA\Property(property: 'r_telephone', type: 'string', description: 'Nouveau numéro de téléphone', example: '+237677998877', maxLength: 13),
                new OA\Property(property: 'v_matricule', type: 'string', description: 'Nouveau matricule véhicule', example: 'CM-2025-CD-9876', maxLength: 255),
                new OA\Property(property: 'type_charge', type: 'string', description: 'Nouveau type de chargement', example: 'Équipements industriels', maxLength: 255),
                new OA\Property(property: 'tonnage_kg', type: 'string', description: 'Nouveau tonnage', example: '35000', maxLength: 255),
                new OA\Property(property: 'arrimage', type: 'boolean', description: 'Mise à jour contrôle arrimage', example: false),
                new OA\Property(property: 'centrage', type: 'boolean', description: 'Mise à jour contrôle centrage', example: true),
                new OA\Property(property: 'signalisation', type: 'boolean', description: 'Mise à jour contrôle signalisation', example: false),
                new OA\Property(property: 'p_arrivee', type: 'string', description: 'Nouvelle destination', example: 'Chantier Kribi', maxLength: 255),
                new OA\Property(property: 'h_arrivee', type: 'string', format: 'time', description: 'Nouvelle heure d\'arrivée', example: '18:00:00'),
                new OA\Property(property: 'raison_arret', type: 'string', description: 'Nouveau motif d\'arrêt', example: 'Contrôle suite à signalement défaut signalisation', maxLength: 500),
                new OA\Property(property: 'observations_generales', type: 'string', description: 'Nouvelles observations', example: 'Défauts détectés: arrimage insuffisant, signalisation défectueuse. Autorisation conditionnelle accordée sous réserve de corrections immédiates.', maxLength: 5000),
                new OA\Property(property: 'approuve', type: 'boolean', description: 'Nouveau statut d\'approbation', example: false),
                new OA\Property(property: 'inspecteur_nom', type: 'string', description: 'Nom inspecteur de contrôle', example: 'Nanga Marie Claire', maxLength: 255),
                new OA\Property(property: 'equipe2', type: 'string', description: 'Nouveau membre équipe 2', example: 'Essomba Joseph', maxLength: 255),
                new OA\Property(property: 'equipe2_contact', type: 'string', description: 'Nouveau contact équipe 2', example: '+237651789012', maxLength: 255)
            ],
            example: [
                'lieu_emission' => 'Direction Régionale du Centre',
                'r_addresse' => 'Quartier Mvan, Rue des Palmiers, Yaoundé',
                'r_telephone' => '+237677998877',
                'type_charge' => 'Équipements industriels',
                'tonnage_kg' => '35000',
                'arrimage' => false,
                'signalisation' => false,
                'p_arrivee' => 'Chantier Kribi',
                'h_arrivee' => '18:00:00',
                'raison_arret' => 'Contrôle suite à signalement défaut signalisation',
                'observations_generales' => 'Défauts détectés: arrimage insuffisant, signalisation défectueuse. Autorisation conditionnelle accordée sous réserve de corrections immédiates.',
                'approuve' => false,
                'inspecteur_nom' => 'Nanga Marie Claire',
                'equipe2' => 'Essomba Joseph',
                'equipe2_contact' => '+237651789012'
            ]
        )
    )]
    #[OA\Response(
        response: 200,
        description: 'Inspection mise à jour avec succès',
        content: new OA\JsonContent(
            type: 'object',
            properties: [
                new OA\Property(property: 'success', type: 'boolean', description: 'Statut de la mise à jour', example: true),
                new OA\Property(property: 'message', type: 'string', description: 'Message de confirmation', example: 'Inspection Convoi mise à jour avec succès'),
                new OA\Property(
                    property: 'data', 
                    type: 'object',
                    description: 'Données de l\'inspection mise à jour',
                    example: [
                        'id' => 1,
                        'matricule' => '20251025001',
                        'lieu_emission' => 'Direction Régionale du Centre',
                        'date_emission' => '2025-10-25',
                        'r_type' => 'Personne Physique',
                        'r_nationalite' => 'Camerounaise',
                        'r_addresse' => 'Quartier Mvan, Rue des Palmiers, Yaoundé',
                        'r_telephone' => '+237677998877',
                        'v_matricule' => 'CM-2024-AB-1234',
                        'v_marque' => 'Mercedes Actros',
                        'v_type' => 'Semi-remorque',
                        'type_charge' => 'Équipements industriels',
                        'tonnage_kg' => '35000',
                        'longueur' => '18.5',
                        'v_largeur' => '2.55',
                        'hauteur' => '4.2',
                        'arrimage' => false,
                        'centrage' => true,
                        'signalisation' => false,
                        'p_depart' => 'Port de Douala',
                        'p_arrivee' => 'Chantier Kribi',
                        'h_depart' => '06:00:00',
                        'h_arrivee' => '18:00:00',
                        'raison_arret' => 'Contrôle suite à signalement défaut signalisation',
                        'observations_generales' => 'Défauts détectés: arrimage insuffisant, signalisation défectueuse. Autorisation conditionnelle accordée sous réserve de corrections immédiates.',
                        'approuve' => false,
                        'inspecteur_nom' => 'Nanga Marie Claire',
                        'equipe1' => 'Nkomo Paul',
                        'equipe1_contact' => '+237675234567',
                        'equipe2' => 'Essomba Joseph',
                        'equipe2_contact' => '+237651789012',
                        'equipe3' => 'Biya Samuel',
                        'euipe3_contact' => '+237692456123'
                    ]
                )
            ]
        )
    )]
    #[OA\Response(
        response: 404, 
        description: 'Inspection non trouvée',
        content: new OA\JsonContent(
            type: 'object',
            properties: [
                new OA\Property(property: 'success', type: 'boolean', example: false),
                new OA\Property(property: 'message', type: 'string', example: 'Inspection avec l\'ID 999 non trouvée')
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
                new OA\Property(property: 'message', type: 'string', example: 'Erreur de validation: format de téléphone invalide')
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
















    
    #[Route('/{id}', name: 'app_inspection_convoi_delete', methods: ['DELETE'])]
    #[OA\Delete(
        path: '/api/inspection/convoi/{id}',
        summary: 'Supprime une inspection',
        description: 'Supprime définitivement une inspection de convoi du système',
        tags: ['Inspection Convoi']
    )]
    #[OA\Parameter(
        name: 'id',
        description: 'ID unique de l\'inspection à supprimer',
        in: 'path',
        required: true,
        schema: new OA\Schema(type: 'integer', minimum: 1),
        example: 1
    )]
    #[OA\Response(
        response: 200,
        description: 'Inspection supprimée avec succès',
        content: new OA\JsonContent(
            type: 'object',
            properties: [
                new OA\Property(property: 'success', type: 'boolean', description: 'Statut de la suppression', example: true),
                new OA\Property(property: 'message', type: 'string', description: 'Message de confirmation', example: 'Inspection Convoi supprimée avec succès')
            ],
            example: [
                'success' => true,
                'message' => 'Inspection Convoi supprimée avec succès'
            ]
        )
    )]
    #[OA\Response(
        response: 404, 
        description: 'Inspection non trouvée',
        content: new OA\JsonContent(
            type: 'object',
            properties: [
                new OA\Property(property: 'success', type: 'boolean', example: false),
                new OA\Property(property: 'message', type: 'string', example: 'Inspection avec l\'ID 999 non trouvée')
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
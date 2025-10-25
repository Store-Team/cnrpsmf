<?php

namespace App\Controller\api;

use App\Entity\AutorisationConvoiExceptionel;
use App\Repository\AutorisationConvoiExceptionelRepository;
use Doctrine\ORM\EntityManagerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/autorisation/convoiexceptionel')]
#[OA\Tag(name: 'Autorisation Convoi Exceptionel')]
final class ApiAutorisationConvoiExceptionelController extends AbstractController
{
    public function __construct(private SerializerInterface $serializer)
    {
    }

    #[Route(name: 'app_autorisation_convoi_exceptionel_index', methods: ['GET'])]
    #[OA\Get(
        path: '/api/autorisation/convoiexceptionel',
        summary: 'Liste toutes les autorisations de convoi exceptionel',
        description: 'Récupère la liste complète des autorisations de convoi exceptionel avec informations détaillées sur les transports hors normes',
        tags: ['Autorisation Convoi Exceptionel']
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
                    description: 'Liste des autorisations de convoi exceptionel',
                    items: new OA\Items(
                        type: 'object',
                        properties: [
                            new OA\Property(property: 'id', type: 'integer', description: 'ID auto-généré', example: 1),
                            new OA\Property(property: 'matricule', type: 'string', description: 'Matricule unique de l\'autorisation', example: '20251025001'),
                            new OA\Property(property: 'lieu_emission', type: 'string', description: 'Lieu d\'émission du document', example: 'Direction Générale des Transports Terrestres'),
                            new OA\Property(property: 'date_emission', type: 'string', format: 'date', description: 'Date d\'émission', example: '2025-10-25'),
                            new OA\Property(property: 'r_type', type: 'string', description: 'Type de responsable', example: 'Entreprise de BTP'),
                            new OA\Property(property: 'r_nationalite', type: 'string', description: 'Nationalité du responsable', example: 'Camerounaise'),
                            new OA\Property(property: 'r_addresse', type: 'string', description: 'Adresse du responsable', example: 'Zone Industrielle de Bassa, BP 5678 Douala'),
                            new OA\Property(property: 'r_telephone', type: 'string', description: 'Téléphone du responsable', example: '+237699876543'),
                            new OA\Property(property: 'v_matricule', type: 'string', description: 'Matricule du véhicule porteur', example: 'CM-2025-EX-1001'),
                            new OA\Property(property: 'v_marque', type: 'string', description: 'Marque du véhicule', example: 'MAN TGX 41.640'),
                            new OA\Property(property: 'v_type', type: 'string', description: 'Type de véhicule', example: 'Tracteur + remorque surbaissée'),
                            new OA\Property(property: 'type_charge', type: 'string', description: 'Type de chargement exceptionel', example: 'Transformateur électrique 150 kVA'),
                            new OA\Property(property: 'tonnage_kg', type: 'string', description: 'Poids total en kilogrammes', example: '85000'),
                            new OA\Property(property: 'longueur', type: 'string', description: 'Longueur totale du convoi', example: '28.5'),
                            new OA\Property(property: 'v_largeur', type: 'string', description: 'Largeur du véhicule', example: '4.2'),
                            new OA\Property(property: 'hauteur', type: 'string', description: 'Hauteur totale avec charge', example: '4.8'),
                            new OA\Property(property: 'r_securite', type: 'string', description: 'Mesures de sécurité imposées', example: 'Escorte gendarmerie obligatoire'),
                            new OA\Property(property: 'heure_circulation', type: 'string', description: 'Créneaux horaires autorisés', example: '06h00-18h00 uniquement'),
                            new OA\Property(property: 'p_depart', type: 'string', description: 'Point de départ', example: 'Usine ALUCAM Edéa'),
                            new OA\Property(property: 'p_arrivee', type: 'string', description: 'Point d\'arrivée', example: 'Poste électrique ENEO Ngaoundéré'),
                            new OA\Property(property: 'h_depart', type: 'string', format: 'time', description: 'Heure de départ autorisée', example: '06:00:00'),
                            new OA\Property(property: 'h_arrivee', type: 'string', format: 'time', description: 'Heure d\'arrivée prévue', example: '16:30:00'),
                            new OA\Property(property: 'arrimage', type: 'boolean', description: 'Conformité arrimage spécial', example: true),
                            new OA\Property(property: 'centrage', type: 'boolean', description: 'Conformité centrage de charge', example: true),
                            new OA\Property(property: 'signalisation', type: 'boolean', description: 'Conformité signalisation renforcée', example: true),
                            new OA\Property(property: 'charge_technique', type: 'string', description: 'Caractéristiques techniques de la charge', example: 'Équipement électrique haute tension - Manipulation spécialisée requise')
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
                        'lieu_emission' => 'Direction Générale des Transports Terrestres',
                        'date_emission' => '2025-10-25',
                        'r_type' => 'Entreprise de BTP',
                        'r_nationalite' => 'Camerounaise',
                        'r_addresse' => 'Zone Industrielle de Bassa, BP 5678 Douala',
                        'r_telephone' => '+237699876543',
                        'v_matricule' => 'CM-2025-EX-1001',
                        'v_marque' => 'MAN TGX 41.640',
                        'v_type' => 'Tracteur + remorque surbaissée',
                        'type_charge' => 'Transformateur électrique 150 kVA',
                        'tonnage_kg' => '85000',
                        'longueur' => '28.5',
                        'v_largeur' => '4.2',
                        'hauteur' => '4.8',
                        'r_securite' => 'Escorte gendarmerie obligatoire',
                        'heure_circulation' => '06h00-18h00 uniquement',
                        'p_depart' => 'Usine ALUCAM Edéa',
                        'p_arrivee' => 'Poste électrique ENEO Ngaoundéré',
                        'h_depart' => '06:00:00',
                        'h_arrivee' => '16:30:00',
                        'arrimage' => true,
                        'centrage' => true,
                        'signalisation' => true,
                        'charge_technique' => 'Équipement électrique haute tension - Manipulation spécialisée requise'
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
                new OA\Property(property: 'message', type: 'string', example: 'Erreur lors de la récupération des autorisations de convoi')
            ]
        )
    )]
    public function index(AutorisationConvoiExceptionelRepository $autorisationConvoiExceptionelRepository): JsonResponse
    {
        $autorisations = $autorisationConvoiExceptionelRepository->findAll();
        
        return $this->json([
            'success' => true,
            'data' => $autorisations
        ], context: ['groups' => ['api_autorisation_convoi']]);
    }
















    #[Route('/new', name: 'app_autorisation_convoi_exceptionel_new', methods: ['POST'])]
    #[OA\Post(
        path: '/api/autorisation/convoiexceptionel/new',
        summary: 'Crée une nouvelle autorisation de convoi exceptionel',
        description: 'Créer une nouvelle autorisation pour transport de charges exceptionnelles dépassant les normes standards de circulation',
        tags: ['Autorisation Convoi Exceptionel']
    )]
    #[OA\RequestBody(
        required: true,
        description: 'Données complètes de l\'autorisation de convoi exceptionel à créer',
        content: new OA\JsonContent(
            type: 'object',
            required: ['matricule', 'lieu_emission', 'date_emission', 'r_type', 'r_nationalite', 'r_addresse', 'r_telephone', 'v_matricule', 'v_marque', 'v_type', 'type_charge', 'tonnage_kg', 'longueur', 'v_largeur', 'hauteur', 'r_securite', 'heure_circulation', 'p_depart', 'p_arrivee', 'h_depart', 'h_arrivee', 'charge_technique'],
            properties: [
                new OA\Property(property: 'matricule', type: 'string', description: 'Matricule unique de l\'autorisation (format: YYYYMMDDXXX)', example: '20251025002', maxLength: 20),
                new OA\Property(property: 'lieu_emission', type: 'string', description: 'Lieu précis d\'émission de l\'autorisation', example: 'Ministère des Transports - Service des Transports Exceptionnels', maxLength: 255),
                new OA\Property(property: 'date_emission', type: 'string', format: 'date', description: 'Date d\'émission de l\'autorisation', example: '2025-10-25'),
                new OA\Property(property: 'r_type', type: 'string', description: 'Type d\'organisation responsable', enum: ['Entreprise de BTP', 'Société industrielle', 'Transporteur spécialisé', 'Organisme public', 'Entreprise pétrolière'], example: 'Société industrielle', maxLength: 255),
                new OA\Property(property: 'r_nationalite', type: 'string', description: 'Nationalité de l\'organisation', example: 'Franco-camerounaise', maxLength: 255),
                new OA\Property(property: 'r_addresse', type: 'string', description: 'Adresse complète du responsable', example: 'Complexe Industriel de Limbé, Route de Buea, BP 890 Limbé', maxLength: 255),
                new OA\Property(property: 'r_telephone', type: 'string', description: 'Téléphone de contact (format international)', example: '+237674589632', maxLength: 13),
                new OA\Property(property: 'v_matricule', type: 'string', description: 'Matricule du véhicule porteur principal', example: 'CM-2025-SP-2002', maxLength: 255),
                new OA\Property(property: 'v_marque', type: 'string', description: 'Marque et modèle du véhicule tracteur', example: 'Scania R 730 V8', maxLength: 255),
                new OA\Property(property: 'v_type', type: 'string', description: 'Type de configuration du convoi', enum: ['Tracteur + remorque surbaissée', 'Porteur multi-essieux', 'Ensemble modulaire', 'Convoi articulé', 'Transport sur berge'], example: 'Ensemble modulaire', maxLength: 255),
                new OA\Property(property: 'type_charge', type: 'string', description: 'Description détaillée de la charge exceptionnelle', example: 'Cuve de raffinage pétrolier - Diamètre 6m', maxLength: 255),
                new OA\Property(property: 'tonnage_kg', type: 'string', description: 'Poids total du convoi en kilogrammes', example: '120000', maxLength: 255),
                new OA\Property(property: 'longueur', type: 'string', description: 'Longueur totale du convoi en mètres', example: '35.0', maxLength: 255),
                new OA\Property(property: 'v_largeur', type: 'string', description: 'Largeur maximale du convoi en mètres', example: '6.0'),
                new OA\Property(property: 'hauteur', type: 'string', description: 'Hauteur totale avec chargement en mètres', example: '5.5'),
                new OA\Property(property: 'r_securite', type: 'string', description: 'Mesures de sécurité et restrictions imposées', example: 'Escorte gendarmerie + véhicule pilote + signalisation renforcée', maxLength: 255),
                new OA\Property(property: 'heure_circulation', type: 'string', description: 'Créneaux horaires et jours autorisés', example: 'Lundi-Vendredi 05h00-19h00, Interdit week-end', maxLength: 255),
                new OA\Property(property: 'p_depart', type: 'string', description: 'Point de départ précis du transport', example: 'Raffinerie SONARA Limbé - Quai de chargement n°3', maxLength: 255),
                new OA\Property(property: 'p_arrivee', type: 'string', description: 'Destination finale du transport', example: 'Site pétrolier Total - Kome, Province du Sud', maxLength: 255),
                new OA\Property(property: 'h_depart', type: 'string', format: 'time', description: 'Heure de départ autorisée', example: '05:00:00'),
                new OA\Property(property: 'h_arrivee', type: 'string', format: 'time', description: 'Heure d\'arrivée maximale autorisée', example: '18:00:00'),
                new OA\Property(property: 'arrimage', type: 'boolean', description: 'Conformité de l\'arrimage spécialisé', example: true),
                new OA\Property(property: 'centrage', type: 'boolean', description: 'Conformité du centrage de la charge', example: true),
                new OA\Property(property: 'signalisation', type: 'boolean', description: 'Conformité de la signalisation exceptionnelle', example: true),
                new OA\Property(property: 'charge_technique', type: 'string', description: 'Spécifications techniques détaillées de la charge', example: 'Équipement industriel classe A - Transport vertical interdit - Température contrôlée', maxLength: 255)
            ],
            example: [
                'matricule' => '20251025002',
                'lieu_emission' => 'Ministère des Transports - Service des Transports Exceptionnels',
                'date_emission' => '2025-10-25',
                'r_type' => 'Société industrielle',
                'r_nationalite' => 'Franco-camerounaise',
                'r_addresse' => 'Complexe Industriel de Limbé, Route de Buea, BP 890 Limbé',
                'r_telephone' => '+237674589632',
                'v_matricule' => 'CM-2025-SP-2002',
                'v_marque' => 'Scania R 730 V8',
                'v_type' => 'Ensemble modulaire',
                'type_charge' => 'Cuve de raffinage pétrolier - Diamètre 6m',
                'tonnage_kg' => '120000',
                'longueur' => '35.0',
                'v_largeur' => '6.0',
                'hauteur' => '5.5',
                'r_securite' => 'Escorte gendarmerie + véhicule pilote + signalisation renforcée',
                'heure_circulation' => 'Lundi-Vendredi 05h00-19h00, Interdit week-end',
                'p_depart' => 'Raffinerie SONARA Limbé - Quai de chargement n°3',
                'p_arrivee' => 'Site pétrolier Total - Kome, Province du Sud',
                'h_depart' => '05:00:00',
                'h_arrivee' => '18:00:00',
                'arrimage' => true,
                'centrage' => true,
                'signalisation' => true,
                'charge_technique' => 'Équipement industriel classe A - Transport vertical interdit - Température contrôlée'
            ]
        )
    )]
    #[OA\Response(
        response: 201,
        description: 'Autorisation créée avec succès',
        content: new OA\JsonContent(
            type: 'object',
            properties: [
                new OA\Property(property: 'success', type: 'boolean', description: 'Statut de la création', example: true),
                new OA\Property(property: 'message', type: 'string', description: 'Message de confirmation', example: 'Autorisation Convoi Exceptionel créée avec succès'),
                new OA\Property(
                    property: 'data', 
                    type: 'object',
                    description: 'Données de l\'autorisation créée avec ID généré',
                    example: [
                        'id' => 2,
                        'matricule' => '20251025002',
                        'lieu_emission' => 'Ministère des Transports - Service des Transports Exceptionnels',
                        'date_emission' => '2025-10-25',
                        'r_type' => 'Société industrielle',
                        'r_nationalite' => 'Franco-camerounaise',
                        'r_addresse' => 'Complexe Industriel de Limbé, Route de Buea, BP 890 Limbé',
                        'r_telephone' => '+237674589632',
                        'v_matricule' => 'CM-2025-SP-2002',
                        'v_marque' => 'Scania R 730 V8',
                        'v_type' => 'Ensemble modulaire',
                        'type_charge' => 'Cuve de raffinage pétrolier - Diamètre 6m',
                        'tonnage_kg' => '120000',
                        'longueur' => '35.0',
                        'v_largeur' => '6.0',
                        'hauteur' => '5.5',
                        'r_securite' => 'Escorte gendarmerie + véhicule pilote + signalisation renforcée',
                        'heure_circulation' => 'Lundi-Vendredi 05h00-19h00, Interdit week-end',
                        'p_depart' => 'Raffinerie SONARA Limbé - Quai de chargement n°3',
                        'p_arrivee' => 'Site pétrolier Total - Kome, Province du Sud',
                        'h_depart' => '05:00:00',
                        'h_arrivee' => '18:00:00',
                        'arrimage' => true,
                        'centrage' => true,
                        'signalisation' => true,
                        'charge_technique' => 'Équipement industriel classe A - Transport vertical interdit - Température contrôlée'
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
                new OA\Property(property: 'message', type: 'string', example: 'Erreur de validation: dimensions hors limites autorisées ou matricule déjà existant')
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
            $autorisation = $this->serializer->deserialize(
                $request->getContent(),
                AutorisationConvoiExceptionel::class,
                'json',
                ['groups' => ['api_autorisation_convoi']]
            );

            $entityManager->persist($autorisation);
            $entityManager->flush();

            return $this->json([
                'success' => true,
                'message' => 'Autorisation Convoi Exceptionel créée avec succès',
                'data' => $autorisation
            ], JsonResponse::HTTP_CREATED, context: ['groups' => ['api_autorisation_convoi']]);
            
        } catch (\Exception $e) {
            return $this->json([
                'success' => false,
                'message' => 'Erreur lors de la création: ' . $e->getMessage()
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
















    
    #[Route('/{id}', name: 'app_autorisation_convoi_exceptionel_show', methods: ['GET'])]
    #[OA\Get(
        path: '/api/autorisation/convoiexceptionel/{id}',
        summary: 'Récupère une autorisation spécifique',
        description: 'Affiche toutes les informations détaillées d\'une autorisation de convoi exceptionel par son ID',
        tags: ['Autorisation Convoi Exceptionel']
    )]
    #[OA\Parameter(
        name: 'id',
        description: 'ID unique de l\'autorisation à récupérer',
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
                    description: 'Données complètes de l\'autorisation de convoi exceptionel',
                    properties: [
                        new OA\Property(property: 'id', type: 'integer', description: 'ID de l\'autorisation', example: 1),
                        new OA\Property(property: 'matricule', type: 'string', description: 'Matricule unique', example: '20251025001'),
                        new OA\Property(property: 'lieu_emission', type: 'string', description: 'Lieu d\'émission', example: 'Direction Générale des Transports Terrestres'),
                        new OA\Property(property: 'date_emission', type: 'string', format: 'date', description: 'Date d\'émission', example: '2025-10-25'),
                        new OA\Property(property: 'r_type', type: 'string', description: 'Type de responsable', example: 'Entreprise de BTP'),
                        new OA\Property(property: 'r_nationalite', type: 'string', description: 'Nationalité', example: 'Camerounaise'),
                        new OA\Property(property: 'r_addresse', type: 'string', description: 'Adresse responsable', example: 'Zone Industrielle de Bassa, BP 5678 Douala'),
                        new OA\Property(property: 'r_telephone', type: 'string', description: 'Téléphone', example: '+237699876543'),
                        new OA\Property(property: 'v_matricule', type: 'string', description: 'Matricule véhicule', example: 'CM-2025-EX-1001'),
                        new OA\Property(property: 'v_marque', type: 'string', description: 'Marque véhicule', example: 'MAN TGX 41.640'),
                        new OA\Property(property: 'v_type', type: 'string', description: 'Type convoi', example: 'Tracteur + remorque surbaissée'),
                        new OA\Property(property: 'type_charge', type: 'string', description: 'Type de charge', example: 'Transformateur électrique 150 kVA'),
                        new OA\Property(property: 'tonnage_kg', type: 'string', description: 'Poids total', example: '85000'),
                        new OA\Property(property: 'longueur', type: 'string', description: 'Longueur convoi', example: '28.5'),
                        new OA\Property(property: 'v_largeur', type: 'string', description: 'Largeur', example: '4.2'),
                        new OA\Property(property: 'hauteur', type: 'string', description: 'Hauteur totale', example: '4.8'),
                        new OA\Property(property: 'r_securite', type: 'string', description: 'Mesures sécurité', example: 'Escorte gendarmerie obligatoire'),
                        new OA\Property(property: 'heure_circulation', type: 'string', description: 'Créneaux autorisés', example: '06h00-18h00 uniquement'),
                        new OA\Property(property: 'p_depart', type: 'string', description: 'Point départ', example: 'Usine ALUCAM Edéa'),
                        new OA\Property(property: 'p_arrivee', type: 'string', description: 'Point arrivée', example: 'Poste électrique ENEO Ngaoundéré'),
                        new OA\Property(property: 'h_depart', type: 'string', format: 'time', description: 'Heure départ', example: '06:00:00'),
                        new OA\Property(property: 'h_arrivee', type: 'string', format: 'time', description: 'Heure arrivée', example: '16:30:00'),
                        new OA\Property(property: 'arrimage', type: 'boolean', description: 'Arrimage conforme', example: true),
                        new OA\Property(property: 'centrage', type: 'boolean', description: 'Centrage conforme', example: true),
                        new OA\Property(property: 'signalisation', type: 'boolean', description: 'Signalisation conforme', example: true),
                        new OA\Property(property: 'charge_technique', type: 'string', description: 'Spécifications techniques', example: 'Équipement électrique haute tension - Manipulation spécialisée requise')
                    ],
                    example: [
                        'id' => 1,
                        'matricule' => '20251025001',
                        'lieu_emission' => 'Direction Générale des Transports Terrestres',
                        'date_emission' => '2025-10-25',
                        'r_type' => 'Entreprise de BTP',
                        'r_nationalite' => 'Camerounaise',
                        'r_addresse' => 'Zone Industrielle de Bassa, BP 5678 Douala',
                        'r_telephone' => '+237699876543',
                        'v_matricule' => 'CM-2025-EX-1001',
                        'v_marque' => 'MAN TGX 41.640',
                        'v_type' => 'Tracteur + remorque surbaissée',
                        'type_charge' => 'Transformateur électrique 150 kVA',
                        'tonnage_kg' => '85000',
                        'longueur' => '28.5',
                        'v_largeur' => '4.2',
                        'hauteur' => '4.8',
                        'r_securite' => 'Escorte gendarmerie obligatoire',
                        'heure_circulation' => '06h00-18h00 uniquement',
                        'p_depart' => 'Usine ALUCAM Edéa',
                        'p_arrivee' => 'Poste électrique ENEO Ngaoundéré',
                        'h_depart' => '06:00:00',
                        'h_arrivee' => '16:30:00',
                        'arrimage' => true,
                        'centrage' => true,
                        'signalisation' => true,
                        'charge_technique' => 'Équipement électrique haute tension - Manipulation spécialisée requise'
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
                new OA\Property(property: 'message', type: 'string', example: 'Autorisation avec l\'ID 999 non trouvée')
            ]
        )
    )]
    public function show(AutorisationConvoiExceptionel $autorisation): JsonResponse
    {
        return $this->json([
            'success' => true,
            'data' => $autorisation
        ], context: ['groups' => ['api_autorisation_convoi']]);
    }
















    
    #[Route('/{id}/edit', name: 'app_autorisation_convoi_exceptionel_edit', methods: ['PUT', 'PATCH'])]
    #[OA\Put(
        path: '/api/autorisation/convoiexceptionel/{id}/edit',
        summary: 'Met à jour une autorisation existante',
        description: 'Modifie les informations d\'une autorisation de convoi exceptionel existante. Mise à jour partielle ou complète autorisée.',
        tags: ['Autorisation Convoi Exceptionel']
    )]
    #[OA\Parameter(
        name: 'id',
        description: 'ID unique de l\'autorisation à modifier',
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
                new OA\Property(property: 'lieu_emission', type: 'string', description: 'Nouveau lieu d\'émission', example: 'Direction Régionale des Transports Nord', maxLength: 255),
                new OA\Property(property: 'r_addresse', type: 'string', description: 'Nouvelle adresse responsable', example: 'Parc Industriel de Maroua, BP 123 Maroua', maxLength: 255),
                new OA\Property(property: 'r_telephone', type: 'string', description: 'Nouveau téléphone', example: '+237688445566', maxLength: 13),
                new OA\Property(property: 'v_matricule', type: 'string', description: 'Nouveau matricule véhicule', example: 'CM-2025-EX-1002', maxLength: 255),
                new OA\Property(property: 'v_marque', type: 'string', description: 'Nouvelle marque véhicule', example: 'Volvo FH16 750', maxLength: 255),
                new OA\Property(property: 'type_charge', type: 'string', description: 'Nouveau type de charge', example: 'Grue mobile 200 tonnes', maxLength: 255),
                new OA\Property(property: 'tonnage_kg', type: 'string', description: 'Nouveau poids total', example: '95000', maxLength: 255),
                new OA\Property(property: 'longueur', type: 'string', description: 'Nouvelle longueur', example: '32.0', maxLength: 255),
                new OA\Property(property: 'v_largeur', type: 'string', description: 'Nouvelle largeur', example: '4.5'),
                new OA\Property(property: 'hauteur', type: 'string', description: 'Nouvelle hauteur', example: '5.2'),
                new OA\Property(property: 'r_securite', type: 'string', description: 'Nouvelles mesures de sécurité', example: 'Escorte police + signalisation mobile renforcée', maxLength: 255),
                new OA\Property(property: 'heure_circulation', type: 'string', description: 'Nouveaux créneaux autorisés', example: 'Lundi-Samedi 04h00-20h00, Dimanche interdit', maxLength: 255),
                new OA\Property(property: 'p_depart', type: 'string', description: 'Nouveau point de départ', example: 'Base logistique Total Maroua', maxLength: 255),
                new OA\Property(property: 'p_arrivee', type: 'string', description: 'Nouvelle destination', example: 'Champ pétrolier Komé - Site de forage B', maxLength: 255),
                new OA\Property(property: 'h_depart', type: 'string', format: 'time', description: 'Nouvelle heure de départ', example: '04:00:00'),
                new OA\Property(property: 'h_arrivee', type: 'string', format: 'time', description: 'Nouvelle heure d\'arrivée', example: '19:30:00'),
                new OA\Property(property: 'arrimage', type: 'boolean', description: 'Mise à jour arrimage', example: false),
                new OA\Property(property: 'centrage', type: 'boolean', description: 'Mise à jour centrage', example: true),
                new OA\Property(property: 'signalisation', type: 'boolean', description: 'Mise à jour signalisation', example: false),
                new OA\Property(property: 'charge_technique', type: 'string', description: 'Nouvelles spécifications', example: 'Équipement de levage lourd - Contrôle technique spécialisé requis avant transport', maxLength: 255)
            ],
            example: [
                'lieu_emission' => 'Direction Régionale des Transports Nord',
                'r_addresse' => 'Parc Industriel de Maroua, BP 123 Maroua',
                'type_charge' => 'Grue mobile 200 tonnes',
                'tonnage_kg' => '95000',
                'longueur' => '32.0',
                'v_largeur' => '4.5',
                'hauteur' => '5.2',
                'r_securite' => 'Escorte police + signalisation mobile renforcée',
                'heure_circulation' => 'Lundi-Samedi 04h00-20h00, Dimanche interdit',
                'p_arrivee' => 'Champ pétrolier Komé - Site de forage B',
                'h_arrivee' => '19:30:00',
                'arrimage' => false,
                'signalisation' => false,
                'charge_technique' => 'Équipement de levage lourd - Contrôle technique spécialisé requis avant transport'
            ]
        )
    )]
    #[OA\Response(
        response: 200,
        description: 'Autorisation mise à jour avec succès',
        content: new OA\JsonContent(
            type: 'object',
            properties: [
                new OA\Property(property: 'success', type: 'boolean', description: 'Statut de la mise à jour', example: true),
                new OA\Property(property: 'message', type: 'string', description: 'Message de confirmation', example: 'Autorisation Convoi Exceptionel mise à jour avec succès'),
                new OA\Property(
                    property: 'data', 
                    type: 'object',
                    description: 'Données de l\'autorisation mise à jour',
                    example: [
                        'id' => 1,
                        'matricule' => '20251025001',
                        'lieu_emission' => 'Direction Régionale des Transports Nord',
                        'date_emission' => '2025-10-25',
                        'r_type' => 'Entreprise de BTP',
                        'r_nationalite' => 'Camerounaise',
                        'r_addresse' => 'Parc Industriel de Maroua, BP 123 Maroua',
                        'r_telephone' => '+237699876543',
                        'v_matricule' => 'CM-2025-EX-1001',
                        'v_marque' => 'MAN TGX 41.640',
                        'v_type' => 'Tracteur + remorque surbaissée',
                        'type_charge' => 'Grue mobile 200 tonnes',
                        'tonnage_kg' => '95000',
                        'longueur' => '32.0',
                        'v_largeur' => '4.5',
                        'hauteur' => '5.2',
                        'r_securite' => 'Escorte police + signalisation mobile renforcée',
                        'heure_circulation' => 'Lundi-Samedi 04h00-20h00, Dimanche interdit',
                        'p_depart' => 'Usine ALUCAM Edéa',
                        'p_arrivee' => 'Champ pétrolier Komé - Site de forage B',
                        'h_depart' => '06:00:00',
                        'h_arrivee' => '19:30:00',
                        'arrimage' => false,
                        'centrage' => true,
                        'signalisation' => false,
                        'charge_technique' => 'Équipement de levage lourd - Contrôle technique spécialisé requis avant transport'
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
                new OA\Property(property: 'message', type: 'string', example: 'Autorisation avec l\'ID 999 non trouvée')
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
                new OA\Property(property: 'message', type: 'string', example: 'Erreur de validation: dimensions dépassent les limites autorisées pour transport exceptionel')
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
    public function edit(Request $request, AutorisationConvoiExceptionel $autorisation, EntityManagerInterface $entityManager): JsonResponse
    {
        try {
            $this->serializer->deserialize(
                $request->getContent(),
                AutorisationConvoiExceptionel::class,
                'json',
                ['object_to_populate' => $autorisation, 'groups' => ['api_autorisation_convoi']]
            );

            $entityManager->flush();

            return $this->json([
                'success' => true,
                'message' => 'Autorisation Convoi Exceptionel mise à jour avec succès',
                'data' => $autorisation
            ], context: ['groups' => ['api_autorisation_convoi']]);
            
        } catch (\Exception $e) {
            return $this->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour: ' . $e->getMessage()
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }















    
    #[Route('/{id}', name: 'app_autorisation_convoi_exceptionel_delete', methods: ['DELETE'])]
    #[OA\Delete(
        path: '/api/autorisation/convoiexceptionel/{id}',
        summary: 'Supprime une autorisation',
        description: 'Supprime définitivement une autorisation de convoi exceptionel du système (opération critique)',
        tags: ['Autorisation Convoi Exceptionel']
    )]
    #[OA\Parameter(
        name: 'id',
        description: 'ID unique de l\'autorisation à supprimer',
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
                new OA\Property(property: 'message', type: 'string', description: 'Message de confirmation', example: 'Autorisation Convoi Exceptionel supprimée avec succès')
            ],
            example: [
                'success' => true,
                'message' => 'Autorisation Convoi Exceptionel supprimée avec succès'
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
                new OA\Property(property: 'message', type: 'string', example: 'Impossible de supprimer: transport en cours ou autorisation utilisée dans des rapports officiels')
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
                new OA\Property(property: 'message', type: 'string', example: 'Erreur lors de la suppression: contrainte réglementaire ou archive obligatoire')
            ]
        )
    )]
    public function delete(Request $request, AutorisationConvoiExceptionel $autorisation, EntityManagerInterface $entityManager): JsonResponse
    {
        try {
            $entityManager->remove($autorisation);
            $entityManager->flush();
            
            return $this->json([
                'success' => true,
                'message' => 'Autorisation Convoi Exceptionel supprimée avec succès'
            ]);
            
        } catch (\Exception $e) {
            return $this->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression: ' . $e->getMessage()
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
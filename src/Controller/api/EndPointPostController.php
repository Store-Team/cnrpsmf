<?php

namespace App\Controller\api;

use App\Entity\AutorisationConvoiExceptionel;
use App\Entity\AutorisationMateriauxConstruction;
use App\Entity\InspectionConvoi;
use App\Entity\Quittance;
use App\Entity\SurveillanceChargement;
use App\Entity\SurveillanceTaxiMoto;
use DateTime;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints as Assert;
use OpenApi\Attributes as OA;
use Throwable;

final class EndPointPostController extends AbstractController
{


    #[OA\Post(
        path: "/api/autorisation-convoi",
        summary: "Créer une autorisation de convoi exceptionnel",
        description: "Permet d’enregistrer une autorisation de convoi exceptionnel, incluant toutes les informations sur le responsable, le véhicule, la charge, et le trajet.
Cette API est utilisée par les services de transport, les BTP, et les autorités pour le suivi et le contrôle des convois spéciaux.",
        tags: ["Autorisation Convoi"],
        requestBody: new OA\RequestBody(
            required: true,
            description: "Données complètes de l’autorisation de convoi exceptionnel",
            content: new OA\JsonContent(
                type: "object",
                required: [
                    "matricule",
                    "lieu_emission",
                    "date_emission",
                    "r_type",
                    "r_nationalite",
                    "r_addresse",
                    "r_telephone",
                    "v_matricule",
                    "v_marque",
                    "v_type",
                    "type_charge",
                    "tonnage_kg",
                    "longueur",
                    "v_largeur",
                    "hauteur",
                    "r_securite",
                    "heure_circulation",
                    "p_depart",
                    "p_arrivee",
                    "h_depart",
                    "h_arrivee",
                    "arrimage",
                    "centrage",
                    "signalisation",
                    "charge_technique"
                ],
                properties: [
                    new OA\Property(property: "matricule", type: "string", example: "20251025001", description: "Numéro unique d’enregistrement de l’autorisation"),
                    new OA\Property(property: "lieu_emission", type: "string", example: "Direction Générale des Transports Terrestres", description: "Service ou entité émettrice de l’autorisation"),
                    new OA\Property(property: "date_emission", type: "string", format: "date", example: "2025-10-25", description: "Date d’émission de l’autorisation"),
                    new OA\Property(property: "r_type", type: "string", example: "Entreprise de BTP", description: "Type ou nature du responsable de l’autorisation (entreprise, particulier, institution)"),
                    new OA\Property(property: "r_nationalite", type: "string", example: "Camerounaise", description: "Nationalité du responsable ou de la société"),
                    new OA\Property(property: "r_addresse", type: "string", example: "Zone Industrielle de Bassa, BP 5678 Douala", description: "Adresse complète du responsable"),
                    new OA\Property(property: "r_telephone", type: "string", example: "+237699876543", description: "Numéro de téléphone de contact principal"),
                    new OA\Property(property: "v_matricule", type: "string", example: "CM-2025-EX-1001", description: "Numéro de plaque du véhicule principal"),
                    new OA\Property(property: "v_marque", type: "string", example: "MAN TGX 41.640", description: "Marque et modèle du véhicule"),
                    new OA\Property(property: "v_type", type: "string", example: "Tracteur + remorque surbaissée", description: "Type complet du convoi ou de la configuration du véhicule"),
                    new OA\Property(property: "type_charge", type: "string", example: "Transformateur électrique 150 kVA", description: "Description de la nature exacte de la charge transportée"),
                    new OA\Property(property: "tonnage_kg", type: "number", format: "float", example: 85000, description: "Poids total de la charge en kilogrammes"),
                    new OA\Property(property: "longueur", type: "number", format: "float", example: 28.5, description: "Longueur totale du convoi en mètres"),
                    new OA\Property(property: "v_largeur", type: "number", format: "float", example: 4.2, description: "Largeur totale du convoi en mètres"),
                    new OA\Property(property: "hauteur", type: "number", format: "float", example: 4.8, description: "Hauteur totale du convoi en mètres"),
                    new OA\Property(property: "r_securite", type: "string", example: "Escorte gendarmerie obligatoire", description: "Dispositif de sécurité imposé au convoi (ex: escorte, gyrophare, etc.)"),
                    new OA\Property(property: "heure_circulation", type: "string", example: "06h00-18h00 uniquement", description: "Plage horaire autorisée pour la circulation"),
                    new OA\Property(property: "p_depart", type: "string", example: "Usine ALUCAM Edéa", description: "Lieu exact de départ du convoi"),
                    new OA\Property(property: "p_arrivee", type: "string", example: "Poste électrique ENEO Ngaoundéré", description: "Destination finale du convoi"),
                    new OA\Property(property: "h_depart", type: "string", example: "06:00:00", description: "Heure de départ prévue (format HH:MM:SS)"),
                    new OA\Property(property: "h_arrivee", type: "string", example: "16:30:00", description: "Heure d’arrivée prévue (format HH:MM:SS)"),
                    new OA\Property(property: "arrimage", type: "boolean", example: true, description: "Indique si la charge est correctement arrimée"),
                    new OA\Property(property: "centrage", type: "boolean", example: true, description: "Indique si la charge est bien centrée"),
                    new OA\Property(property: "signalisation", type: "boolean", example: true, description: "Indique si le convoi est correctement signalé (bandes, gyrophares, panneaux)"),
                    new OA\Property(property: "charge_technique", type: "string", example: "Équipement électrique haute tension - Manipulation spécialisée requise", description: "Détails techniques de la charge transportée")
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: "Autorisation enregistrée avec succès",
                content: new OA\JsonContent(
                    type: "object",
                    properties: [
                        new OA\Property(property: "message", type: "string", example: "Autorisation enregistrée avec succès."),
                        new OA\Property(property: "id", type: "integer", example: 12)
                    ]
                )
            ),
            new OA\Response(
                response: 400,
                description: "Erreur de validation ou contenu JSON invalide",
                content: new OA\JsonContent(
                    type: "object",
                    properties: [
                        new OA\Property(property: "message", type: "string", example: "JSON invalide"),
                        new OA\Property(
                            property: "errors",
                            type: "array",
                            items: new OA\Items(
                                type: "object",
                                properties: [
                                    new OA\Property(property: "champ", type: "string", example: "r_telephone"),
                                    new OA\Property(property: "message", type: "string", example: "Numéro de téléphone invalide.")
                                ]
                            )
                        )
                    ]
                )
            ),
            new OA\Response(
                response: 409,
                description: "Autorisation déjà existante",
                content: new OA\JsonContent(
                    type: "object",
                    properties: [
                        new OA\Property(property: "message", type: "string", example: "Cette autorisation existe déjà.")
                    ]
                )
            ),
            new OA\Response(
                response: 500,
                description: "Erreur interne du serveur",
                content: new OA\JsonContent(
                    type: "object",
                    properties: [
                        new OA\Property(property: "message", type: "string", example: "Erreur interne : violation de contrainte SQL")
                    ]
                )
            )
        ]
    )]
    #[Route('/api/autorisation-convoi', name: 'autorisation_convoi_create', methods: ['POST'])]
    public function createAutorisation(
        Request $request,
        EntityManagerInterface $em,
        ValidatorInterface $validator
    ): JsonResponse {
        // ✅ Vérifie que c’est bien du JSON
        if ($request->getContentTypeFormat() !== 'json') {
            return $this->json(['message' => 'Content-Type doit être application/json'], 400);
        }


        $data = json_decode($request->getContent(), true);
        if (!is_array($data)) {
            return $this->json(['message' => 'Format JSON invalide'], 400);
        }

        $constraints = new Assert\Collection([
            'matricule' => [new Assert\NotBlank()],
            'lieu_emission' => [new Assert\NotBlank()],
            'date_emission' => [new Assert\NotBlank(), new Assert\Date()],
            'r_type' => [new Assert\NotBlank()],
            'r_nationalite' => [new Assert\NotBlank()],
            'r_addresse' => [new Assert\NotBlank()],
            'r_telephone' => [new Assert\NotBlank()],
            'v_matricule' => [new Assert\NotBlank()],
            'v_marque' => [new Assert\NotBlank()],
            'v_type' => [new Assert\NotBlank()],
            'type_charge' => [new Assert\NotBlank()],
            'tonnage_kg' => [new Assert\NotBlank()],
            'longueur' => [new Assert\NotBlank()],
            'v_largeur' => [new Assert\NotBlank()],
            'hauteur' => [new Assert\NotBlank()],
            'r_securite' => [new Assert\NotBlank()],
            'heure_circulation' => [new Assert\NotBlank()],
            'p_depart' => [new Assert\NotBlank()],
            'p_arrivee' => [new Assert\NotBlank()],
            'h_depart' => [new Assert\NotBlank()],
            'h_arrivee' => [new Assert\NotBlank()],
            'arrimage' => [new Assert\Type('bool')],
            'centrage' => [new Assert\Type('bool')],
            'signalisation' => [new Assert\Type('bool')],
            'charge_technique' => [new Assert\NotBlank()],
        ]);


        $errors = $validator->validate($data, $constraints);
        if (count($errors) > 0) {
            $violations = [];
            foreach ($errors as $e) {
                $violations[] = [
                    'champ' => $e->getPropertyPath(),
                    'message' => $e->getMessage()
                ];
            }
            return $this->json(['errors' => $violations], 400);
        }


        $clean = array_map(fn($v) => is_string($v) ? trim($v) : $v, $data);

        $entity = (new AutorisationConvoiExceptionel())
            ->setMatricule($clean['matricule'])
            ->setLieuEmission($clean['lieu_emission'])
            ->setDateEmission(new DateTime($clean['date_emission']))
            ->setRType($clean['r_type'])
            ->setRNationalite($clean['r_nationalite'])
            ->setRAddresse($clean['r_addresse'])
            ->setRTelephone($clean['r_telephone'])
            ->setVMatricule($clean['v_matricule'])
            ->setVMarque($clean['v_marque'])
            ->setVType($clean['v_type'])
            ->setTypeCharge($clean['type_charge'])
            ->setTonnageKg($clean['tonnage_kg'])
            ->setLongueur($clean['longueur'])
            ->setVLargeur($clean['v_largeur'])
            ->setHauteur($clean['hauteur'])
            ->setRSecurite($clean['r_securite'])
            ->setHeureCirculation($clean['heure_circulation'])
            ->setPDepart($clean['p_depart'])
            ->setPArrivee($clean['p_arrivee'])
            ->setHDepart(new DateTime($clean['h_depart']))
            ->setHArrivee(new DateTime($clean['h_arrivee']))
            ->setArrimage($clean['arrimage'])
            ->setCentrage($clean['centrage'])
            ->setSignalisation($clean['signalisation'])
            ->setChargeTechnique($clean['charge_technique']);

        try {
            $em->persist($entity);
            $em->flush();
        } catch (Throwable $e) {
            return $this->json(['message' => 'Erreur interne : ' . $e->getMessage()], 500);
        }

        return $this->json([
            'message' => 'Autorisation enregistrée avec succès',
            'id' => $entity->getId(),
        ], 201);
    }

    #[OA\Post(
        path: "/api/moto-taxi-autorisation",
        summary: "Créer une autorisation de taxi-moto",
        description: "Permet d’enregistrer une autorisation pour un conducteur de taxi-moto, en précisant les informations d’identification,
les données du reçu, les inspecteurs et les informations techniques de la moto.
Les champs sont validés avant enregistrement pour garantir la conformité.",
        tags: ["Autorisation Moto"],
        requestBody: new OA\RequestBody(
            required: true,
            description: "Données nécessaires à l’enregistrement d’une autorisation de taxi-moto",
            content: new OA\JsonContent(
                type: "object",
                required: [
                    "matricule",
                    "numero_recu",
                    "lieu_emission",
                    "date_emission",
                    "nom_dem",
                    "corporation",
                    "telephone_dem",
                    "m_matricule",
                    "marque_moto",
                    "inspecteur1",
                    "inspecteur2",
                    "inspecteur3"
                ],
                properties: [
                    new OA\Property(property: "matricule", type: "string", example: "MOTO-2025-0008", description: "Numéro d’enregistrement unique de l’autorisation"),
                    new OA\Property(property: "numero_recu", type: "string", example: "REC-078945", description: "Numéro de reçu de paiement officiel"),
                    new OA\Property(property: "lieu_emission", type: "string", example: "Direction Provinciale des Transports de Kinshasa", description: "Lieu d’émission de l’autorisation"),
                    new OA\Property(property: "date_emission", type: "string", format: "date", example: "2025-10-27", description: "Date d’émission au format YYYY-MM-DD"),
                    new OA\Property(property: "nom_dem", type: "string", example: "Kabeya Jean-Paul", description: "Nom complet du demandeur ou propriétaire de la moto"),
                    new OA\Property(property: "corporation", type: "string", example: "Syndicat National des Conducteurs de Taxi-Moto", description: "Nom de la corporation, syndicat ou structure affiliée"),
                    new OA\Property(property: "telephone_dem", type: "string", example: "+243810000111", description: "Numéro de téléphone valide du demandeur"),
                    new OA\Property(property: "m_matricule", type: "string", example: "KM-1234-XYZ", description: "Numéro de plaque de la moto"),
                    new OA\Property(property: "marque_moto", type: "string", example: "TVS Apache 160", description: "Marque ou modèle de la moto"),
                    new OA\Property(property: "inspecteur1", type: "string", example: "Ngoma Patrick", description: "Nom du premier inspecteur chargé du contrôle"),
                    new OA\Property(property: "inspecteur2", type: "string", example: "Mbala Marie", description: "Nom du second inspecteur"),
                    new OA\Property(property: "inspecteur3", type: "string", example: "Kanku David", description: "Nom du troisième inspecteur")
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: "Autorisation moto enregistrée avec succès",
                content: new OA\JsonContent(
                    type: "object",
                    properties: [
                        new OA\Property(property: "message", type: "string", example: "Autorisation moto enregistrée avec succès."),
                        new OA\Property(property: "id", type: "integer", example: 12)
                    ]
                )
            ),
            new OA\Response(
                response: 400,
                description: "Erreur de validation ou JSON invalide",
                content: new OA\JsonContent(
                    type: "object",
                    properties: [
                        new OA\Property(property: "message", type: "string", example: "Format JSON invalide"),
                        new OA\Property(
                            property: "errors",
                            type: "array",
                            items: new OA\Items(
                                type: "object",
                                properties: [
                                    new OA\Property(property: "champ", type: "string", example: "telephone_dem"),
                                    new OA\Property(property: "message", type: "string", example: "Ce champ ne doit pas être vide.")
                                ]
                            )
                        )
                    ]
                )
            ),
            new OA\Response(
                response: 409,
                description: "Autorisation déjà existante",
                content: new OA\JsonContent(
                    type: "object",
                    properties: [
                        new OA\Property(property: "message", type: "string", example: "Cette autorisation existe déjà.")
                    ]
                )
            ),
            new OA\Response(
                response: 500,
                description: "Erreur interne du serveur",
                content: new OA\JsonContent(
                    type: "object",
                    properties: [
                        new OA\Property(property: "message", type: "string", example: "Erreur interne : violation de contrainte SQL")
                    ]
                )
            )
        ]
    )]

    #[Route('/api/moto-taxi-autorisation', name: 'moto_autorisation_create', methods: ['POST'])]
    public function createMotoAutorisation(
        Request $request,
        EntityManagerInterface $em,
        ValidatorInterface $validator
    ): JsonResponse {

        if ($request->getContentTypeFormat() !== 'json') {
            return $this->json(['message' => 'Content-Type doit être application/json'], 400);
        }


        $data = json_decode($request->getContent(), true);
        if (!is_array($data)) {
            return $this->json(['message' => 'Format JSON invalide'], 400);
        }


        $constraints = new Assert\Collection([
            'matricule' => [new Assert\NotBlank()],
            'numero_recu' => [new Assert\NotBlank()],
            'lieu_emission' => [new Assert\NotBlank()],
            'date_emission' => [new Assert\NotBlank(), new Assert\Date()],
            'nom_dem' => [new Assert\NotBlank()],
            'corporation' => [new Assert\NotBlank()],
            'telephone_dem' => [new Assert\NotBlank(), new Assert\Regex('/^\+?[0-9]{8,15}$/')],
            'm_matricule' => [new Assert\NotBlank()],
            'marque_moto' => [new Assert\NotBlank()],
            'inspecteur1' => [new Assert\NotBlank()],
            'inspecteur2' => [new Assert\NotBlank()],
            'inspecteur3' => [new Assert\NotBlank()],
        ]);


        $errors = $validator->validate($data, $constraints);
        if (count($errors) > 0) {
            $violations = [];
            foreach ($errors as $e) {
                $violations[] = ['champ' => $e->getPropertyPath(), 'message' => $e->getMessage()];
            }
            return $this->json(['errors' => $violations], 400);
        }


        $clean = array_map(fn($v) => is_string($v) ? trim($v) : $v, $data);

        $entity = (new SurveillanceTaxiMoto())
            ->setMatricule($clean['matricule'])
            ->setNumeroRecu($clean['numero_recu'])
            ->setLieuEmission($clean['lieu_emission'])
            ->setDateEmission(new DateTime($clean['date_emission']))
            ->setNomDem($clean['nom_dem'])
            ->setCorporation($clean['corporation'])
            ->setTelephoneDem($clean['telephone_dem'])
            ->setMMatricule($clean['m_matricule'])
            ->setMarqueMoto($clean['marque_moto'])
            ->setInspecteur1($clean['inspecteur1'])
            ->setInspecteur2($clean['inspecteur2'])
            ->setInspecteur3($clean['inspecteur3']);

        try {
            $em->persist($entity);
            $em->flush();
        } catch (Throwable $e) {
            return $this->json(['message' => 'Erreur interne : ' . $e->getMessage()], 500);
        }


        return $this->json([
            'message' => 'Autorisation moto enregistrée avec succès.',
            'id' => $entity->getId()
        ], 201);
    }

    #[OA\Post(
        path: "/api/autorisation-materiaux",
        summary: "Créer une autorisation de transport de matériaux de construction",
        description: "Permet d’enregistrer une autorisation pour le transport de matériaux (bitume, gravats, sable, ciment, etc.).
Les informations du véhicule, du responsable, du tonnage et des conditions de circulation sont vérifiées et validées avant enregistrement.",
        tags: ["Autorisation Matériaux"],
        requestBody: new OA\RequestBody(
            required: true,
            description: "Toutes les données nécessaires pour enregistrer une autorisation de transport de matériaux de construction.",
            content: new OA\JsonContent(
                type: "object",
                required: [
                    "matricule",
                    "lieu_emission",
                    "date_emission",
                    "r_type",
                    "r_nationalite",
                    "r_addresse",
                    "r_telephone",
                    "v_matricule",
                    "v_marque",
                    "v_type",
                    "type_charge",
                    "tonnage_kg",
                    "r_securite",
                    "heure_circulation",
                    "p_depart",
                    "p_arrivee",
                    "h_depart",
                    "h_arrivee",
                    "arrimage",
                    "centrage",
                    "signalisation",
                    "charge_technique"
                ],
                properties: [
                    new OA\Property(property: "matricule", type: "string", example: "BTM-2025-0098", description: "Numéro d’enregistrement unique de l’autorisation de transport"),
                    new OA\Property(property: "lieu_emission", type: "string", example: "Direction Générale des Transports Routiers - Kinshasa", description: "Lieu d’émission de l’autorisation"),
                    new OA\Property(property: "date_emission", type: "string", format: "date", example: "2025-10-27", description: "Date d’émission (format ISO YYYY-MM-DD)"),
                    new OA\Property(property: "r_type", type: "string", example: "Entreprise de construction routière", description: "Type de responsable ou entité demandeuse"),
                    new OA\Property(property: "r_nationalite", type: "string", example: "Congolaise", description: "Nationalité du demandeur"),
                    new OA\Property(property: "r_addresse", type: "string", example: "Zone industrielle de Limete, Kinshasa", description: "Adresse complète du demandeur"),
                    new OA\Property(property: "r_telephone", type: "string", example: "+243810000111", description: "Numéro de téléphone du responsable (format international)"),
                    new OA\Property(property: "v_matricule", type: "string", example: "CGO-4567-AB", description: "Numéro de plaque du véhicule principal"),
                    new OA\Property(property: "v_marque", type: "string", example: "Mercedes-Benz Actros 3340", description: "Marque et modèle du véhicule"),
                    new OA\Property(property: "v_type", type: "string", example: "Camion benne", description: "Type du véhicule utilisé pour le transport"),
                    new OA\Property(property: "type_charge", type: "string", example: "Bitume chaud", description: "Nature du matériau transporté (bitume, gravats, sable, etc.)"),
                    new OA\Property(property: "tonnage_kg", type: "number", format: "float", example: 35000, description: "Poids total de la charge en kilogrammes"),
                    new OA\Property(property: "r_securite", type: "string", example: "Escorte requise pour zones urbaines", description: "Mesures ou remarques de sécurité associées au transport"),
                    new OA\Property(property: "heure_circulation", type: "string", example: "06h00 - 18h00", description: "Heures autorisées de circulation"),
                    new OA\Property(property: "p_depart", type: "string", example: "Usine d’enrobage, Kintambo", description: "Point de départ du trajet"),
                    new OA\Property(property: "p_arrivee", type: "string", example: "Chantier RN1 - Kasangulu", description: "Destination finale du convoi"),
                    new OA\Property(property: "h_depart", type: "string", example: "06:30:00", description: "Heure de départ prévue (HH:MM:SS)"),
                    new OA\Property(property: "h_arrivee", type: "string", example: "12:45:00", description: "Heure d’arrivée prévue (HH:MM:SS)"),
                    new OA\Property(property: "arrimage", type: "boolean", example: true, description: "Charge arrimée correctement"),
                    new OA\Property(property: "centrage", type: "boolean", example: true, description: "Charge bien centrée sur l’essieu"),
                    new OA\Property(property: "signalisation", type: "boolean", example: true, description: "Signalisation conforme (bâche, gyrophare, panneaux, etc.)"),
                    new OA\Property(property: "charge_technique", type: "string", example: "Bitume chaud nécessitant une température constante (≥ 150°C)", description: "Informations techniques ou conditions spéciales de transport")
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: "Autorisation enregistrée avec succès",
                content: new OA\JsonContent(
                    type: "object",
                    properties: [
                        new OA\Property(property: "message", type: "string", example: "Autorisation de convoi enregistrée avec succès."),
                        new OA\Property(property: "id", type: "integer", example: 15)
                    ]
                )
            ),
            new OA\Response(
                response: 400,
                description: "Erreur de validation ou JSON invalide",
                content: new OA\JsonContent(
                    type: "object",
                    properties: [
                        new OA\Property(property: "message", type: "string", example: "Format JSON invalide"),
                        new OA\Property(
                            property: "errors",
                            type: "array",
                            items: new OA\Items(
                                type: "object",
                                properties: [
                                    new OA\Property(property: "champ", type: "string", example: "r_telephone"),
                                    new OA\Property(property: "message", type: "string", example: "Numéro de téléphone invalide.")
                                ]
                            )
                        )
                    ]
                )
            ),
            new OA\Response(
                response: 409,
                description: "Autorisation déjà existante",
                content: new OA\JsonContent(
                    type: "object",
                    properties: [new OA\Property(property: "message", type: "string", example: "Cette autorisation existe déjà.")]
                )
            ),
            new OA\Response(
                response: 500,
                description: "Erreur interne lors de l’enregistrement",
                content: new OA\JsonContent(
                    type: "object",
                    properties: [new OA\Property(property: "message", type: "string", example: "Erreur interne : violation de contrainte SQL")]
                )
            )
        ]
    )]

    #[Route('/api/autorisation-materiaux', name: 'autorisation_bitume_create', methods: ['POST'])]
    public function createAutorisationBitume(
        Request $request,
        EntityManagerInterface $em,
        ValidatorInterface $validator
    ): JsonResponse {

        if ($request->getContentTypeFormat() !== 'json') {
            return $this->json(['message' => 'Content-Type doit être application/json'], 400);
        }


        $data = json_decode($request->getContent(), true);
        if (!is_array($data)) {
            return $this->json(['message' => 'Format JSON invalide'], 400);
        }

        $constraints = new Assert\Collection([
            'matricule' => [new Assert\NotBlank()],
            'lieu_emission' => [new Assert\NotBlank()],
            'date_emission' => [new Assert\NotBlank(), new Assert\Date()],
            'r_type' => [new Assert\NotBlank()],
            'r_nationalite' => [new Assert\NotBlank()],
            'r_addresse' => [new Assert\NotBlank()],
            'r_telephone' => [new Assert\NotBlank(), new Assert\Regex('/^\+?[0-9]{8,15}$/')],
            'v_matricule' => [new Assert\NotBlank()],
            'v_marque' => [new Assert\NotBlank()],
            'v_type' => [new Assert\NotBlank()],
            'type_charge' => [new Assert\NotBlank()],
            'tonnage_kg' => [new Assert\NotBlank()],
            'r_securite' => [new Assert\NotBlank()],
            'heure_circulation' => [new Assert\NotBlank()],
            'p_depart' => [new Assert\NotBlank()],
            'p_arrivee' => [new Assert\NotBlank()],
            'h_depart' => [new Assert\NotBlank()],
            'h_arrivee' => [new Assert\NotBlank()],
            'arrimage' => [new Assert\Type('bool')],
            'centrage' => [new Assert\Type('bool')],
            'signalisation' => [new Assert\Type('bool')],
            'charge_technique' => [new Assert\NotBlank()],
        ]);

        $errors = $validator->validate($data, $constraints);
        if (count($errors) > 0) {
            $violations = [];
            foreach ($errors as $e) {
                $violations[] = ['champ' => $e->getPropertyPath(), 'message' => $e->getMessage()];
            }
            return $this->json(['errors' => $violations], 400);
        }

        $clean = array_map(fn($v) => is_string($v) ? trim($v) : $v, $data);


        $entity = (new AutorisationMateriauxConstruction())
            ->setMatricule($clean['matricule'])
            ->setLieuEmission($clean['lieu_emission'])
            ->setDateEmission(new DateTime($clean['date_emission']))
            ->setRType($clean['r_type'])
            ->setRNationalite($clean['r_nationalite'])
            ->setRAddresse($clean['r_addresse'])
            ->setRTelephone($clean['r_telephone'])
            ->setVMatricule($clean['v_matricule'])
            ->setVMarque($clean['v_marque'])
            ->setVType($clean['v_type'])
            ->setTypeCharge($clean['type_charge'])
            ->setTonnageKg($clean['tonnage_kg'])
            ->setRSecurite($clean['r_securite'])
            ->setHeureCirculation($clean['heure_circulation'])
            ->setPDepart($clean['p_depart'])
            ->setPArrivee($clean['p_arrivee'])
            ->setHDepart(new DateTime($clean['h_depart']))
            ->setHArrivee(new DateTime($clean['h_arrivee']))
            ->setArrimage($clean['arrimage'])
            ->setCentrage($clean['centrage'])
            ->setSignalisation($clean['signalisation'])
            ->setChargeTechnique($clean['charge_technique']);


        try {
            $em->persist($entity);
            $em->flush();
        } catch (Throwable $e) {
            return $this->json(['message' => 'Erreur interne : ' . $e->getMessage()], 500);
        }


        return $this->json([
            'message' => 'Autorisation de convoi enregistrée avec succès.',
            'id' => $entity->getId()
        ], 201);
    }

    #[OA\Post(
        path: "/api/autorisation-controle",
        summary: "Créer une autorisation de contrôle de convoi",
        description: "Enregistre une fiche de contrôle pour un convoi routier ou exceptionnel.
Cette API permet de consigner toutes les informations relatives au véhicule, au responsable, aux inspecteurs, et aux observations réalisées sur le terrain.",
        tags: ["Autorisation Contrôle"],
        requestBody: new OA\RequestBody(
            required: true,
            description: "Toutes les données nécessaires pour enregistrer une autorisation de contrôle de convoi.",
            content: new OA\JsonContent(
                type: "object",
                required: [
                    "matricule","lieu_emission","date_emission","r_type","r_nationalite","r_addresse",
                    "r_telephone","v_matricule","v_marque","v_type","type_charge","tonnage_kg","longueur",
                    "v_largeur","hauteur","arrimage","centrage","signalisation","p_depart","p_arrivee",
                    "h_depart","h_arrivee","raison_arret","observations_generales","approuve",
                    "inspecteur_nom","equipe1","equipe1_contact","equipe2","equipe2_contact","equipe3","euipe3_contact"
                ],
                properties: [
                    new OA\Property(property: "matricule", type: "string", example: "CTRL-2025-045", description: "Numéro unique d’autorisation de contrôle"),
                    new OA\Property(property: "lieu_emission", type: "string", example: "Direction Régionale des Transports Lubumbashi", description: "Lieu d’émission du contrôle"),
                    new OA\Property(property: "date_emission", type: "string", format: "date", example: "2025-10-27", description: "Date du contrôle au format YYYY-MM-DD"),
                    new OA\Property(property: "r_type", type: "string", example: "Entreprise de transport international", description: "Type du responsable du convoi"),
                    new OA\Property(property: "r_nationalite", type: "string", example: "Zambienne", description: "Nationalité de l’opérateur"),
                    new OA\Property(property: "r_addresse", type: "string", example: "Route Kasumbalesa, poste frontière", description: "Adresse complète du responsable"),
                    new OA\Property(property: "r_telephone", type: "string", example: "+260978543210", description: "Numéro de téléphone du responsable"),
                    new OA\Property(property: "v_matricule", type: "string", example: "ZMB-TRK-2025-012", description: "Matricule du véhicule contrôlé"),
                    new OA\Property(property: "v_marque", type: "string", example: "Volvo FH16", description: "Marque et modèle du véhicule"),
                    new OA\Property(property: "v_type", type: "string", example: "Camion semi-remorque", description: "Type de véhicule"),
                    new OA\Property(property: "type_charge", type: "string", example: "Ciment en sacs", description: "Nature de la marchandise transportée"),
                    new OA\Property(property: "tonnage_kg", type: "number", format: "float", example: 42000, description: "Poids total de la charge en kg"),
                    new OA\Property(property: "longueur", type: "number", format: "float", example: 17.5, description: "Longueur totale du véhicule"),
                    new OA\Property(property: "v_largeur", type: "number", format: "float", example: 2.6, description: "Largeur totale du véhicule"),
                    new OA\Property(property: "hauteur", type: "number", format: "float", example: 4.1, description: "Hauteur totale du véhicule"),
                    new OA\Property(property: "arrimage", type: "boolean", example: true, description: "Charge arrimée correctement"),
                    new OA\Property(property: "centrage", type: "boolean", example: true, description: "Charge centrée correctement"),
                    new OA\Property(property: "signalisation", type: "boolean", example: true, description: "Signalisation conforme (panneaux, gyrophares, etc.)"),
                    new OA\Property(property: "p_depart", type: "string", example: "Entrepôt SNCC Lubumbashi", description: "Point de départ du convoi"),
                    new OA\Property(property: "p_arrivee", type: "string", example: "Dépôt Cimenterie PPC Likasi", description: "Destination du convoi"),
                    new OA\Property(property: "h_depart", type: "string", example: "07:30:00", description: "Heure de départ prévue"),
                    new OA\Property(property: "h_arrivee", type: "string", example: "10:45:00", description: "Heure d’arrivée prévue"),
                    new OA\Property(property: "raison_arret", type: "string", example: "Contrôle de surcharge routière", description: "Motif principal de l’arrêt du convoi"),
                    new OA\Property(property: "observations_generales", type: "string", example: "Convoi conforme après inspection complète.", description: "Observations ou remarques du contrôleur"),
                    new OA\Property(property: "approuve", type: "boolean", example: true, description: "Statut d’approbation du contrôle (true = approuvé)"),
                    new OA\Property(property: "inspecteur_nom", type: "string", example: "Kasongo Patrick", description: "Nom complet de l’inspecteur principal"),
                    new OA\Property(property: "equipe1", type: "string", example: "Ngoma Albert", description: "Nom du premier membre de l’équipe de contrôle"),
                    new OA\Property(property: "equipe1_contact", type: "string", example: "+243810999222", description: "Contact du premier membre"),
                    new OA\Property(property: "equipe2", type: "string", example: "Mbuyi Clarisse", description: "Nom du second membre de l’équipe"),
                    new OA\Property(property: "equipe2_contact", type: "string", example: "+243819888111", description: "Contact du second membre"),
                    new OA\Property(property: "equipe3", type: "string", example: "Kalala David", description: "Nom du troisième membre de l’équipe"),
                    new OA\Property(property: "euipe3_contact", type: "string", example: "+243821777000", description: "Contact du troisième membre")
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: "Contrôle de convoi enregistré avec succès",
                content: new OA\JsonContent(
                    type: "object",
                    properties: [
                        new OA\Property(property: "message", type: "string", example: "Autorisation de convoi enregistrée avec succès."),
                        new OA\Property(property: "id", type: "integer", example: 21)
                    ]
                )
            ),
            new OA\Response(
                response: 400,
                description: "Erreur de validation ou JSON invalide",
                content: new OA\JsonContent(
                    type: "object",
                    properties: [
                        new OA\Property(property: "message", type: "string", example: "Format JSON invalide"),
                        new OA\Property(
                            property: "errors",
                            type: "array",
                            items: new OA\Items(
                                type: "object",
                                properties: [
                                    new OA\Property(property: "champ", type: "string", example: "r_telephone"),
                                    new OA\Property(property: "message", type: "string", example: "Numéro de téléphone invalide.")
                                ]
                            )
                        )
                    ]
                )
            ),
            new OA\Response(
                response: 500,
                description: "Erreur interne du serveur",
                content: new OA\JsonContent(
                    type: "object",
                    properties: [
                        new OA\Property(property: "message", type: "string", example: "Erreur interne : violation de contrainte SQL")
                    ]
                )
            )
        ]
    )]

    #[Route('/api/autorisation-controle', name: 'autorisation_controle_create', methods: ['POST'])]
    public function createAutorisationControle(
        Request $request,
        EntityManagerInterface $em,
        ValidatorInterface $validator
    ): JsonResponse {

        if ($request->getContentTypeFormat() !== 'json') {
            return $this->json(['message' => 'Content-Type doit être application/json'], 400);
        }


        $data = json_decode($request->getContent(), true);
        if (!is_array($data)) {
            return $this->json(['message' => 'Format JSON invalide'], 400);
        }


        $constraints = new Assert\Collection([
            'matricule' => [new Assert\NotBlank()],
            'lieu_emission' => [new Assert\NotBlank()],
            'date_emission' => [new Assert\NotBlank(), new Assert\Date()],
            'r_type' => [new Assert\NotBlank()],
            'r_nationalite' => [new Assert\NotBlank()],
            'r_addresse' => [new Assert\NotBlank()],
            'r_telephone' => [new Assert\NotBlank(), new Assert\Regex('/^\+?[0-9]{8,15}$/')],
            'v_matricule' => [new Assert\NotBlank()],
            'v_marque' => [new Assert\NotBlank()],
            'v_type' => [new Assert\NotBlank()],
            'type_charge' => [new Assert\NotBlank()],
            'tonnage_kg' => [new Assert\NotBlank()],
            'longueur' => [new Assert\NotBlank()],
            'v_largeur' => [new Assert\NotBlank()],
            'hauteur' => [new Assert\NotBlank()],
            'arrimage' => [new Assert\Type('bool')],
            'centrage' => [new Assert\Type('bool')],
            'signalisation' => [new Assert\Type('bool')],
            'p_depart' => [new Assert\NotBlank()],
            'p_arrivee' => [new Assert\NotBlank()],
            'h_depart' => [new Assert\NotBlank()],
            'h_arrivee' => [new Assert\NotBlank()],
            'raison_arret' => [new Assert\NotBlank()],
            'observations_generales' => [new Assert\NotBlank()],
            'approuve' => [new Assert\Type('bool')],
            'inspecteur_nom' => [new Assert\NotBlank()],
            'equipe1' => [new Assert\NotBlank()],
            'equipe1_contact' => [new Assert\NotBlank()],
            'equipe2' => [new Assert\NotBlank()],
            'equipe2_contact' => [new Assert\NotBlank()],
            'equipe3' => [new Assert\NotBlank()],
            'euipe3_contact' => [new Assert\NotBlank()],
        ]);


        $errors = $validator->validate($data, $constraints);
        if (count($errors) > 0) {
            $violations = [];
            foreach ($errors as $e) {
                $violations[] = [
                    'champ' => $e->getPropertyPath(),
                    'message' => $e->getMessage()
                ];
            }
            return $this->json(['errors' => $violations], 400);
        }


        $clean = array_map(fn($v) => is_string($v) ? trim($v) : $v, $data);


        $entity = (new InspectionConvoi())
            ->setMatricule($clean['matricule'])
            ->setLieuEmission($clean['lieu_emission'])
            ->setDateEmission(new DateTime($clean['date_emission']))
            ->setRType($clean['r_type'])
            ->setRNationalite($clean['r_nationalite'])
            ->setRAddresse($clean['r_addresse'])
            ->setRTelephone($clean['r_telephone'])
            ->setVMatricule($clean['v_matricule'])
            ->setVMarque($clean['v_marque'])
            ->setVType($clean['v_type'])
            ->setTypeCharge($clean['type_charge'])
            ->setTonnageKg($clean['tonnage_kg'])
            ->setLongueur($clean['longueur'])
            ->setVLargeur($clean['v_largeur'])
            ->setHauteur($clean['hauteur'])
            ->setArrimage($clean['arrimage'])
            ->setCentrage($clean['centrage'])
            ->setSignalisation($clean['signalisation'])
            ->setPDepart($clean['p_depart'])
            ->setPArrivee($clean['p_arrivee'])
            ->setHDepart(new DateTime($clean['h_depart']))
            ->setHArrivee(new DateTime($clean['h_arrivee']))
            ->setRaisonArret($clean['raison_arret'])
            ->setObservationsGenerales($clean['observations_generales'])
            ->setApprouve($clean['approuve'])
            ->setInspecteurNom($clean['inspecteur_nom'])
            ->setEquipe1($clean['equipe1'])
            ->setEquipe1Contact($clean['equipe1_contact'])
            ->setEquipe2($clean['equipe2'])
            ->setEquipe2Contact($clean['equipe2_contact'])
            ->setEquipe3($clean['equipe3'])
            ->setEuipe3Contact($clean['euipe3_contact']);


        try {
            $em->persist($entity);
            $em->flush();
        } catch (Throwable $e) {
            return $this->json(['message' => 'Erreur interne : ' . $e->getMessage()], 500);
        }


        return $this->json([
            'message' => 'Autorisation de convoi enregistrée avec succès.',
            'id' => $entity->getId()
        ], 201);
    }

    #[OA\Post(
        path: "/api/autorisation-chargement",
        summary: "Créer une autorisation de transport de marchandises",
        description: "Permet d’enregistrer une autorisation officielle pour le transport de marchandises
dans le cadre du contrôle routier. Les informations sur le véhicule, le responsable, le tonnage et les conditions de transport sont exigées.",
        tags: ["Autorisation Marchandises"],
        requestBody: new OA\RequestBody(
            required: true,
            description: "Toutes les données nécessaires pour créer une autorisation de transport de marchandises.",
            content: new OA\JsonContent(
                type: "object",
                required: [
                    "matricule", "numero_recu", "lieu_emission", "date_emission", "r_organisation",
                    "r_nationalite", "r_addresse", "r_telephone", "v_matricule", "type_charge",
                    "tonnage_kg", "signalisation", "couverture", "p_depart", "p_arrivee",
                    "h_depart", "h_arrivee", "nom_inspecteur", "approuvee"
                ],
                properties: [
                    new OA\Property(property: "matricule", type: "string", example: "CHG-2025-024", description: "Numéro unique de l’autorisation"),
                    new OA\Property(property: "numero_recu", type: "string", example: "RC-090875", description: "Numéro du reçu de perception lié à l’autorisation"),
                    new OA\Property(property: "lieu_emission", type: "string", example: "Direction Provinciale des Transports du Katanga", description: "Lieu où l’autorisation a été émise"),
                    new OA\Property(property: "date_emission", type: "string", format: "date", example: "2025-10-27", description: "Date d’émission de l’autorisation"),
                    new OA\Property(property: "r_organisation", type: "string", example: "Transco RDC", description: "Organisation ou entreprise responsable du transport"),
                    new OA\Property(property: "r_nationalite", type: "string", example: "Congolaise", description: "Nationalité du transporteur ou de l’entreprise"),
                    new OA\Property(property: "r_addresse", type: "string", example: "Avenue Poids Lourds, Kinshasa", description: "Adresse complète de l’entreprise"),
                    new OA\Property(property: "r_telephone", type: "string", example: "+243810123456", description: "Téléphone du responsable"),
                    new OA\Property(property: "v_matricule", type: "string", example: "CGO-TRK-087", description: "Numéro d’immatriculation du véhicule"),
                    new OA\Property(property: "type_charge", type: "string", example: "Matériaux de construction", description: "Nature de la marchandise transportée"),
                    new OA\Property(property: "tonnage_kg", type: "number", format: "float", example: 27000, description: "Tonnage total du chargement (en kilogrammes)"),
                    new OA\Property(property: "signalisation", type: "boolean", example: true, description: "Indique si la signalisation est conforme (bâches, gyrophare, etc.)"),
                    new OA\Property(property: "couverture", type: "boolean", example: true, description: "Indique si la marchandise est correctement couverte"),
                    new OA\Property(property: "p_depart", type: "string", example: "Carrière de Mont-Ngafula", description: "Point de départ du transport"),
                    new OA\Property(property: "p_arrivee", type: "string", example: "Chantier Université de Kinshasa", description: "Destination finale de la marchandise"),
                    new OA\Property(property: "h_depart", type: "string", example: "06:30:00", description: "Heure de départ prévue"),
                    new OA\Property(property: "h_arrivee", type: "string", example: "09:45:00", description: "Heure d’arrivée prévue"),
                    new OA\Property(property: "nom_inspecteur", type: "string", example: "Mbuyi Jean-Paul", description: "Nom complet de l’inspecteur ayant validé le transport"),
                    new OA\Property(property: "approuvee", type: "boolean", example: true, description: "Statut d’approbation de l’autorisation (true = approuvée)")
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: "Autorisation enregistrée avec succès",
                content: new OA\JsonContent(
                    type: "object",
                    properties: [
                        new OA\Property(property: "message", type: "string", example: "Autorisation de transport de marchandises enregistrée avec succès."),
                        new OA\Property(property: "id", type: "integer", example: 17)
                    ]
                )
            ),
            new OA\Response(
                response: 400,
                description: "Erreur de validation ou JSON invalide",
                content: new OA\JsonContent(
                    type: "object",
                    properties: [
                        new OA\Property(property: "message", type: "string", example: "Format JSON invalide"),
                        new OA\Property(
                            property: "errors",
                            type: "array",
                            items: new OA\Items(
                                type: "object",
                                properties: [
                                    new OA\Property(property: "champ", type: "string", example: "r_telephone"),
                                    new OA\Property(property: "message", type: "string", example: "Ce champ est obligatoire.")
                                ]
                            )
                        )
                    ]
                )
            ),
            new OA\Response(
                response: 500,
                description: "Erreur interne du serveur",
                content: new OA\JsonContent(
                    type: "object",
                    properties: [
                        new OA\Property(property: "message", type: "string", example: "Erreur interne : violation de contrainte SQL")
                    ]
                )
            )
        ]
    )]

    #[Route('/api/autorisation-chargement', name: 'autorisation_marchandise_create', methods: ['POST'])]
    public function createAutorisationMarchandise(
        Request $request,
        EntityManagerInterface $em,
        ValidatorInterface $validator
    ): JsonResponse {

        if ($request->getContentTypeFormat() !== 'json') {
            return $this->json(['message' => 'Content-Type doit être application/json'], 400);
        }


        $data = json_decode($request->getContent(), true);
        if (!is_array($data)) {
            return $this->json(['message' => 'Format JSON invalide'], 400);
        }


        $constraints = new Assert\Collection([
            'matricule' => [new Assert\NotBlank()],
            'numero_recu' => [new Assert\NotBlank()],
            'lieu_emission' => [new Assert\NotBlank()],
            'date_emission' => [new Assert\NotBlank(), new Assert\Date()],
            'r_organisation' => [new Assert\NotBlank()],
            'r_nationalite' => [new Assert\NotBlank()],
            'r_addresse' => [new Assert\NotBlank()],
            'r_telephone' => [new Assert\NotBlank(), new Assert\Regex('/^\+?[0-9]{8,15}$/')],
            'v_matricule' => [new Assert\NotBlank()],
            'type_charge' => [new Assert\NotBlank()],
            'tonnage_kg' => [new Assert\NotBlank()],
            'signalisation' => [new Assert\Type('bool')],
            'couverture' => [new Assert\Type('bool')],
            'p_depart' => [new Assert\NotBlank()],
            'p_arrivee' => [new Assert\NotBlank()],
            'h_depart' => [new Assert\NotBlank()],
            'h_arrivee' => [new Assert\NotBlank()],
            'nom_inspecteur' => [new Assert\NotBlank()],
            'approuvee' => [new Assert\Type('bool')],
        ]);


        $errors = $validator->validate($data, $constraints);
        if (count($errors) > 0) {
            $violations = [];
            foreach ($errors as $e) {
                $violations[] = [
                    'champ' => $e->getPropertyPath(),
                    'message' => $e->getMessage()
                ];
            }
            return $this->json(['errors' => $violations], 400);
        }

        $clean = array_map(fn($v) => is_string($v) ? trim($v) : $v, $data);


        $entity = (new SurveillanceChargement())
            ->setMatricule($clean['matricule'])
            ->setNumeroRecu($clean['numero_recu'])
            ->setLieuEmission($clean['lieu_emission'])
            ->setDateEmission(new DateTime($clean['date_emission']))
            ->setROrganisation($clean['r_organisation'])
            ->setRNationalite($clean['r_nationalite'])
            ->setRAddresse($clean['r_addresse'])
            ->setRTelephone($clean['r_telephone'])
            ->setVMatricule($clean['v_matricule'])
            ->setTypeCharge($clean['type_charge'])
            ->setTonnageKg($clean['tonnage_kg'])
            ->setSignalisation($clean['signalisation'])
            ->setCouverture($clean['couverture'])
            ->setPDepart($clean['p_depart'])
            ->setPArrivee($clean['p_arrivee'])
            ->setHDepart(new DateTime($clean['h_depart']))
            ->setHArrivee(new DateTime($clean['h_arrivee']))
            ->setNomInspecteur($clean['nom_inspecteur'])
            ->setApprouvee($clean['approuvee']);

        try {
            $em->persist($entity);
            $em->flush();
        } catch (Throwable $e) {
            return $this->json(['message' => 'Erreur interne : ' . $e->getMessage()], 500);
        }


        return $this->json([
            'message' => 'Autorisation de transport de marchandises enregistrée avec succès.',
            'id' => $entity->getId()
        ], 201);
    }

    #[OA\Post(
        path: "/api/quittance",
        summary: "Créer une quittance officielle de perception ou de paiement",
        description: "Permet d’enregistrer une quittance émise par la direction des transports
ou la régie financière. Ce document atteste du paiement d’un droit, d’une taxe ou d’un service lié
à l’autorisation de transport.",
        tags: ["Quittance"],
        requestBody: new OA\RequestBody(
            required: true,
            description: "Toutes les informations nécessaires pour créer une quittance officielle.",
            content: new OA\JsonContent(
                type: "object",
                required: [
                    "matricule", "type_quittance", "lieu_emission", "date_emmision",
                    "assujettif", "numero_perception", "montant_chiffres", "montant",
                    "banque", "numero_compte", "mode_payement", "nature_impo", "receveur_drlu"
                ],
                properties: [
                    new OA\Property(property: "matricule", type: "string", example: "QTC-2025-009", description: "Numéro unique de la quittance (référence interne)"),
                    new OA\Property(property: "type_quittance", type: "string", example: "Droit de circulation poids-lourds", description: "Type ou catégorie de la quittance"),
                    new OA\Property(property: "lieu_emission", type: "string", example: "Direction Générale des Transports - Kinshasa", description: "Lieu où la quittance est émise"),
                    new OA\Property(property: "date_emmision", type: "string", format: "date", example: "2025-10-27", description: "Date d’émission de la quittance (format YYYY-MM-DD)"),
                    new OA\Property(property: "assujettif", type: "string", example: "Société Congo Transport SARL", description: "Nom du contribuable ou de l’entreprise assujettie au paiement"),
                    new OA\Property(property: "numero_perception", type: "string", example: "PC-2025-483", description: "Numéro de perception du paiement (doit être unique)"),
                    new OA\Property(property: "montant_chiffres", type: "string", example: "500000", description: "Montant payé exprimé en chiffres"),
                    new OA\Property(property: "montant", type: "string", example: "Cinq cent mille francs congolais (500 000 FC)", description: "Montant payé exprimé en lettres"),
                    new OA\Property(property: "banque", type: "string", example: "RAWBANK SA", description: "Banque par laquelle le paiement a été effectué"),
                    new OA\Property(property: "numero_compte", type: "string", example: "001-987654321-09", description: "Numéro de compte bancaire de la perception"),
                    new OA\Property(property: "mode_payement", type: "string", example: "Virement bancaire", description: "Mode de paiement utilisé (espèces, virement, mobile money, etc.)"),
                    new OA\Property(property: "nature_impo", type: "string", example: "Taxe annuelle d’exploitation routière", description: "Nature de l’impôt ou de la taxe perçue"),
                    new OA\Property(property: "receveur_drlu", type: "string", example: "Mulongo André", description: "Nom complet du receveur de la DRLU (Direction de la Recette Locale Unique)")
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: "Quittance enregistrée avec succès",
                content: new OA\JsonContent(
                    type: "object",
                    properties: [
                        new OA\Property(property: "message", type: "string", example: "Quittance enregistrée avec succès."),
                        new OA\Property(property: "id", type: "integer", example: 42)
                    ]
                )
            ),
            new OA\Response(
                response: 400,
                description: "Erreur de validation ou JSON invalide",
                content: new OA\JsonContent(
                    type: "object",
                    properties: [
                        new OA\Property(property: "message", type: "string", example: "Format JSON invalide"),
                        new OA\Property(
                            property: "errors",
                            type: "array",
                            items: new OA\Items(
                                type: "object",
                                properties: [
                                    new OA\Property(property: "champ", type: "string", example: "date_emmision"),
                                    new OA\Property(property: "message", type: "string", example: "Cette date n’est pas valide.")
                                ]
                            )
                        )
                    ]
                )
            ),
            new OA\Response(
                response: 409,
                description: "Quittance déjà existante",
                content: new OA\JsonContent(
                    type: "object",
                    properties: [
                        new OA\Property(property: "message", type: "string", example: "Cette quittance existe déjà.")
                    ]
                )
            ),
            new OA\Response(
                response: 500,
                description: "Erreur interne du serveur",
                content: new OA\JsonContent(
                    type: "object",
                    properties: [
                        new OA\Property(property: "message", type: "string", example: "Erreur interne : violation de contrainte SQL")
                    ]
                )
            )
        ]
    )]
    #[Route('/api/quittance', name: 'quittance_create', methods: ['POST'])]
    public function createQuittance(
        Request $request,
        EntityManagerInterface $em,
        ValidatorInterface $validator
    ): JsonResponse {

        if ($request->getContentTypeFormat() !== 'json') {
            return $this->json(['message' => 'Content-Type doit être application/json'], 400);
        }


        $data = json_decode($request->getContent(), true);
        if (!is_array($data)) {
            return $this->json(['message' => 'Format JSON invalide'], 400);
        }


        $constraints = new Assert\Collection([
            'matricule' => [new Assert\NotBlank()],
            'type_quittance' => [new Assert\NotBlank()],
            'lieu_emission' => [new Assert\NotBlank()],
            'date_emmision' => [new Assert\NotBlank(), new Assert\Date()],
            'assujettif' => [new Assert\NotBlank()],
            'numero_perception' => [new Assert\NotBlank()],
            'montant_chiffres' => [new Assert\NotBlank()],
            'montant' => [new Assert\NotBlank()],
            'banque' => [new Assert\NotBlank()],
            'numero_compte' => [new Assert\NotBlank()],
            'mode_payement' => [new Assert\NotBlank()],
            'nature_impo' => [new Assert\NotBlank()],
            'receveur_drlu' => [new Assert\NotBlank()],
        ]);


        $errors = $validator->validate($data, $constraints);
        if (count($errors) > 0) {
            $violations = [];
            foreach ($errors as $e) {
                $violations[] = [
                    'champ' => $e->getPropertyPath(),
                    'message' => $e->getMessage()
                ];
            }
            return $this->json(['errors' => $violations], 400);
        }

        $clean = array_map(fn($v) => is_string($v) ? trim($v) : $v, $data);

        $entity = (new Quittance())
            ->setMatricule($clean['matricule'])
            ->setTypeQuittance($clean['type_quittance'])
            ->setLieuEmission($clean['lieu_emission'])
            ->setDateEmmision(new DateTime($clean['date_emmision']))
            ->setAssujettif($clean['assujettif'])
            ->setNumeroPerception($clean['numero_perception'])
            ->setMontantChiffres($clean['montant_chiffres'])
            ->setMontant($clean['montant'])
            ->setBanque($clean['banque'])
            ->setNumeroCompte($clean['numero_compte'])
            ->setModePayement($clean['mode_payement'])
            ->setNatureImpo($clean['nature_impo'])
            ->setReceveurDrlu($clean['receveur_drlu']);


        try {
            $em->persist($entity);
            $em->flush();
        } catch (Throwable $e) {
            return $this->json(['message' => 'Erreur interne : ' . $e->getMessage()], 500);
        }


        return $this->json([
            'message' => 'Quittance enregistrée avec succès.',
            'id' => $entity->getId()
        ], 201);
    }
}

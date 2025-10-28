<?php

namespace App\Controller\api;

use App\Entity\AutaurisationConvoiExceptionnel;
use App\Entity\AutorisationCirculationConstruction;
use App\Entity\AutorisationConvoiExceptionel;
use App\Entity\AutorisationMateriauxConstruction;
use App\Entity\InspectionConvoi;
use App\Entity\Quittance;
use App\Entity\SurveillanceChargement;
use App\Entity\SurveillanceTaxiMoto;
use App\Entity\SurveillanceTechnique;
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
        description: "Permet d’enregistrer une autorisation de convoi exceptionnel avec toutes les informations du requérant, du véhicule, de la charge et du trajet.",
        tags: ["Autorisation Convoi"],
        requestBody: new OA\RequestBody(
            required: true,
            description: "Toutes les données nécessaires pour l’autorisation de convoi exceptionnel.",
            content: new OA\JsonContent(
                type: "object",
                required: [
                    "requerant",
                    "nationalite",
                    "typeDePersonne",
                    "coordonnee",
                    "telephone",
                    "immatriculation",
                    "marque",
                    "typeDeVihicule",
                    "typeDeCharge",
                    "tonnage",
                    "categorie",
                    "longueur",
                    "largueur",
                    "hauteur",
                    "conditionDeSecurite",
                    "heureDeCirculation",
                    "pointDeDepart",
                    "pointArrive",
                    "heureDeDepart",
                    "heureArrivee",
                    "lieuDEmission",
                    "arrimage",
                    "signalisation",
                    "centrage"
                ],
                properties: [
                    new OA\Property(property: "requerant", type: "string", example: "Société BTP Congo SARL"),
                    new OA\Property(property: "nationalite", type: "string", example: "Congolaise"),
                    new OA\Property(property: "typeDePersonne", type: "string", example: "Entreprise"),
                    new OA\Property(property: "coordonnee", type: "string", example: "Zone industrielle, Limete"),
                    new OA\Property(property: "telephone", type: "string", example: "+243810000111"),
                    new OA\Property(property: "immatriculation", type: "string", example: "CGO-4567-AB"),
                    new OA\Property(property: "marque", type: "string", example: "Volvo FH16"),
                    new OA\Property(property: "typeDeVihicule", type: "string", example: "Tracteur routier"),
                    new OA\Property(property: "typeDeCharge", type: "string", example: "Transformateur électrique"),
                    new OA\Property(property: "tonnage", type: "string", example: "85000"),
                    new OA\Property(property: "categorie", type: "string", example: "Convoi exceptionnel lourd"),
                    new OA\Property(property: "longueur", type: "string", example: "28.5"),
                    new OA\Property(property: "largueur", type: "string", example: "4.2"),
                    new OA\Property(property: "hauteur", type: "string", example: "4.8"),
                    new OA\Property(property: "conditionDeSecurite", type: "string", example: "Escorte gendarmerie obligatoire"),
                    new OA\Property(property: "heureDeCirculation", type: "string", example: "06h00 - 18h00"),
                    new OA\Property(property: "pointDeDepart", type: "string", example: "Usine Cimenterie de Figuil"),
                    new OA\Property(property: "pointArrive", type: "string", example: "Chantier BTP Garoua"),
                    new OA\Property(property: "heureDeDepart", type: "string", example: "06:30:00"),
                    new OA\Property(property: "heureArrivee", type: "string", example: "16:30:00"),
                    new OA\Property(property: "lieuDEmission", type: "string", example: "Direction régionale du Littoral"),
                    new OA\Property(property: "arrimage", type: "string", example: "OK"),
                    new OA\Property(property: "signalisation", type: "string", example: "Conforme"),
                    new OA\Property(property: "centrage", type: "string", example: "Bon équilibrage")
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
                        new OA\Property(property: "id", type: "integer", example: 5)
                    ]
                )
            ),
            new OA\Response(
                response: 400,
                description: "Erreur de validation",
                content: new OA\JsonContent(
                    type: "object",
                    properties: [
                        new OA\Property(property: "message", type: "string", example: "Format JSON invalide"),
                        new OA\Property(property: "errors", type: "array", items: new OA\Items(
                            type: "object",
                            properties: [
                                new OA\Property(property: "champ", type: "string"),
                                new OA\Property(property: "message", type: "string")
                            ]
                        ))
                    ]
                )
            )
        ]
    )]
    #[Route('/api/autorisation-convoi', name: 'autorisation_convoi_create', methods: ['POST'])]
    public function createAutorisationConvoi(
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
            'requerant' => [new Assert\NotBlank()],
            'nationalite' => [new Assert\NotBlank()],
            'typeDePersonne' => [new Assert\NotBlank()],
            'coordonnee' => [new Assert\NotBlank()],
            'telephone' => [new Assert\NotBlank(), new Assert\Regex('/^\+?[0-9]{8,15}$/')],
            'immatriculation' => [new Assert\NotBlank()],
            'marque' => [new Assert\NotBlank()],
            'typeDeVihicule' => [new Assert\NotBlank()],
            'typeDeCharge' => [new Assert\NotBlank()],
            'tonnage' => [new Assert\NotBlank()],
            'categorie' => [new Assert\NotBlank()],
            'longueur' => [new Assert\NotBlank()],
            'largueur' => [new Assert\NotBlank()],
            'hauteur' => [new Assert\NotBlank()],
            'conditionDeSecurite' => [new Assert\NotBlank()],
            'heureDeCirculation' => [new Assert\NotBlank()],
            'pointDeDepart' => [new Assert\NotBlank()],
            'pointArrive' => [new Assert\NotBlank()],
            'heureDeDepart' => [new Assert\NotBlank()],
            'heureArrivee' => [new Assert\NotBlank()],
            'lieuDEmission' => [new Assert\NotBlank()],
            'arrimage' => [new Assert\NotBlank()],
            'signalisation' => [new Assert\NotBlank()],
            'centrage' => [new Assert\NotBlank()],
        ]);

        $errors = $validator->validate($data, $constraints);
        if (count($errors) > 0) {
            $violations = [];
            foreach ($errors as $e) {
                $violations[] = ['champ' => $e->getPropertyPath(), 'message' => $e->getMessage()];
            }
            return $this->json(['errors' => $violations], 400);
        }

        $entity = (new AutaurisationConvoiExceptionnel())
            ->setRequerant($data['requerant'])
            ->setNationalite($data['nationalite'])
            ->setTypeDePersonne($data['typeDePersonne'])
            ->setCoordonnee($data['coordonnee'])
            ->setTelephone($data['telephone'])
            ->setImmatriculation($data['immatriculation'])
            ->setMarque($data['marque'])
            ->setTypeDeVihicule($data['typeDeVihicule'])
            ->setTypeDeCharge($data['typeDeCharge'])
            ->setTonnage($data['tonnage'])
            ->setCategorie($data['categorie'])
            ->setLongueur($data['longueur'])
            ->setLargueur($data['largueur'])
            ->setHauteur($data['hauteur'])
            ->setConditionDeSecurite($data['conditionDeSecurite'])
            ->setHeureDeCirculation($data['heureDeCirculation'])
            ->setPointDeDepart($data['pointDeDepart'])
            ->setPointArrive($data['pointArrive'])
            ->setHeureDeDepart($data['heureDeDepart'])
            ->setHeureArrivee($data['heureArrivee'])
            ->setLieuDEmission($data['lieuDEmission'])
            ->setArrimage($data['arrimage'])
            ->setSignalisation($data['signalisation'])
            ->setCentrage($data['centrage']);

        try {
            $em->persist($entity);
            $em->flush();
        } catch (\Throwable $e) {
            return $this->json(['message' => 'Erreur interne : ' . $e->getMessage()], 500);
        }

        return $this->json([
            'message' => 'Autorisation enregistrée avec succès.',
            'id' => $entity->getId()
        ], 201);
    }


    #[OA\Post(
        path: "/api/autorisation-chargement",
        summary: "Créer une autorisation de transport de marchandises",
        description: "Enregistre une autorisation de transport de marchandises avec les informations sur le responsable, le véhicule, le tonnage et la conformité du chargement.",
        tags: ["Autorisation Marchandises"],
        requestBody: new OA\RequestBody(
            required: true,
            description: "Toutes les données nécessaires pour enregistrer une autorisation de transport de marchandises.",
            content: new OA\JsonContent(
                type: "object",
                required: [
                    "nom", "nationnalite", "organisation", "adresse", "telephone",
                    "typeDeCharge", "immatriculation", "tonnage", "couverture",
                    "signalisation", "inspecteurRoutier", "lieuEmission",
                    "pointDeDepart", "pointArrive", "heureDeDepart", "heureArrivee"
                ],
                properties: [
                    new OA\Property(property: "nom", type: "string", example: "Kibasonga Merdi"),
                    new OA\Property(property: "nationnalite", type: "string", example: "Congolaise"),
                    new OA\Property(property: "organisation", type: "string", example: "Transco RDC"),
                    new OA\Property(property: "adresse", type: "string", example: "Avenue Poids Lourds, Kinshasa"),
                    new OA\Property(property: "telephone", type: "string", example: "+243810123456"),
                    new OA\Property(property: "typeDeCharge", type: "string", example: "Matériaux de construction"),
                    new OA\Property(property: "immatriculation", type: "string", example: "CGO-TRK-087"),
                    new OA\Property(property: "tonnage", type: "string", example: "27000"),
                    new OA\Property(property: "couverture", type: "string", example: "Bâche complète"),
                    new OA\Property(property: "signalisation", type: "string", example: "Gyrophare + panneaux latéraux"),
                    new OA\Property(property: "inspecteurRoutier", type: "string", example: "Mbuyi Jean-Paul"),
                    new OA\Property(property: "lieuEmission", type: "string", example: "Direction Provinciale des Transports du Katanga"),
                    new OA\Property(property: "pointDeDepart", type: "string", example: "Carrière de Mont-Ngafula"),
                    new OA\Property(property: "pointArrive", type: "string", example: "Chantier Université de Kinshasa"),
                    new OA\Property(property: "heureDeDepart", type: "string", example: "06:30:00"),
                    new OA\Property(property: "heureArrivee", type: "string", example: "09:45:00")
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
                        new OA\Property(property: "id", type: "integer", example: 10)
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
                        new OA\Property(property: "errors", type: "array", items: new OA\Items(
                            type: "object",
                            properties: [
                                new OA\Property(property: "champ", type: "string"),
                                new OA\Property(property: "message", type: "string")
                            ]
                        ))
                    ]
                )
            ),
            new OA\Response(
                response: 500,
                description: "Erreur interne",
                content: new OA\JsonContent(
                    type: "object",
                    properties: [new OA\Property(property: "message", type: "string", example: "Erreur interne : violation de contrainte SQL")]
                )
            )
        ]
    )]
    #[Route('/api/autorisation-chargement', name: 'autorisation_marchandise_create', methods: ['POST'])]
    public function createAutorisationChargement(
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
            'nom' => [new Assert\NotBlank()],
            'nationnalite' => [new Assert\NotBlank()],
            'organisation' => [new Assert\NotBlank()],
            'adresse' => [new Assert\NotBlank()],
            'telephone' => [new Assert\NotBlank(), new Assert\Regex('/^\+?[0-9]{8,15}$/')],
            'typeDeCharge' => [new Assert\NotBlank()],
            'immatriculation' => [new Assert\NotBlank()],
            'tonnage' => [new Assert\NotBlank()],
            'couverture' => [new Assert\NotBlank()],
            'signalisation' => [new Assert\NotBlank()],
            'inspecteurRoutier' => [new Assert\NotBlank()],
            'lieuEmission' => [new Assert\NotBlank()],
            'pointDeDepart' => [new Assert\NotBlank()],
            'pointArrive' => [new Assert\NotBlank()],
            'heureDeDepart' => [new Assert\NotBlank()],
            'heureArrivee' => [new Assert\NotBlank()],
        ]);

        $errors = $validator->validate($data, $constraints);
        if (count($errors) > 0) {
            $violations = [];
            foreach ($errors as $e) {
                $violations[] = ['champ' => $e->getPropertyPath(), 'message' => $e->getMessage()];
            }
            return $this->json(['errors' => $violations], 400);
        }

        $entity = (new SurveillanceTechnique())
            ->setNom($data['nom'])
            ->setNationnalite($data['nationnalite'])
            ->setOrganisation($data['organisation'])
            ->setAdresse($data['adresse'])
            ->setTelephone($data['telephone'])
            ->setTypeDeCharge($data['typeDeCharge'])
            ->setImmatriculation($data['immatriculation'])
            ->setTonnage($data['tonnage'])
            ->setCouverture($data['couverture'])
            ->setSignalisation($data['signalisation'])
            ->setInspecteurRoutier($data['inspecteurRoutier'])
            ->setLieuEmission($data['lieuEmission'])
            ->setPointDeDepart($data['pointDeDepart'])
            ->setPointArrive($data['pointArrive'])
            ->setHeureDeDepart($data['heureDeDepart'])
            ->setHeureArrivee($data['heureArrivee']);

        try {
            $em->persist($entity);
            $em->flush();
        } catch (\Throwable $e) {
            return $this->json(['message' => 'Erreur interne : ' . $e->getMessage()], 500);
        }

        return $this->json([
            'message' => 'Autorisation enregistrée avec succès.',
            'id' => $entity->getId()
        ], 201);
    }


    #[OA\Post(
        path: "/api/autorisation-materiaux",
        summary: "Créer une autorisation de transport de matériaux de construction",
        description: "Permet d’enregistrer une autorisation pour le transport de matériaux (bitume, gravats, sable, ciment, etc.).
Les informations du requérant, du véhicule, du tonnage et des conditions de sécurité sont validées avant enregistrement.",
        tags: ["Autorisation Matériaux"],
        requestBody: new OA\RequestBody(
            required: true,
            description: "Toutes les données nécessaires pour enregistrer une autorisation de transport de matériaux de construction.",
            content: new OA\JsonContent(
                type: "object",
                required: [
                    "requerant",
                    "nationalite",
                    "typeDePersonne",
                    "coordonnee",
                    "telephone",
                    "immatriculation",
                    "marque",
                    "typeDeVihicule",
                    "typeDeCharge",
                    "tonnage",
                    "conditionDeSecurite",
                    "heureDeCirculation",
                    "pointDeDepart",
                    "pointArrive",
                    "heureDeDepart",
                    "heureArrivee",
                    "lieuDEmission"
                ],
                properties: [
                    new OA\Property(property: "requerant", type: "string", example: "Société BTP Congo", description: "Nom du requérant ou entreprise"),
                    new OA\Property(property: "nationalite", type: "string", example: "Congolaise", description: "Nationalité du requérant"),
                    new OA\Property(property: "typeDePersonne", type: "string", example: "Entreprise", description: "Type de requérant (Entreprise ou Particulier)"),
                    new OA\Property(property: "coordonnee", type: "string", example: "Avenue du Port, Kinshasa", description: "Adresse ou coordonnées complètes"),
                    new OA\Property(property: "telephone", type: "string", example: "+243810000111", description: "Numéro de téléphone du requérant"),
                    new OA\Property(property: "immatriculation", type: "string", example: "CGO-4567-AB", description: "Numéro de plaque du véhicule"),
                    new OA\Property(property: "marque", type: "string", example: "Mercedes-Benz Actros 3340", description: "Marque et modèle du véhicule"),
                    new OA\Property(property: "typeDeVihicule", type: "string", example: "Camion benne", description: "Type de véhicule"),
                    new OA\Property(property: "typeDeCharge", type: "string", example: "Bitume chaud", description: "Nature du matériau transporté"),
                    new OA\Property(property: "tonnage", type: "string", example: "35000", description: "Poids total de la charge (en kg)"),
                    new OA\Property(property: "conditionDeSecurite", type: "string", example: "Escorte requise", description: "Conditions ou remarques de sécurité"),
                    new OA\Property(property: "heureDeCirculation", type: "string", example: "06h00 - 18h00", description: "Plage horaire autorisée pour la circulation"),
                    new OA\Property(property: "pointDeDepart", type: "string", example: "Usine d’enrobage, Kintambo", description: "Point de départ du trajet"),
                    new OA\Property(property: "pointArrive", type: "string", example: "Chantier RN1 - Kasangulu", description: "Point d’arrivée du trajet"),
                    new OA\Property(property: "heureDeDepart", type: "string", example: "06:30:00", description: "Heure prévue de départ (HH:MM:SS)"),
                    new OA\Property(property: "heureArrivee", type: "string", example: "12:45:00", description: "Heure prévue d’arrivée (HH:MM:SS)"),
                    new OA\Property(property: "lieuDEmission", type: "string", example: "Direction Régionale des Transports - Kinshasa", description: "Lieu d’émission de l’autorisation")
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
                        new OA\Property(property: "id", type: "integer", example: 1)
                    ]
                )
            ),
            new OA\Response(
                response: 400,
                description: "Erreur de validation ou JSON invalide",
                content: new OA\JsonContent(
                    type: "object",
                    properties: [
                        new OA\Property(property: "message", type: "string", example: "Format JSON invalide."),
                        new OA\Property(
                            property: "errors",
                            type: "array",
                            items: new OA\Items(
                                type: "object",
                                properties: [
                                    new OA\Property(property: "champ", type: "string", example: "telephone"),
                                    new OA\Property(property: "message", type: "string", example: "Numéro de téléphone invalide.")
                                ]
                            )
                        )
                    ]
                )
            ),
            new OA\Response(
                response: 500,
                description: "Erreur interne",
                content: new OA\JsonContent(
                    type: "object",
                    properties: [new OA\Property(property: "message", type: "string", example: "Erreur interne : violation de contrainte SQL.")]
                )
            )
        ]
    )]
    #[Route('/api/autorisation-materiaux', name: 'autorisation_materiaux_create', methods: ['POST'])]
    public function createAutorisationMateriaux(
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
            'requerant' => [new Assert\NotBlank()],
            'nationalite' => [new Assert\NotBlank()],
            'typeDePersonne' => [new Assert\NotBlank()],
            'coordonnee' => [new Assert\NotBlank()],
            'telephone' => [new Assert\NotBlank(), new Assert\Regex('/^\+?[0-9]{8,15}$/')],
            'immatriculation' => [new Assert\NotBlank()],
            'marque' => [new Assert\NotBlank()],
            'typeDeVihicule' => [new Assert\NotBlank()],
            'typeDeCharge' => [new Assert\NotBlank()],
            'tonnage' => [new Assert\NotBlank()],
            'conditionDeSecurite' => [new Assert\NotBlank()],
            'heureDeCirculation' => [new Assert\NotBlank()],
            'pointDeDepart' => [new Assert\NotBlank()],
            'pointArrive' => [new Assert\NotBlank()],
            'heureDeDepart' => [new Assert\NotBlank()],
            'heureArrivee' => [new Assert\NotBlank()],
            'lieuDEmission' => [new Assert\NotBlank()],
        ]);

        $errors = $validator->validate($data, $constraints);
        if (count($errors) > 0) {
            $violations = [];
            foreach ($errors as $e) {
                $violations[] = [
                    'champ' => $e->getPropertyPath(),
                    'message' => $e->getMessage(),
                ];
            }
            return $this->json(['errors' => $violations], 400);
        }

        $entity = (new AutorisationCirculationConstruction())
            ->setRequerant($data['requerant'])
            ->setNationalite($data['nationalite'])
            ->setTypeDePersonne($data['typeDePersonne'])
            ->setCoordonnee($data['coordonnee'])
            ->setTelephone($data['telephone'])
            ->setImmatriculation($data['immatriculation'])
            ->setMarque($data['marque'])
            ->setTypeDeVihicule($data['typeDeVihicule'])
            ->setTypeDeCharge($data['typeDeCharge'])
            ->setTonnage($data['tonnage'])
            ->setConditionDeSecurite($data['conditionDeSecurite'])
            ->setHeureDeCirculation($data['heureDeCirculation'])
            ->setPointDeDepart($data['pointDeDepart'])
            ->setPointArrive($data['pointArrive'])
            ->setHeureDeDepart($data['heureDeDepart'])
            ->setHeureArrivee($data['heureArrivee'])
            ->setLieuDEmission($data['lieuDEmission']);

        try {
            $em->persist($entity);
            $em->flush();
        } catch (\Throwable $e) {
            return $this->json(['message' => 'Erreur interne : ' . $e->getMessage()], 500);
        }

        return $this->json([
            'message' => 'Autorisation enregistrée avec succès.',
            'id' => $entity->getId(),
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

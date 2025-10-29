<?php

namespace App\Controller\api;

use App\Entity\AutaurisationConvoiExceptionnel;
use App\Entity\AutorisationCirculationConstruction;
use App\Entity\InspectionConvoiExceTechnique;
use App\Entity\QuittanceCnpr;
use App\Entity\SurveillanceEmbarquementMoto;
use App\Entity\SurveillanceTechnique;
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
    public function createAutorisationConvoi(Request $request, EntityManagerInterface $em, ValidatorInterface $validator): JsonResponse
    {
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
            ->setArrimage($data['arrimage'])
            ->setSignalisation($data['signalisation'])
            ->setCentrage($data['centrage']);

        try {
            $em->persist($entity);
            $em->flush();
        } catch (Throwable $e) {
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
                    "signalisation", "inspecteurRoutier",
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
    public function createAutorisationChargement(Request $request, EntityManagerInterface $em, ValidatorInterface $validator): JsonResponse
    {
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
            ->setPointDeDepart($data['pointDeDepart'])
            ->setPointArrive($data['pointArrive'])
            ->setHeureDeDepart($data['heureDeDepart'])
            ->setHeureArrivee($data['heureArrivee']);

        try {
            $em->persist($entity);
            $em->flush();
        } catch (Throwable $e) {
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
                    "heureArrivee"
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
                    new OA\Property(property: "heureArrivee", type: "string", example: "12:45:00", description: "Heure prévue d’arrivée (HH:MM:SS)")
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
    public function createAutorisationMateriaux(Request $request, EntityManagerInterface $em, ValidatorInterface $validator): JsonResponse
    {
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
            'heureArrivee' => [new Assert\NotBlank()]
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
            ->setHeureArrivee($data['heureArrivee']);

        try {
            $em->persist($entity);
            $em->flush();
        } catch (Throwable $e) {
            return $this->json(['message' => 'Erreur interne : ' . $e->getMessage()], 500);
        }

        return $this->json([
            'message' => 'Autorisation enregistrée avec succès.',
            'id' => $entity->getId(),
        ], 201);
    }
    #[OA\Post(
        path: "/api/inspection-convoi-technique",
        summary: "Créer une inspection technique de convoi exceptionnel",
        description: "Permet d’enregistrer les informations techniques et logistiques d’un convoi exceptionnel, y compris les mesures de sécurité, les dimensions et l’équipe d’inspection.",
        tags: ["Inspection Convoi Exceptionnel"],
        requestBody: new OA\RequestBody(
            required: true,
            description: "Toutes les données nécessaires à l’enregistrement d’une inspection technique de convoi exceptionnel.",
            content: new OA\JsonContent(
                type: "object",
                required: [
                    "requerant", "nationalite", "typeDePersonne", "coordonnee", "telephone",
                    "immatriculation", "marque", "typeDeVihicule", "typeDeCharge",
                    "pointDeDepart", "pointArrive", "heureDeDepart", "heureArrivee",
                    "categorie", "longueur", "largueur", "hauteur",
                    "arrimage", "signalisation", "centrage"
                ],
                properties: [
                    new OA\Property(property: "requerant", type: "string", example: "Société Générale des Travaux"),
                    new OA\Property(property: "nationalite", type: "string", example: "Congolaise"),
                    new OA\Property(property: "typeDePersonne", type: "string", example: "Entreprise"),
                    new OA\Property(property: "coordonnee", type: "string", example: "Zone industrielle de Limete, Kinshasa"),
                    new OA\Property(property: "telephone", type: "string", example: "+243810123456"),
                    new OA\Property(property: "immatriculation", type: "string", example: "CGO-EXC-9087"),
                    new OA\Property(property: "marque", type: "string", example: "Volvo FH16"),
                    new OA\Property(property: "typeDeVihicule", type: "string", example: "Tracteur + semi-remorque"),
                    new OA\Property(property: "typeDeCharge", type: "string", example: "Turbine hydroélectrique"),
                    new OA\Property(property: "pointDeDepart", type: "string", example: "Port de Matadi"),
                    new OA\Property(property: "pointArrive", type: "string", example: "Barrage d’Inga"),
                    new OA\Property(property: "heureDeDepart", type: "string", example: "05:00:00"),
                    new OA\Property(property: "heureArrivee", type: "string", example: "18:30:00"),
                    new OA\Property(property: "categorie", type: "string", example: "Convoi exceptionnel lourd"),
                    new OA\Property(property: "longueur", type: "string", example: "32.5"),
                    new OA\Property(property: "largueur", type: "string", example: "4.8"),
                    new OA\Property(property: "hauteur", type: "string", example: "5.2"),
                    new OA\Property(property: "arrimage", type: "string", example: "OK"),
                    new OA\Property(property: "signalisation", type: "string", example: "Conforme"),
                    new OA\Property(property: "centrage", type: "string", example: "Bien équilibré"),
                    new OA\Property(property: "observations", type: "string", example: "Inspection effectuée sans incident majeur."),
                    new OA\Property(
                        property: "equipe",
                        type: "array",
                        items: new OA\Items(type: "string"),
                        example: ["Inspecteur Mbuyi", "Agent Kanza", "Technicien Ilunga"]
                    ),
                    new OA\Property(property: "contact", type: "string", example: "+243820000111")
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: "Inspection enregistrée avec succès",
                content: new OA\JsonContent(
                    type: "object",
                    properties: [
                        new OA\Property(property: "message", type: "string", example: "Inspection technique enregistrée avec succès."),
                        new OA\Property(property: "id", type: "integer", example: 25)
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
                                    new OA\Property(property: "champ", type: "string"),
                                    new OA\Property(property: "message", type: "string")
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
                    properties: [new OA\Property(property: "message", type: "string", example: "Erreur interne : violation de contrainte SQL")]
                )
            )
        ]
    )]
    #[Route('/api/inspection-convoi-technique', name: 'inspection_convoi_create', methods: ['POST'])]
    public function createInspectionConvoi(Request $request, EntityManagerInterface $em, ValidatorInterface $validator): JsonResponse
    {
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
            'pointDeDepart' => [new Assert\NotBlank()],
            'pointArrive' => [new Assert\NotBlank()],
            'heureDeDepart' => [new Assert\NotBlank()],
            'heureArrivee' => [new Assert\NotBlank()],
            'categorie' => [new Assert\NotBlank()],
            'longueur' => [new Assert\NotBlank()],
            'largueur' => [new Assert\NotBlank()],
            'hauteur' => [new Assert\NotBlank()],
            'arrimage' => [new Assert\NotBlank()],
            'signalisation' => [new Assert\NotBlank()],
            'centrage' => [new Assert\NotBlank()],
            'observations' => [],
            'equipe' => [],
            'contact' => [],
        ]);

        $errors = $validator->validate($data, $constraints);
        if (count($errors) > 0) {
            $violations = [];
            foreach ($errors as $e) {
                $violations[] = ['champ' => $e->getPropertyPath(), 'message' => $e->getMessage()];
            }
            return $this->json(['errors' => $violations], 400);
        }

        $entity = (new InspectionConvoiExceTechnique())
            ->setRequerant($data['requerant'])
            ->setNationalite($data['nationalite'])
            ->setTypeDePersonne($data['typeDePersonne'])
            ->setCoordonnee($data['coordonnee'])
            ->setTelephone($data['telephone'])
            ->setImmatriculation($data['immatriculation'])
            ->setMarque($data['marque'])
            ->setTypeDeVihicule($data['typeDeVihicule'])
            ->setTypeDeCharge($data['typeDeCharge'])
            ->setPointDeDepart($data['pointDeDepart'])
            ->setPointArrive($data['pointArrive'])
            ->setHeureDeDepart($data['heureDeDepart'])
            ->setHeureArrivee($data['heureArrivee'])
            ->setCategorie($data['categorie'])
            ->setLongueur($data['longueur'])
            ->setLargueur($data['largueur'])
            ->setHauteur($data['hauteur'])
            ->setArrimage($data['arrimage'])
            ->setSignalisation($data['signalisation'])
            ->setCentrage($data['centrage'])
            ->setObservations($data['observations'] ?? null)
            ->setEquipe($data['equipe'] ?? null)
            ->setContact($data['contact'] ?? null);

        try {
            $em->persist($entity);
            $em->flush();
        } catch (Throwable $e) {
            return $this->json(['message' => 'Erreur interne : ' . $e->getMessage()], 500);
        }

        return $this->json([
            'message' => 'Inspection technique enregistrée avec succès.',
            'id' => $entity->getId()
        ], 201);
    }
    #[OA\Post(
        path: "/api/embarquement-moto",
        summary: "Créer une fiche de surveillance d’embarquement de moto",
        description: "Permet d’enregistrer une surveillance d’embarquement de moto, incluant les informations du conducteur, du véhicule, de la corporation, et des inspecteurs routiers présents.",
        tags: ["Surveillance Embarquement Moto"],
        requestBody: new OA\RequestBody(
            required: true,
            description: "Toutes les informations nécessaires pour enregistrer une fiche de surveillance d’embarquement de moto.",
            content: new OA\JsonContent(
                type: "object",
                required: ["nom", "corporation", "marque"],
                properties: [
                    new OA\Property(property: "nom", type: "string", example: "Mbuyi Jean-Paul", description: "Nom complet du conducteur ou du responsable de la moto"),
                    new OA\Property(property: "corporation", type: "string", example: "Moto-Taxi Matadi", description: "Nom de la corporation, coopérative ou syndicat du conducteur"),
                    new OA\Property(property: "tel", type: "string", example: "+243810123456", description: "Numéro de téléphone du conducteur"),
                    new OA\Property(property: "immatriculation", type: "string", example: "CGO-MOTO-1234", description: "Numéro d’immatriculation de la moto"),
                    new OA\Property(property: "marque", type: "string", example: "TVS Star HLX 125", description: "Marque et modèle de la moto"),
                    new OA\Property(
                        property: "inspecteursRoutiers",
                        type: "array",
                        items: new OA\Items(type: "string"),
                        example: ["Inspecteur Ilunga", "Agent Kabasele", "Agent Muswamba"],
                        description: "Liste des inspecteurs routiers ayant participé à la surveillance"
                    )
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: "Fiche de surveillance enregistrée avec succès",
                content: new OA\JsonContent(
                    type: "object",
                    properties: [
                        new OA\Property(property: "message", type: "string", example: "Surveillance d’embarquement de moto enregistrée avec succès."),
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
                                    new OA\Property(property: "champ", type: "string", example: "nom"),
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
                    properties: [new OA\Property(property: "message", type: "string", example: "Erreur interne : violation de contrainte SQL")]
                )
            )
        ]
    )]
    #[Route('/api/embarquement-moto', name: 'surveillance_embarquement_moto_create', methods: ['POST'])]
    public function createEmbarquementMoto(Request $request, EntityManagerInterface $em, ValidatorInterface $validator):JsonResponse
    {
        if ($request->getContentTypeFormat() !== 'json') {
            return $this->json(['message' => 'Content-Type doit être application/json'], 400);
        }

        $data = json_decode($request->getContent(), true);
        if (!is_array($data)) {
            return $this->json(['message' => 'Format JSON invalide'], 400);
        }

        // ✅ Validation des champs requis
        $constraints = new Assert\Collection([
            'nom' => [new Assert\NotBlank()],
            'corporation' => [new Assert\NotBlank()],
            'tel' => [new Assert\Optional(new Assert\Regex('/^\+?[0-9]{8,15}$/'))],
            'immatriculation' => [new Assert\Optional()],
            'marque' => [new Assert\NotBlank()],
            'inspecteursRoutiers' => [new Assert\Optional()],
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

        // ✅ Enregistrement en base
        $entity = (new SurveillanceEmbarquementMoto())
            ->setNom($data['nom'])
            ->setCorporation($data['corporation'])
            ->setTel($data['tel'] ?? null)
            ->setImmatriculation($data['immatriculation'] ?? null)
            ->setMarque($data['marque'])
            ->setInspecteursRoutiers($data['inspecteursRoutiers'] ?? null);

        try {
            $em->persist($entity);
            $em->flush();
        } catch (Throwable $e) {
            return $this->json(['message' => 'Erreur interne : ' . $e->getMessage()], 500);
        }

        return $this->json([
            'message' => 'Surveillance d’embarquement de moto enregistrée avec succès.',
            'id' => $entity->getId()
        ], 201);
    }

    #[OA\Post(
        path: "/api/quittance-cnpr",
        summary: "Créer une quittance CNPR",
        description: "Permet d’enregistrer une quittance CNPR, incluant les informations de l’assujetti, le montant encaissé, le mode de paiement, la nature de l’imposition et les coordonnées bancaires.",
        tags: ["CNPR - Quittances"],
        requestBody: new OA\RequestBody(
            required: true,
            description: "Toutes les données nécessaires pour enregistrer une quittance CNPR.",
            content: new OA\JsonContent(
                type: "object",
                required: ["assujetti", "modeEncaisseEnChiffres", "ModeEncaisseEnLettres"],
                properties: [
                    new OA\Property(property: "assujetti", type: "string", example: "Société des Transports du Katanga", description: "Nom ou raison sociale de l’assujetti concerné par la quittance."),
                    new OA\Property(property: "numeroDeTaxation", type: "string", example: "TX-2025-0458", description: "Numéro de taxation ou référence fiscale associée."),
                    new OA\Property(property: "modeEncaisseEnChiffres", type: "string", format: "string", example: "250000.00", description: "Montant encaissé exprimé en chiffres."),
                    new OA\Property(property: "ModeEncaisseEnLettres", type: "string", example: "Deux cent cinquante mille francs congolais", description: "Montant encaissé exprimé en lettres."),
                    new OA\Property(property: "banqueBeneficiaire", type: "string", example: "RAWBANK SA", description: "Nom de la banque bénéficiaire du paiement."),
                    new OA\Property(property: "numeroDeCompte", type: "string", example: "00011002233445566", description: "Numéro de compte bancaire du bénéficiaire."),
                    new OA\Property(property: "modeDePaiement", type: "string", example: "Virement bancaire", description: "Mode de paiement utilisé (Espèces, Virement, Chèque, etc.)."),
                    new OA\Property(property: "natureDeLimpositionPayee", type: "string", example: "Taxe sur le transport routier", description: "Nature de l’imposition ou redevance concernée par la quittance.")
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: "Quittance CNPR enregistrée avec succès",
                content: new OA\JsonContent(
                    type: "object",
                    properties: [
                        new OA\Property(property: "message", type: "string", example: "Quittance CNPR enregistrée avec succès."),
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
                description: "Erreur interne du serveur",
                content: new OA\JsonContent(
                    type: "object",
                    properties: [new OA\Property(property: "message", type: "string", example: "Erreur interne : violation de contrainte SQL")]
                )
            )
        ]
    )]
    #[Route('/api/quittance-cnpr', name: 'quittance_cnpr_create', methods: ['POST'])]
    public function createQuittanceCnpr(Request $request, EntityManagerInterface $em, ValidatorInterface $validator): JsonResponse
    {
        if ($request->getContentTypeFormat() !== 'json') {
            return $this->json(['message' => 'Content-Type doit être application/json'], 400);
        }

        $data = json_decode($request->getContent(), true);
        if (!is_array($data)) {
            return $this->json(['message' => 'Format JSON invalide'], 400);
        }

        // ✅ Validation des champs
        $constraints = new Assert\Collection([
            'assujetti' => [new Assert\NotBlank()],
            'numeroDeTaxation' => [new Assert\Optional()],
            'modeEncaisseEnChiffres' => [new Assert\NotBlank()],
            'ModeEncaisseEnLettres' => [new Assert\NotBlank()],
            'banqueBeneficiaire' => [new Assert\Optional()],
            'numeroDeCompte' => [new Assert\Optional()],
            'modeDePaiement' => [new Assert\Optional()],
            'natureDeLimpositionPayee' => [new Assert\Optional()],
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

        // ✅ Création de l’entité
        $entity = (new QuittanceCnpr())
            ->setAssujetti($data['assujetti'])
            ->setNumeroDeTaxation($data['numeroDeTaxation'] ?? null)
            ->setModeEncaisseEnChiffres($data['modeEncaisseEnChiffres'])
            ->setModeEncaisseEnLettres($data['ModeEncaisseEnLettres'])
            ->setBanqueBeneficiaire($data['banqueBeneficiaire'] ?? null)
            ->setNumeroDeCompte($data['numeroDeCompte'] ?? null)
            ->setModeDePaiement($data['modeDePaiement'] ?? null)
            ->setNatureDeLimpositionPayee($data['natureDeLimpositionPayee'] ?? null);

        try {
            $em->persist($entity);
            $em->flush();
        } catch (Throwable $e) {
            return $this->json(['message' => 'Erreur interne : ' . $e->getMessage()], 500);
        }

        return $this->json([
            'message' => 'Quittance CNPR enregistrée avec succès.',
            'id' => $entity->getId()
        ], 201);
    }



}

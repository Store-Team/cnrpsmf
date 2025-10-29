<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use OpenApi\Attributes as OA;

final class AutorisationMateriauxController extends AbstractController
{
    #[OA\Get(
        path: "/api/autorisation-materiaux/list",
        summary: "Lister toutes les autorisations de transport de matériaux enregistrées",
        description: "Retourne la liste paginée de toutes les autorisations pour le transport de matériaux de construction, triées du plus récent au plus ancien.",
        tags: ["Autorisation Matériaux"],
        parameters: [
            new OA\Parameter(name: "page", in: "query", required: false, schema: new OA\Schema(type: "integer"), example: 1),
            new OA\Parameter(name: "limit", in: "query", required: false, schema: new OA\Schema(type: "integer"), example: 10)
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Liste paginée des autorisations de matériaux",
                content: new OA\JsonContent(
                    type: "object",
                    properties: [
                        new OA\Property(property: "page", type: "integer"),
                        new OA\Property(property: "limit", type: "integer"),
                        new OA\Property(property: "total", type: "integer"),
                        new OA\Property(
                            property: "data",
                            type: "array",
                            items: new OA\Items(type: "object", properties: [
                                new OA\Property(property: "id", type: "integer", example: 1),
                                new OA\Property(property: "requerant", type: "string", example: "Société BTP Congo"),
                                new OA\Property(property: "nationalite", type: "string", example: "Congolaise"),
                                new OA\Property(property: "typeDePersonne", type: "string", example: "Entreprise"),
                                new OA\Property(property: "coordonnee", type: "string", example: "Avenue du Port, Kinshasa"),
                                new OA\Property(property: "telephone", type: "string", example: "+243810000111"),
                                new OA\Property(property: "immatriculation", type: "string", example: "CGO-4567-AB"),
                                new OA\Property(property: "marque", type: "string", example: "Mercedes Actros 3340"),
                                new OA\Property(property: "typeDeVihicule", type: "string", example: "Camion benne"),
                                new OA\Property(property: "typeDeCharge", type: "string", example: "Bitume chaud"),
                                new OA\Property(property: "tonnage", type: "string", example: "35000"),
                                new OA\Property(property: "conditionDeSecurite", type: "string", example: "Escorte requise"),
                                new OA\Property(property: "heureDeCirculation", type: "string", example: "06h00 - 18h00"),
                                new OA\Property(property: "pointDeDepart", type: "string", example: "Usine Kintambo"),
                                new OA\Property(property: "pointArrive", type: "string", example: "Chantier Kasangulu"),
                                new OA\Property(property: "heureDeDepart", type: "string", example: "06:30:00"),
                                new OA\Property(property: "heureArrivee", type: "string", example: "12:45:00"),
                                new OA\Property(property: "createdAt", type: "string", format: "date-time", example: "2025-10-28T12:45:00Z")
                            ])
                        )
                    ]
                )
            )
        ]
    )]
    #[Route('/api/autorisation-materiaux/list', name: 'autorisation_materiaux_list', methods: ['GET'])]
    public function listMateriaux(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $conn = $em->getConnection();
        $page = max(1, (int)$request->query->get('page', 1));
        $limit = max(1, (int)$request->query->get('limit', 10));
        $offset = ($page - 1) * $limit;

        try {
            $sql = "
            SELECT
                id, requerant, nationalite, type_de_personne AS typeDePersonne, coordonnee, telephone,
                immatriculation, marque, type_de_vihicule AS typeDeVihicule,
                type_de_charge AS typeDeCharge, tonnage, condition_de_securite AS conditionDeSecurite,
                heure_de_circulation AS heureDeCirculation, point_de_depart AS pointDeDepart,
                point_arrive AS pointArrive, heure_de_depart AS heureDeDepart, heure_arrivee AS heureArrivee,
                created_at AS createdAt
            FROM autorisation_circulation_construction
            ORDER BY created_at DESC
            LIMIT :limit OFFSET :offset
        ";

            $data = $conn->fetchAllAssociative($sql, ['limit' => $limit, 'offset' => $offset]);
            $total = (int) $conn->fetchOne("SELECT COUNT(id) FROM autorisation_circulation_construction");
        } catch (\Throwable $e) {
            return $this->json(['message' => 'Erreur SQL : '.$e->getMessage()], 500);
        }

        return $this->json([
            'page' => $page,
            'limit' => $limit,
            'total' => $total,
            'data' => $data,
        ]);
    }

    #[OA\Get(
        path: "/api/autorisation-materiaux/total",
        summary: "Obtenir le nombre total des autorisations de transport de matériaux enregistrées",
        tags: ["Autorisation Matériaux"],
        responses: [
            new OA\Response(
                response: 200,
                description: "Total global des fichiers",
                content: new OA\JsonContent(properties: [
                    new OA\Property(property: "total", type: "integer", example: 128)
                ])
            )
        ]
    )]
    #[Route('/api/autorisation-materiaux/total', name: 'autorisation_materiaux_total', methods: ['GET'])]
    public function totalMateriaux(EntityManagerInterface $em): JsonResponse
    {
        try {
            $total = (int) $em->getConnection()->fetchOne("SELECT COUNT(id) FROM autorisation_circulation_construction");
            return $this->json(['total' => $total]);
        } catch (\Throwable $e) {
            return $this->json(['message' => 'Erreur SQL : '.$e->getMessage()], 500);
        }
    }
    #[OA\Get(
        path: "/api/autorisation-materiaux/stats/monthly",
        summary: "Statistiques mensuelles des autorisations de transport de matériaux",
        tags: ["Autorisation Matériaux"],
        responses: [
            new OA\Response(
                response: 200,
                description: "Nombre de fichiers générés par mois",
                content: new OA\JsonContent(type: "array", items: new OA\Items(properties: [
                    new OA\Property(property: "mois", type: "string", example: "2025-09"),
                    new OA\Property(property: "total", type: "integer", example: 14)
                ]))
            )
        ]
    )]
    #[Route('/api/autorisation-materiaux/stats/monthly', name: 'autorisation_materiaux_stats_monthly', methods: ['GET'])]
    public function statsMonthlyMateriaux(EntityManagerInterface $em): JsonResponse
    {
        $conn = $em->getConnection();

        try {
            $sql = "
            SELECT
                DATE_FORMAT(created_at, '%Y-%m') AS mois,
                COUNT(id) AS total
            FROM autorisation_circulation_construction
            GROUP BY mois
            ORDER BY mois ASC
        ";
            $results = $conn->fetchAllAssociative($sql);
            return $this->json($results);
        } catch (\Throwable $e) {
            return $this->json(['message' => 'Erreur SQL : '.$e->getMessage()], 500);
        }
    }

    #[OA\Get(
        path: "/api/autorisation-materiaux/stats/weekly",
        summary: "Statistiques hebdomadaires : activité journalière entre deux mois",
        tags: ["Autorisation Matériaux"],
        parameters: [
            new OA\Parameter(name: "startMonth", in: "query", required: true, schema: new OA\Schema(type: "string"), example: "2025-08"),
            new OA\Parameter(name: "endMonth", in: "query", required: true, schema: new OA\Schema(type: "string"), example: "2025-10")
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Nombre d’autorisations par jour",
                content: new OA\JsonContent(type: "array", items: new OA\Items(properties: [
                    new OA\Property(property: "jour", type: "string", example: "Lundi"),
                    new OA\Property(property: "total", type: "integer", example: 8)
                ]))
            )
        ]
    )]
    #[Route('/api/autorisation-materiaux/stats/weekly', name: 'autorisation_materiaux_stats_weekly', methods: ['GET'])]
    public function statsWeeklyMateriaux(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $startMonth = $request->query->get('startMonth');
        $endMonth = $request->query->get('endMonth');

        if (!$startMonth || !$endMonth) {
            return $this->json(['message' => 'Veuillez spécifier startMonth et endMonth (format: YYYY-MM)'], 400);
        }

        $startDate = "{$startMonth}-01";
        $endDate = (new \DateTime("{$endMonth}-01"))->modify('last day of this month')->format('Y-m-d');
        $conn = $em->getConnection();

        try {
            $sql = "
            SELECT
                DAYNAME(created_at) AS jour,
                COUNT(id) AS total
            FROM autorisation_circulation_construction
            WHERE created_at BETWEEN :start AND :end
            GROUP BY jour
            ORDER BY FIELD(jour, 'Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday')
        ";
            $results = $conn->fetchAllAssociative($sql, ['start' => $startDate, 'end' => $endDate]);
        } catch (\Throwable $e) {
            return $this->json(['message' => 'Erreur SQL : '.$e->getMessage()], 500);
        }

        $joursFr = [
            'Monday' => 'Lundi', 'Tuesday' => 'Mardi', 'Wednesday' => 'Mercredi',
            'Thursday' => 'Jeudi', 'Friday' => 'Vendredi', 'Saturday' => 'Samedi', 'Sunday' => 'Dimanche'
        ];
        foreach ($results as &$r) {
            $r['jour'] = $joursFr[$r['jour']] ?? $r['jour'];
        }

        return $this->json($results);
    }


}

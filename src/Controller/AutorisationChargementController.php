<?php

namespace App\Controller;

use App\Entity\SurveillanceTechnique;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use OpenApi\Attributes as OA;
use Symfony\Component\Routing\Attribute\Route;
use Throwable;

final class AutorisationChargementController extends AbstractController
{
    #[OA\Get(
        path: "/api/autorisation-chargement/stats/weekly",
        summary: "Statistiques hebdomadaires : activité journalière entre deux mois donnés",
        tags: ["Autorisation Marchandises"],
        parameters: [
            new OA\Parameter(name: "startMonth", in: "query", required: true, schema: new OA\Schema(type: "string"), example: "2025-08"),
            new OA\Parameter(name: "endMonth", in: "query", required: true, schema: new OA\Schema(type: "string"), example: "2025-10")
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Nombre d’autorisations générées par jour de la semaine",
                content: new OA\JsonContent(
                    type: "array",
                    items: new OA\Items(type: "object", properties: [
                        new OA\Property(property: "jour", type: "string", example: "Lundi"),
                        new OA\Property(property: "total", type: "integer", example: 12)
                    ])
                )
            )
        ]
    )]
    #[Route('/api/autorisation-chargement/stats/weekly', name: 'autorisation_chargement_stats_weekly', methods: ['GET'])]
    public function statsWeeklyChargement(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $startMonth = $request->query->get('startMonth');
        $endMonth = $request->query->get('endMonth');

        if (!$startMonth || !$endMonth) {
            return $this->json(['message' => 'Veuillez spécifier startMonth et endMonth (format: YYYY-MM)'], 400);
        }

        $startDate = "$startMonth-01";
        $endDate = (new DateTime("$endMonth-01"))->modify('last day of this month')->format('Y-m-d');

        $conn = $em->getConnection();

        $sql = "
        SELECT
            DAYNAME(created_at) AS jour,
            COUNT(id) AS total
        FROM surveillance_technique
        WHERE created_at BETWEEN :start AND :end
        GROUP BY jour
        ORDER BY FIELD(jour, 'Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday')
    ";

        try {
            $results = $conn->fetchAllAssociative($sql, [
                'start' => $startDate,
                'end' => $endDate
            ]);
        } catch (Throwable $e) {
            return $this->json(['message' => 'Erreur SQL : ' . $e->getMessage()], 500);
        }

        $joursFr = [
            'Monday' => 'Lundi',
            'Tuesday' => 'Mardi',
            'Wednesday' => 'Mercredi',
            'Thursday' => 'Jeudi',
            'Friday' => 'Vendredi',
            'Saturday' => 'Samedi',
            'Sunday' => 'Dimanche'
        ];

        foreach ($results as &$r) {
            $r['jour'] = $joursFr[$r['jour']] ?? $r['jour'];
        }

        return $this->json($results);
    }

    #[OA\Get(
        path: "/api/autorisation-chargement/list",
        summary: "Lister toutes les autorisations de chargement par ordre d’arrivée",
        description: "Retourne la liste paginée de toutes les autorisations de transport de marchandises enregistrées, triées du plus récent au plus ancien.",
        tags: ["Autorisation Marchandises"],
        parameters: [
            new OA\Parameter(name: "page", in: "query", required: false, schema: new OA\Schema(type: "integer"), example: 1, description: "Numéro de la page à afficher"),
            new OA\Parameter(name: "limit", in: "query", required: false, schema: new OA\Schema(type: "integer"), example: 10, description: "Nombre d’éléments par page")
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Liste paginée des autorisations de chargement enregistrées",
                content: new OA\JsonContent(
                    type: "object",
                    properties: [
                        new OA\Property(property: "page", type: "integer", example: 1),
                        new OA\Property(property: "limit", type: "integer", example: 10),
                        new OA\Property(property: "total", type: "integer", example: 152),
                        new OA\Property(
                            property: "data",
                            type: "array",
                            items: new OA\Items(
                                type: "object",
                                properties: [
                                    new OA\Property(property: "id", type: "integer", example: 12),
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
                                    new OA\Property(property: "lieuEmission", type: "string", example: "Direction Provinciale du Katanga"),
                                    new OA\Property(property: "pointDeDepart", type: "string", example: "Carrière de Mont-Ngafula"),
                                    new OA\Property(property: "pointArrive", type: "string", example: "Université de Kinshasa"),
                                    new OA\Property(property: "heureDeDepart", type: "string", example: "06:30:00"),
                                    new OA\Property(property: "heureArrivee", type: "string", example: "09:45:00"),
                                    new OA\Property(property: "createdAt", type: "string", format: "date-time", example: "2025-10-27T08:45:12Z")
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
                        new OA\Property(property: "message", type: "string", example: "Erreur SQL : Table inconnue")
                    ]
                )
            )
        ]
    )]
    #[Route('/api/autorisation-chargement/list', name: 'autorisation_chargement_list', methods: ['GET'])]
    public function listAutorisationChargement(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $page = max(1, (int) $request->query->get('page', 1));
        $limit = max(1, (int) $request->query->get('limit', 10));
        $offset = ($page - 1) * $limit;

        try {
            $repo = $em->getRepository(SurveillanceTechnique::class);

            // 🔹 Récupération paginée
            $surveillances = $repo->createQueryBuilder('s')
                ->orderBy('s.createdAt', 'DESC')
                ->setFirstResult($offset)
                ->setMaxResults($limit)
                ->getQuery()
                ->getResult();

            // 🔹 Total global
            $total = (int) $repo->createQueryBuilder('s')
                ->select('COUNT(s.id)')
                ->getQuery()
                ->getSingleScalarResult();

            // 🔹 Conversion manuelle des entités en tableau
            $data = [];
            foreach ($surveillances as $s) {
                $data[] = [
                    'id' => $s->getId(),
                    'nom' => $s->getNom(),
                    'nationalite' => $s->getNationnalite(),
                    'organisation' => $s->getOrganisation(),
                    'adresse' => $s->getAdresse(),
                    'telephone' => $s->getTelephone(),
                    'typeDeCharge' => $s->getTypeDeCharge(),
                    'immatriculation' => $s->getImmatriculation(),
                    'tonnage' => $s->getTonnage(),
                    'couverture' => $s->getCouverture(),
                    'signalisation' => $s->getSignalisation(),
                    'inspecteurRoutier' => $s->getInspecteurRoutier(),
                    'pointDeDepart' => $s->getPointDeDepart(),
                    'pointArrive' => $s->getPointArrive(),
                    'heureDeDepart' => $s->getHeureDeDepart(),
                    'heureArrivee' => $s->getHeureArrivee(),
                    'createdAt' => $s->getCreatedAt()?->format('Y-m-d H:i:s'),
                ];
            }
        } catch (Throwable $e) {
            return $this->json(['message' => 'Erreur : ' . $e->getMessage()], 500);
        }

        return $this->json([
            'page' => $page,
            'limit' => $limit,
            'total' => $total,
            'data' => $data
        ]);
    }

    #[OA\Get(
        path: "/api/autorisation-chargement/total",
        summary: "Obtenir le nombre total des autorisations de chargement enregistrées",
        description: "Retourne le nombre total de fichiers enregistrés dans la table des autorisations de transport de marchandises.",
        tags: ["Autorisation Marchandises"],
        responses: [
            new OA\Response(
                response: 200,
                description: "Total global des autorisations enregistrées",
                content: new OA\JsonContent(
                    type: "object",
                    properties: [
                        new OA\Property(property: "total", type: "integer", example: 245)
                    ]
                )
            ),
            new OA\Response(
                response: 500,
                description: "Erreur interne lors de la récupération du total",
                content: new OA\JsonContent(
                    type: "object",
                    properties: [
                        new OA\Property(property: "message", type: "string", example: "Erreur SQL : Table inconnue")
                    ]
                )
            )
        ]
    )]
    #[Route('/api/autorisation-chargement/total', name: 'autorisation_chargement_total', methods: ['GET'])]
    public function totalAutorisationChargement(EntityManagerInterface $em): JsonResponse
    {
        $conn = $em->getConnection();

        try {

            $total = (int) $conn->fetchOne("SELECT COUNT(id) FROM surveillance_technique");
        } catch (Throwable $e) {
            return $this->json([
                'message' => 'Erreur SQL : ' . $e->getMessage()
            ], 500);
        }

        return $this->json(['total' => $total]);
    }
    #[OA\Get(
        path: "/api/autorisation-chargement/stats/monthly",
        summary: "Statistiques mensuelles : nombre d’autorisations de chargement par mois",
        tags: ["Autorisation Marchandises"],
        responses: [
            new OA\Response(
                response: 200,
                description: "Nombre total de fichiers générés par mois",
                content: new OA\JsonContent(
                    type: "array",
                    items: new OA\Items(type: "object", properties: [
                        new OA\Property(property: "mois", type: "string", example: "2025-09"),
                        new OA\Property(property: "total", type: "integer", example: 25)
                    ])
                )
            )
        ]
    )]
    #[Route('/api/autorisation-chargement/stats/monthly', name: 'autorisation_chargement_stats_monthly', methods: ['GET'])]
    public function statsMonthlyChargement(EntityManagerInterface $em): JsonResponse
    {
        $conn = $em->getConnection();

        $sql = "
        SELECT
            DATE_FORMAT(created_at, '%Y-%m') AS mois,
            COUNT(id) AS total
        FROM surveillance_technique
        GROUP BY mois
        ORDER BY mois ASC
    ";

        try {
            $results = $conn->fetchAllAssociative($sql);
        } catch (Throwable $e) {
            return $this->json(['message' => 'Erreur SQL : ' . $e->getMessage()], 500);
        }

        return $this->json($results);
    }
}

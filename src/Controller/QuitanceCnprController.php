<?php

namespace App\Controller;

use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use OpenApi\Attributes as OA;
use Throwable;

final class QuitanceCnprController extends AbstractController
{
    #[OA\Get(
        path: "/api/quittance-cnpr/list",
        summary: "Lister toutes les quittances CNPR enregistrées",
        description: "Retourne la liste paginée des quittances CNPR, triées du plus récent au plus ancien.",
        tags: ["CNPR - Quittances"],
        parameters: [
            new OA\Parameter(name: "page", in: "query", schema: new OA\Schema(type: "integer"), example: 1),
            new OA\Parameter(name: "limit", in: "query", schema: new OA\Schema(type: "integer"), example: 10)
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Liste paginée des quittances CNPR",
                content: new OA\JsonContent(
                    type: "object",
                    properties: [
                        new OA\Property(property: "page", type: "integer", example: 1),
                        new OA\Property(property: "limit", type: "integer", example: 10),
                        new OA\Property(property: "total", type: "integer", example: 134),
                        new OA\Property(
                            property: "data",
                            type: "array",
                            items: new OA\Items(type: "object", properties: [
                                new OA\Property(property: "id", type: "integer", example: 12),
                                new OA\Property(property: "assujetti", type: "string", example: "Société des Transports du Katanga"),
                                new OA\Property(property: "numeroDeTaxation", type: "string", example: "TX-2025-0458"),
                                new OA\Property(property: "modeEncaisseEnChiffres", type: "string", example: "250000.00"),
                                new OA\Property(property: "ModeEncaisseEnLettres", type: "string", example: "Deux cent cinquante mille francs congolais"),
                                new OA\Property(property: "banqueBeneficiaire", type: "string", example: "RAWBANK SA"),
                                new OA\Property(property: "numeroDeCompte", type: "string", example: "00011002233445566"),
                                new OA\Property(property: "modeDePaiement", type: "string", example: "Virement bancaire"),
                                new OA\Property(property: "natureDeLimpositionPayee", type: "string", example: "Taxe sur le transport routier"),
                                new OA\Property(property: "createdAt", type: "string", format: "date-time", example: "2025-10-28T10:15:00Z")
                            ])
                        )
                    ]
                )
            )
        ]
    )]
    #[Route('/api/quittance-cnpr/list', name: 'quittance_cnpr_list', methods: ['GET'])]
    public function listQuittances(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $conn = $em->getConnection();
        $page = max(1, (int)$request->query->get('page', 1));
        $limit = max(1, (int)$request->query->get('limit', 10));
        $offset = ($page - 1) * $limit;

        try {
            $sql = "
            SELECT
                id, assujetti, numero_de_taxation AS numeroDeTaxation,
                mode_encaisse_en_chiffres AS modeEncaisseEnChiffres,
                mode_encaisse_en_lettres AS ModeEncaisseEnLettres,
                banque_beneficiaire AS banqueBeneficiaire,
                numero_de_compte AS numeroDeCompte,
                mode_de_paiement AS modeDePaiement,
                nature_de_limposition_payee AS natureDeLimpositionPayee,
                created_at AS createdAt
            FROM quittance_cnpr
            ORDER BY created_at DESC
            LIMIT :limit OFFSET :offset
        ";

            $data = $conn->fetchAllAssociative($sql, ['limit' => $limit, 'offset' => $offset]);
            $total = (int)$conn->fetchOne("SELECT COUNT(id) FROM quittance_cnpr");
        } catch (Throwable $e) {
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
        path: "/api/quittance-cnpr/total",
        summary: "Obtenir le nombre total des quittances CNPR",
        tags: ["CNPR - Quittances"],
        responses: [
            new OA\Response(
                response: 200,
                description: "Nombre total des quittances enregistrées",
                content: new OA\JsonContent(properties: [
                    new OA\Property(property: "total", type: "integer", example: 134)
                ])
            )
        ]
    )]
    #[Route('/api/quittance-cnpr/total', name: 'quittance_cnpr_total', methods: ['GET'])]
    public function totalQuittances(EntityManagerInterface $em): JsonResponse
    {
        try {
            $total = (int)$em->getConnection()->fetchOne("SELECT COUNT(id) FROM quittance_cnpr");
            return $this->json(['total' => $total]);
        } catch (Throwable $e) {
            return $this->json(['message' => 'Erreur SQL : '.$e->getMessage()], 500);
        }
    }
    #[OA\Get(
        path: "/api/quittance-cnpr/stats/monthly",
        summary: "Statistiques mensuelles des quittances CNPR",
        tags: ["CNPR - Quittances"],
        responses: [
            new OA\Response(
                response: 200,
                description: "Nombre de quittances par mois",
                content: new OA\JsonContent(type: "array", items: new OA\Items(properties: [
                    new OA\Property(property: "mois", type: "string", example: "2025-10"),
                    new OA\Property(property: "total", type: "integer", example: 12)
                ]))
            )
        ]
    )]
    #[Route('/api/quittance-cnpr/stats/monthly', name: 'quittance_cnpr_stats_monthly', methods: ['GET'])]
    public function statsMonthlyQuittances(EntityManagerInterface $em): JsonResponse
    {
        try {
            $results = $em->getConnection()->fetchAllAssociative("
            SELECT
                DATE_FORMAT(created_at, '%Y-%m') AS mois,
                COUNT(id) AS total
            FROM quittance_cnpr
            GROUP BY mois
            ORDER BY mois ASC
        ");
            return $this->json($results);
        } catch (Throwable $e) {
            return $this->json(['message' => 'Erreur SQL : '.$e->getMessage()], 500);
        }
    }
    #[OA\Get(
        path: "/api/quittance-cnpr/stats/weekly",
        summary: "Statistiques journalières entre deux mois",
        tags: ["CNPR - Quittances"],
        parameters: [
            new OA\Parameter(name: "startMonth", in: "query", required: true, schema: new OA\Schema(type: "string"), example: "2025-08"),
            new OA\Parameter(name: "endMonth", in: "query", required: true, schema: new OA\Schema(type: "string"), example: "2025-10")
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Nombre de quittances par jour",
                content: new OA\JsonContent(type: "array", items: new OA\Items(properties: [
                    new OA\Property(property: "jour", type: "string", example: "Lundi"),
                    new OA\Property(property: "total", type: "integer", example: 6)
                ]))
            )
        ]
    )]
    #[Route('/api/quittance-cnpr/stats/weekly', name: 'quittance_cnpr_stats_weekly', methods: ['GET'])]
    public function statsWeeklyQuittances(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $startMonth = $request->query->get('startMonth');
        $endMonth = $request->query->get('endMonth');

        if (!$startMonth || !$endMonth) {
            return $this->json(['message' => 'Veuillez spécifier startMonth et endMonth (format: YYYY-MM)'], 400);
        }

        $startDate = "$startMonth-01";
        $endDate = (new DateTime("$endMonth-01"))->modify('last day of this month')->format('Y-m-d');

        try {
            $results = $em->getConnection()->fetchAllAssociative("
            SELECT
                DAYNAME(created_at) AS jour,
                COUNT(id) AS total
            FROM quittance_cnpr
            WHERE created_at BETWEEN :start AND :end
            GROUP BY jour
            ORDER BY FIELD(jour, 'Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday')
        ", ['start' => $startDate, 'end' => $endDate]);

            $joursFr = [
                'Monday' => 'Lundi', 'Tuesday' => 'Mardi', 'Wednesday' => 'Mercredi',
                'Thursday' => 'Jeudi', 'Friday' => 'Vendredi', 'Saturday' => 'Samedi', 'Sunday' => 'Dimanche'
            ];
            foreach ($results as &$r) {
                $r['jour'] = $joursFr[$r['jour']] ?? $r['jour'];
            }

            return $this->json($results);
        } catch (Throwable $e) {
            return $this->json(['message' => 'Erreur SQL : '.$e->getMessage()], 500);
        }
    }

}

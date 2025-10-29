<?php

namespace App\Controller;

use App\Entity\SurveillanceEmbarquementMoto;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use OpenApi\Attributes as OA;
use Throwable;

final class EmbarquementMotoController extends AbstractController
{
    #[OA\Get(
        path: "/api/embarquement-moto/list",
        summary: "Lister toutes les fiches de surveillance d’embarquement de moto",
        description: "Retourne la liste paginée des fiches de surveillance de moto enregistrées, triées du plus récent au plus ancien.",
        tags: ["Surveillance Embarquement Moto"],
        parameters: [
            new OA\Parameter(name: "page", in: "query", schema: new OA\Schema(type: "integer"), example: 1),
            new OA\Parameter(name: "limit", in: "query", schema: new OA\Schema(type: "integer"), example: 10)
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Liste paginée des fiches de surveillance moto",
                content: new OA\JsonContent(
                    type: "object",
                    properties: [
                        new OA\Property(property: "page", type: "integer", example: 1),
                        new OA\Property(property: "limit", type: "integer", example: 10),
                        new OA\Property(property: "total", type: "integer", example: 56),
                        new OA\Property(
                            property: "data",
                            type: "array",
                            items: new OA\Items(type: "object", properties: [
                                new OA\Property(property: "id", type: "integer", example: 15),
                                new OA\Property(property: "nom", type: "string", example: "Mbuyi Jean-Paul"),
                                new OA\Property(property: "corporation", type: "string", example: "Moto-Taxi Matadi"),
                                new OA\Property(property: "tel", type: "string", example: "+243810123456"),
                                new OA\Property(property: "immatriculation", type: "string", example: "CGO-MOTO-1234"),
                                new OA\Property(property: "marque", type: "string", example: "TVS Star HLX 125"),
                                new OA\Property(property: "inspecteursRoutiers", type: "array", items: new OA\Items(type: "string")),
                                new OA\Property(property: "createdAt", type: "string", format: "date-time", example: "2025-10-28T12:30:00Z")
                            ])
                        )
                    ]
                )
            )
        ]
    )]
    #[Route('/api/embarquement-moto/list', name: 'surveillance_embarquement_moto_list', methods: ['GET'])]
    public function listEmbarquementMoto(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $page = max(1, (int) $request->query->get('page', 1));
        $limit = max(1, (int) $request->query->get('limit', 10));
        $offset = ($page - 1) * $limit;

        try {
            $repo = $em->getRepository(SurveillanceEmbarquementMoto::class);

            // 🔹 Récupération paginée via Doctrine
            $entries = $repo->createQueryBuilder('s')
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

            // 🔹 Conversion manuelle des entités en tableaux
            $data = [];
            foreach ($entries as $s) {
                $data[] = [
                    'id' => $s->getId(),
                    'nom' => $s->getNom(),
                    'corporation' => $s->getCorporation(),
                    'tel' => $s->getTel(),
                    'immatriculation' => $s->getImmatriculation(),
                    'marque' => $s->getMarque(),
                    'inspecteursRoutiers' => $s->getInspecteursRoutiers(),
                    'createdAt' => $s->getCreatedAt()?->format('Y-m-d H:i:s'),
                ];
            }

        } catch (Throwable $e) {
            return $this->json(['message' => 'Erreur : '.$e->getMessage()], 500);
        }

        return $this->json([
            'page' => $page,
            'limit' => $limit,
            'total' => $total,
            'data' => $data,
        ]);
    }
    #[OA\Get(
        path: "/api/embarquement-moto/total",
        summary: "Obtenir le nombre total des fiches de surveillance d’embarquement de moto",
        tags: ["Surveillance Embarquement Moto"],
        responses: [
            new OA\Response(
                response: 200,
                description: "Total global des fiches enregistrées",
                content: new OA\JsonContent(properties: [
                    new OA\Property(property: "total", type: "integer", example: 56)
                ])
            )
        ]
    )]
    #[Route('/api/embarquement-moto/total', name: 'surveillance_embarquement_moto_total', methods: ['GET'])]
    public function totalEmbarquementMoto(EntityManagerInterface $em): JsonResponse
    {
        try {
            $total = (int)$em->getConnection()->fetchOne("SELECT COUNT(id) FROM surveillance_embarquement_moto");
            return $this->json(['total' => $total]);
        } catch (Throwable $e) {
            return $this->json(['message' => 'Erreur SQL : '.$e->getMessage()], 500);
        }
    }
    #[OA\Get(
        path: "/api/embarquement-moto/stats/monthly",
        summary: "Statistiques mensuelles des fiches d’embarquement de moto",
        tags: ["Surveillance Embarquement Moto"],
        responses: [
            new OA\Response(
                response: 200,
                description: "Nombre de fiches enregistrées par mois",
                content: new OA\JsonContent(type: "array", items: new OA\Items(properties: [
                    new OA\Property(property: "mois", type: "string", example: "2025-10"),
                    new OA\Property(property: "total", type: "integer", example: 18)
                ]))
            )
        ]
    )]
    #[Route('/api/embarquement-moto/stats/monthly', name: 'surveillance_embarquement_moto_stats_monthly', methods: ['GET'])]
    public function statsMonthlyEmbarquementMoto(EntityManagerInterface $em): JsonResponse
    {
        try {
            $results = $em->getConnection()->fetchAllAssociative("
            SELECT DATE_FORMAT(created_at, '%Y-%m') AS mois, COUNT(id) AS total
            FROM surveillance_embarquement_moto
            GROUP BY mois
            ORDER BY mois ASC
        ");
            return $this->json($results);
        } catch (Throwable $e) {
            return $this->json(['message' => 'Erreur SQL : '.$e->getMessage()], 500);
        }
    }
    #[OA\Get(
        path: "/api/embarquement-moto/stats/weekly",
        summary: "Statistiques hebdomadaires (activité journalière entre deux mois)",
        tags: ["Surveillance Embarquement Moto"],
        parameters: [
            new OA\Parameter(name: "startMonth", in: "query", required: true, schema: new OA\Schema(type: "string"), example: "2025-09"),
            new OA\Parameter(name: "endMonth", in: "query", required: true, schema: new OA\Schema(type: "string"), example: "2025-10")
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Nombre de fiches par jour",
                content: new OA\JsonContent(type: "array", items: new OA\Items(properties: [
                    new OA\Property(property: "jour", type: "string", example: "Lundi"),
                    new OA\Property(property: "total", type: "integer", example: 8)
                ]))
            )
        ]
    )]
    #[Route('/api/embarquement-moto/stats/weekly', name: 'surveillance_embarquement_moto_stats_weekly', methods: ['GET'])]
    public function statsWeeklyEmbarquementMoto(Request $request, EntityManagerInterface $em): JsonResponse
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
            FROM surveillance_embarquement_moto
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

<?php

namespace App\Controller;

use App\Entity\InspectionConvoiExceTechnique;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use OpenApi\Attributes as OA;
use Throwable;

final class InspectionConvoiTechniqueController extends AbstractController
{
    #[OA\Get(
        path: "/api/inspection-convoi-technique/list",
        summary: "Lister toutes les inspections de convoi exceptionnel enregistrées",
        description: "Retourne la liste paginée de toutes les inspections techniques de convoi exceptionnel, triées par ordre d’arrivée.",
        tags: ["Inspection Convoi Exceptionnel"],
        parameters: [
            new OA\Parameter(name: "page", in: "query", schema: new OA\Schema(type: "integer"), example: 1),
            new OA\Parameter(name: "limit", in: "query", schema: new OA\Schema(type: "integer"), example: 10)
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Liste paginée des inspections enregistrées",
                content: new OA\JsonContent(
                    type: "object",
                    properties: [
                        new OA\Property(property: "page", type: "integer", example: 1),
                        new OA\Property(property: "limit", type: "integer", example: 10),
                        new OA\Property(property: "total", type: "integer", example: 120),
                        new OA\Property(
                            property: "data",
                            type: "array",
                            items: new OA\Items(type: "object", properties: [
                                new OA\Property(property: "id", type: "integer", example: 5),
                                new OA\Property(property: "requerant", type: "string", example: "Société Générale des Travaux"),
                                new OA\Property(property: "nationalite", type: "string", example: "Congolaise"),
                                new OA\Property(property: "typeDePersonne", type: "string", example: "Entreprise"),
                                new OA\Property(property: "telephone", type: "string", example: "+243810123456"),
                                new OA\Property(property: "typeDeVihicule", type: "string", example: "Tracteur + remorque"),
                                new OA\Property(property: "typeDeCharge", type: "string", example: "Turbine hydroélectrique"),
                                new OA\Property(property: "pointDeDepart", type: "string", example: "Port de Matadi"),
                                new OA\Property(property: "pointArrive", type: "string", example: "Barrage d’Inga"),
                                new OA\Property(property: "categorie", type: "string", example: "Convoi exceptionnel lourd"),
                                new OA\Property(property: "longueur", type: "string", example: "32.5"),
                                new OA\Property(property: "largueur", type: "string", example: "4.8"),
                                new OA\Property(property: "hauteur", type: "string", example: "5.2"),
                                new OA\Property(property: "arrimage", type: "string", example: "OK"),
                                new OA\Property(property: "signalisation", type: "string", example: "Conforme"),
                                new OA\Property(property: "centrage", type: "string", example: "Bon équilibrage"),
                                new OA\Property(property: "createdAt", type: "string", format: "date-time", example: "2025-10-28T09:00:00Z")
                            ])
                        )
                    ]
                )
            )
        ]
    )]
    #[Route('/api/inspection-convoi-technique/list', name: 'inspection_convoi_list', methods: ['GET'])]
    public function listInspectionConvoi(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $page = max(1, (int) $request->query->get('page', 1));
        $limit = max(1, (int) $request->query->get('limit', 10));
        $offset = ($page - 1) * $limit;

        try {
            $repo = $em->getRepository(InspectionConvoiExceTechnique::class);

            // 🔹 Récupération paginée via Doctrine
            $inspections = $repo->createQueryBuilder('i')
                ->orderBy('i.createdAt', 'DESC')
                ->setFirstResult($offset)
                ->setMaxResults($limit)
                ->getQuery()
                ->getResult();

            // 🔹 Total global
            $total = (int) $repo->createQueryBuilder('i')
                ->select('COUNT(i.id)')
                ->getQuery()
                ->getSingleScalarResult();

            // 🔹 Conversion manuelle des entités en tableau
            $data = [];
            foreach ($inspections as $i) {
                $data[] = [
                    'id' => $i->getId(),
                    'requerant' => $i->getRequerant(),
                    'nationalite' => $i->getNationalite(),
                    'typeDePersonne' => $i->getTypeDePersonne(),
                    'coordonnee' => $i->getCoordonnee(),
                    'telephone' => $i->getTelephone(),
                    'immatriculation' => $i->getImmatriculation(),
                    'marque' => $i->getMarque(),
                    'typeDeVihicule' => $i->getTypeDeVihicule(),
                    'typeDeCharge' => $i->getTypeDeCharge(),
                    'pointDeDepart' => $i->getPointDeDepart(),
                    'pointArrive' => $i->getPointArrive(),
                    'heureDeDepart' => $i->getHeureDeDepart(),
                    'heureArrivee' => $i->getHeureArrivee(),
                    'categorie' => $i->getCategorie(),
                    'longueur' => $i->getLongueur(),
                    'largueur' => $i->getLargueur(),
                    'hauteur' => $i->getHauteur(),
                    'arrimage' => $i->getArrimage(),
                    'signalisation' => $i->getSignalisation(),
                    'centrage' => $i->getCentrage(),
                    'observations' => $i->getObservations(),
                    'contact' => $i->getContact(),
                    'createdAt' => $i->getCreatedAt()?->format('Y-m-d H:i:s'),
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
        path: "/api/inspection-convoi-technique/total",
        summary: "Obtenir le nombre total des inspections de convoi exceptionnel enregistrées",
        tags: ["Inspection Convoi Exceptionnel"],
        responses: [
            new OA\Response(
                response: 200,
                description: "Total global des inspections",
                content: new OA\JsonContent(properties: [
                    new OA\Property(property: "total", type: "integer", example: 245)
                ])
            )
        ]
    )]
    #[Route('/api/inspection-convoi-technique/total', name: 'inspection_convoi_total', methods: ['GET'])]
    public function totalInspectionConvoi(EntityManagerInterface $em): JsonResponse
    {
        try {
            $total = (int)$em->getConnection()->fetchOne("SELECT COUNT(id) FROM inspection_convoi_exce_technique");
            return $this->json(['total' => $total]);
        } catch (Throwable $e) {
            return $this->json(['message' => 'Erreur SQL : '.$e->getMessage()], 500);
        }
    }
    #[OA\Get(
        path: "/api/inspection-convoi-technique/stats/monthly",
        summary: "Statistiques mensuelles des inspections de convoi exceptionnel",
        tags: ["Inspection Convoi Exceptionnel"],
        responses: [
            new OA\Response(
                response: 200,
                description: "Nombre d’inspections par mois",
                content: new OA\JsonContent(type: "array", items: new OA\Items(properties: [
                    new OA\Property(property: "mois", type: "string", example: "2025-10"),
                    new OA\Property(property: "total", type: "integer", example: 12)
                ]))
            )
        ]
    )]
    #[Route('/api/inspection-convoi-technique/stats/monthly', name: 'inspection_convoi_stats_monthly', methods: ['GET'])]
    public function statsMonthlyInspectionConvoi(EntityManagerInterface $em): JsonResponse
    {
        try {
            $results = $em->getConnection()->fetchAllAssociative("
            SELECT
                DATE_FORMAT(created_at, '%Y-%m') AS mois,
                COUNT(id) AS total
            FROM inspection_convoi_exce_technique
            GROUP BY mois
            ORDER BY mois ASC
        ");
            return $this->json($results);
        } catch (Throwable $e) {
            return $this->json(['message' => 'Erreur SQL : '.$e->getMessage()], 500);
        }
    }
    #[OA\Get(
        path: "/api/inspection-convoi-technique/stats/weekly",
        summary: "Statistiques journalières des inspections entre deux mois",
        tags: ["Inspection Convoi Exceptionnel"],
        parameters: [
            new OA\Parameter(name: "startMonth", in: "query", required: true, schema: new OA\Schema(type: "string"), example: "2025-09"),
            new OA\Parameter(name: "endMonth", in: "query", required: true, schema: new OA\Schema(type: "string"), example: "2025-10")
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Nombre d’inspections par jour",
                content: new OA\JsonContent(type: "array", items: new OA\Items(properties: [
                    new OA\Property(property: "jour", type: "string", example: "Lundi"),
                    new OA\Property(property: "total", type: "integer", example: 4)
                ]))
            )
        ]
    )]
    #[Route('/api/inspection-convoi-technique/stats/weekly', name: 'inspection_convoi_stats_weekly', methods: ['GET'])]
    public function statsWeeklyInspectionConvoi(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $startMonth = $request->query->get('startMonth');
        $endMonth = $request->query->get('endMonth');

        if (!$startMonth || !$endMonth) {
            return $this->json(['message' => 'Veuillez spécifier startMonth et endMonth (format YYYY-MM)'], 400);
        }

        $startDate = "$startMonth-01";
        $endDate = (new DateTime("$endMonth-01"))->modify('last day of this month')->format('Y-m-d');

        try {
            $results = $em->getConnection()->fetchAllAssociative("
            SELECT
                DAYNAME(created_at) AS jour,
                COUNT(id) AS total
            FROM inspection_convoi_exce_technique
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

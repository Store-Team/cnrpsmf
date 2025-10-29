<?php

namespace App\Controller;

use App\Entity\AutaurisationConvoiExceptionnel;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class AutorisationConvoiController extends AbstractController
{
    #[OA\Get(
        path: "/api/autorisation-convoi/total",
        summary: "Obtenir le nombre total de fichiers générés Statistiques Autorisation Convoi ",
        tags: ["Autorisation Convoi"],
        responses: [
            new OA\Response(
                response: 200,
                description: "Nombre total de fichiers enregistrés",
                content: new OA\JsonContent(
                    type: "object",
                    properties: [
                        new OA\Property(property: "total", type: "integer", example: 254)
                    ]
                )
            )
        ]
    )]
    #[Route('/api/autorisation-convoi/total', name: 'autorisation_convoi_count', methods: ['GET'])]
    public function countFiles(EntityManagerInterface $em): JsonResponse
    {
        $total = $em->getRepository(AutaurisationConvoiExceptionnel::class)
            ->createQueryBuilder('a')
            ->select('COUNT(a.id)')
            ->getQuery()
            ->getSingleScalarResult();

        return $this->json(['total' => (int)$total]);
    }
    #[OA\Get(
        path: "/api/autorisation-convoi/list",
        summary: "Lister toutes les autorisations de convoi par ordre d’arrivée (avec pagination)",
        tags: ["Autorisation Convoi"],
        parameters: [
            new OA\Parameter(name: "page", in: "query", required: false, schema: new OA\Schema(type: "integer"), example: 1),
            new OA\Parameter(name: "limit", in: "query", required: false, schema: new OA\Schema(type: "integer"), example: 10)
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Liste paginée complète des autorisations enregistrées",
                content: new OA\JsonContent(
                    type: "object",
                    properties: [
                        new OA\Property(property: "page", type: "integer", example: 1),
                        new OA\Property(property: "limit", type: "integer", example: 10),
                        new OA\Property(property: "total", type: "integer", example: 120),
                        new OA\Property(
                            property: "data",
                            type: "array",
                            items: new OA\Items(
                                type: "object",
                                properties: [
                                    new OA\Property(property: "id", type: "integer", example: 1),
                                    new OA\Property(property: "requerant", type: "string", example: "Société BTP Congo"),
                                    new OA\Property(property: "nationalite", type: "string", example: "Congolaise"),
                                    new OA\Property(property: "typeDePersonne", type: "string", example: "Entreprise"),
                                    new OA\Property(property: "coordonnee", type: "string", example: "Zone industrielle de Limete"),
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
                                    new OA\Property(property: "centrage", type: "string", example: "Bon équilibrage"),
                                    new OA\Property(property: "createdAt", type: "string", format: "date-time", example: "2025-10-27T12:05:00Z")
                                ]
                            )
                        )
                    ]
                )
            )
        ]
    )]
    #[Route('/api/autorisation-convoi/list', name: 'autorisation_convoi_list', methods: ['GET'])]
    public function listFiles(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $page = max(1, (int)$request->query->get('page', 1));
        $limit = max(1, (int)$request->query->get('limit', 10));
        $offset = ($page - 1) * $limit;

        $repo = $em->getRepository(AutaurisationConvoiExceptionnel::class);

        $qb = $repo->createQueryBuilder('a')
            ->orderBy('a.createdAt', 'DESC')
            ->setFirstResult($offset)
            ->setMaxResults($limit);

        $items = $qb->getQuery()->getResult();

        $total = $repo->createQueryBuilder('a')
            ->select('COUNT(a.id)')
            ->getQuery()
            ->getSingleScalarResult();

        // 🔹 Convertir toutes les propriétés de l'entité en tableau
        $data = array_map(function ($a) {
            return [
                'id' => $a->getId(),
                'requerant' => $a->getRequerant(),
                'nationalite' => $a->getNationalite(),
                'typeDePersonne' => $a->getTypeDePersonne(),
                'coordonnee' => $a->getCoordonnee(),
                'telephone' => $a->getTelephone(),
                'immatriculation' => $a->getImmatriculation(),
                'marque' => $a->getMarque(),
                'typeDeVihicule' => $a->getTypeDeVihicule(),
                'typeDeCharge' => $a->getTypeDeCharge(),
                'tonnage' => $a->getTonnage(),
                'categorie' => $a->getCategorie(),
                'longueur' => $a->getLongueur(),
                'largueur' => $a->getLargueur(),
                'hauteur' => $a->getHauteur(),
                'conditionDeSecurite' => $a->getConditionDeSecurite(),
                'heureDeCirculation' => $a->getHeureDeCirculation(),
                'pointDeDepart' => $a->getPointDeDepart(),
                'pointArrive' => $a->getPointArrive(),
                'heureDeDepart' => $a->getHeureDeDepart(),
                'heureArrivee' => $a->getHeureArrivee(),
                'arrimage' => $a->getArrimage(),
                'signalisation' => $a->getSignalisation(),
                'centrage' => $a->getCentrage(),
                'createdAt' => $a->getCreatedAt()?->format('Y-m-d H:i:s'),
            ];
        }, $items);

        return $this->json([
            'page' => $page,
            'limit' => $limit,
            'total' => (int)$total,
            'data' => $data,
        ]);
    }
    #[OA\Get(
        path: "/api/autorisation-convoi/stats/weekly",
        summary: "Statistiques des jours les plus actifs entre deux mois donnés",
        tags: ["Autorisation Convoi"],
        parameters: [
            new OA\Parameter(name: "startMonth", in: "query", required: true, schema: new OA\Schema(type: "string"), example: "2025-08"),
            new OA\Parameter(name: "endMonth", in: "query", required: true, schema: new OA\Schema(type: "string"), example: "2025-10")
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Répartition par jour de la semaine (lundi à dimanche)",
                content: new OA\JsonContent(
                    type: "array",
                    items: new OA\Items(
                        type: "object",
                        properties: [
                            new OA\Property(property: "jour", type: "string", example: "Lundi"),
                            new OA\Property(property: "total", type: "integer", example: 15)
                        ]
                    )
                )
            )
        ]
    )]
    #[Route('/api/autorisation-convoi/stats/weekly', name: 'autorisation_convoi_stats_weekly', methods: ['GET'])]
    public function statsWeekly(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $startMonth = $request->query->get('startMonth');
        $endMonth = $request->query->get('endMonth');

        if (!$startMonth || !$endMonth) {
            return $this->json(['message' => 'Veuillez spécifier startMonth et endMonth (format: YYYY-MM)'], 400);
        }

        $startDate = "{$startMonth}-01";
        $endDate = (new \DateTime("{$endMonth}-01"))->modify('last day of this month')->format('Y-m-d');

        $conn = $em->getConnection();

        // ⚙️ Remplace "autaurisation_convoi_exceptionnel" par le vrai nom de ta table si besoin
        $sql = "
        SELECT
            DAYNAME(created_at) AS jour,
            COUNT(id) AS total
        FROM autaurisation_convoi_exceptionnel
        WHERE created_at BETWEEN :start AND :end
        GROUP BY jour
        ORDER BY FIELD(jour, 'Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday')
    ";

        try {
            $results = $conn->fetchAllAssociative($sql, [
                'start' => $startDate,
                'end' => $endDate
            ]);
        } catch (\Throwable $e) {
            return $this->json(['message' => 'Erreur SQL : '.$e->getMessage()], 500);
        }

        // ✅ Traduire en français
        $joursFr = [
            'Monday' => 'Lundi', 'Tuesday' => 'Mardi', 'Wednesday' => 'Mercredi',
            'Thursday' => 'Jeudi', 'Friday' => 'Vendredi', 'Saturday' => 'Samedi', 'Sunday' => 'Dimanche'
        ];

        foreach ($results as &$r) {
            $r['jour'] = $joursFr[$r['jour']] ?? $r['jour'];
        }

        return $this->json($results);
    }
    #[OA\Get(
        path: "/api/autorisation-convoi/stats/monthly",
        summary: "Statistiques mensuelles : nombre de fichiers générés par mois",
        tags: ["Autorisation Convoi"],
        responses: [
            new OA\Response(
                response: 200,
                description: "Nombre de fichiers générés par mois",
                content: new OA\JsonContent(
                    type: "array",
                    items: new OA\Items(
                        type: "object",
                        properties: [
                            new OA\Property(property: "mois", type: "string", example: "2025-09"),
                            new OA\Property(property: "total", type: "integer", example: 34)
                        ]
                    )
                )
            )
        ]
    )]
    #[Route('/api/autorisation-convoi/stats/monthly', name: 'autorisation_convoi_stats_monthly', methods: ['GET'])]
    public function statsMonthly(EntityManagerInterface $em): JsonResponse
    {
        $conn = $em->getConnection();

        // ⚙️ Vérifie que le nom de ta table correspond bien à celle dans ta BDD !
        $sql = "
        SELECT
            DATE_FORMAT(created_at, '%Y-%m') AS mois,
            COUNT(id) AS total
        FROM autaurisation_convoi_exceptionnel
        GROUP BY mois
        ORDER BY mois ASC
    ";

        try {
            $results = $conn->fetchAllAssociative($sql);
        } catch (\Throwable $e) {
            return $this->json(['message' => 'Erreur SQL : '.$e->getMessage()], 500);
        }

        return $this->json($results);
    }


}

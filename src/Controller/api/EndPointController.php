<?php

namespace App\Controller\api;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints as Assert;
use OpenApi\Attributes as OA;

final class EndPointController extends AbstractController
{

        #[OA\Post(
        path: "/api/autorisation-convoi",
        summary: "Créer une autorisation de convoi (sécurisée)",
        security: [["Bearer" => []]],
        responses: [
            new OA\Response(response: 201, description: "Autorisation enregistrée"),
            new OA\Response(response: 400, description: "Données invalides"),
            new OA\Response(response: 401, description: "Non authentifié"),
            new OA\Response(response: 500, description: "Erreur interne")
        ]
    )]

    #[Route('/api/autorisation-convoi', name: 'autorisation_convoi_create', methods: ['POST'])]
    public function createAutorisation(
        Request $request,
        EntityManagerInterface $em,
        ValidatorInterface $validator
    ): JsonResponse {
        // 🔒 Vérifier le type de contenu
        if ($request->getContentTypeFormat() !== 'json') {
            return $this->json(['message' => 'Content-Type doit être application/json'], 400);
        }

        // 🔹 Lecture du corps JSON
        $data = json_decode($request->getContent(), true);
        if (!is_array($data)) {
            return $this->json(['message' => 'JSON invalide'], 400);
        }

        // 🔹 Définition des contraintes de validation
        $constraints = new Assert\Collection([
            'matricule' => [new Assert\NotBlank(), new Assert\Length(max: 50)],
            'lieu_emission' => [new Assert\NotBlank(), new Assert\Length(max: 100)],
            'date_emission' => [new Assert\NotBlank(), new Assert\Date()],
            'r_type' => [new Assert\NotBlank(), new Assert\Choice(['personne', 'entreprise'])],
            'r_nationalite' => [new Assert\NotBlank()],
            'r_addresse' => [new Assert\NotBlank()],
            'r_telephone' => [new Assert\NotBlank(), new Assert\Regex('/^\+?[0-9]{8,15}$/')],
            'v_matricule' => [new Assert\NotBlank()],
            'v_marque' => [new Assert\NotBlank()],
            'v_type' => [new Assert\NotBlank(), new Assert\Choice(['camion','remorque','semi','pickup'])],
            'type_charge' => [new Assert\NotBlank(), new Assert\Choice(['alimentaire','minerais','bois','conteneur','divers'])],
            'tonnage_kg' => [new Assert\NotBlank(), new Assert\Positive()],
            'longueur' => [new Assert\NotBlank(), new Assert\Positive()],
            'hauteur' => [new Assert\NotBlank(), new Assert\Positive()],
            'r_securite' => [new Assert\Type('bool')],
            'heure_circulation' => [new Assert\NotBlank(), new Assert\Regex('/^[0-2][0-9]:[0-5][0-9]$/')],
            'p_depart' => [new Assert\NotBlank()],
            'p_arrivee' => [new Assert\NotBlank()],
            'h_depart' => [new Assert\NotBlank(), new Assert\Regex('/^[0-2][0-9]:[0-5][0-9]$/')],
            'h_arrivee' => [new Assert\NotBlank(), new Assert\Regex('/^[0-2][0-9]:[0-5][0-9]$/')],
            'arrimage' => [new Assert\Type('bool')],
            'centrage' => [new Assert\Type('bool')],
            'signalisation' => [new Assert\Type('bool')],
            'charge_technique' => [new Assert\NotBlank(), new Assert\Positive()]
        ]);

        // 🔍 Validation
        $errors = $validator->validate($data, $constraints);
        if (count($errors) > 0) {
            $violations = [];
            foreach ($errors as $e) {
                $violations[] = ['champ' => $e->getPropertyPath(), 'message' => $e->getMessage()];
            }
            return $this->json(['errors' => $violations], 400);
        }

        // 🔐 Anti-injection / nettoyage
        $clean = array_map(fn($v) => is_string($v) ? htmlspecialchars(trim($v)) : $v, $data);

        // 🔸 Vérifier doublon
        $exist = $em->getRepository(AutorisationConvoi::class)
            ->findOneBy(['matricule' => $clean['matricule'], 'dateEmission' => new \DateTimeImmutable($clean['date_emission'])]);
        if ($exist) {
            return $this->json(['message' => 'Cette autorisation existe déjà.'], 409);
        }

        // 🔹 Création de l’entité
        $entity = (new AutorisationConvoi())
            ->setMatricule($clean['matricule'])
            ->setLieuEmission($clean['lieu_emission'])
            ->setDateEmission(new \DateTimeImmutable($clean['date_emission']))
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
            ->setHauteur($clean['hauteur'])
            ->setRSecurite($clean['r_securite'])
            ->setHeureCirculation(new \DateTimeImmutable($clean['heure_circulation']))
            ->setPDepart($clean['p_depart'])
            ->setPArrivee($clean['p_arrivee'])
            ->setHDepart(new \DateTimeImmutable($clean['h_depart']))
            ->setHArrivee(new \DateTimeImmutable($clean['h_arrivee']))
            ->setArrimage($clean['arrimage'])
            ->setCentrage($clean['centrage'])
            ->setSignalisation($clean['signalisation'])
            ->setChargeTechnique($clean['charge_technique']);
        // 🔸 Persistance
        try {
            $em->persist($entity);
            $em->flush();
        } catch (\Throwable $e) {
            return $this->json(['message' => 'Erreur interne : '.$e->getMessage()], 500);
        }

        // ✅ Réponse
        return $this->json([
            'message' => 'Autorisation enregistrée avec succès.',
            'id' => $entity->getId()
        ], 201);
    }
}

<?php

namespace App\Controller;

use App\Entity\SurveillanceChargement;
use App\Form\SurveillanceChargementType;
use App\Repository\SurveillanceChargementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/surveillance/chargement')]
final class SurveillanceChargementController extends AbstractController
{
    #[Route(name: 'app_surveillance_chargement_index', methods: ['GET'])]
    public function index(SurveillanceChargementRepository $surveillanceChargementRepository): Response
    {
        return $this->render('surveillance_chargement/index.html.twig', [
            'surveillance_chargements' => $surveillanceChargementRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_surveillance_chargement_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $surveillanceChargement = new SurveillanceChargement();
        $form = $this->createForm(SurveillanceChargementType::class, $surveillanceChargement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($surveillanceChargement);
            $entityManager->flush();

            return $this->redirectToRoute('app_surveillance_chargement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('surveillance_chargement/new.html.twig', [
            'surveillance_chargement' => $surveillanceChargement,
            'form' => $form,
        ]);
    }

    #[Route('/{matricule}', name: 'app_surveillance_chargement_show', methods: ['GET'])]
    public function show(SurveillanceChargement $surveillanceChargement): Response
    {
        return $this->render('surveillance_chargement/show.html.twig', [
            'surveillance_chargement' => $surveillanceChargement,
        ]);
    }

    #[Route('/{matricule}/edit', name: 'app_surveillance_chargement_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SurveillanceChargement $surveillanceChargement, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SurveillanceChargementType::class, $surveillanceChargement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_surveillance_chargement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('surveillance_chargement/edit.html.twig', [
            'surveillance_chargement' => $surveillanceChargement,
            'form' => $form,
        ]);
    }

    #[Route('/{matricule}', name: 'app_surveillance_chargement_delete', methods: ['POST'])]
    public function delete(Request $request, SurveillanceChargement $surveillanceChargement, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$surveillanceChargement->getMatricule(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($surveillanceChargement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_surveillance_chargement_index', [], Response::HTTP_SEE_OTHER);
    }
}

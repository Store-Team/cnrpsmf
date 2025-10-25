<?php

namespace App\Controller;

use App\Entity\AutorisationMateriauxConstruction;
use App\Form\AutorisationMateriauxConstructionType;
use App\Repository\AutorisationMateriauxConstructionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/autorisation/materiaux/construction')]
final class AutorisationMateriauxConstructionController extends AbstractController
{
    #[Route(name: 'app_autorisation_materiaux_construction_index', methods: ['GET'])]
    public function index(AutorisationMateriauxConstructionRepository $autorisationMateriauxConstructionRepository): Response
    {
        return $this->render('autorisation_materiaux_construction/index.html.twig', [
            'autorisation_materiaux_constructions' => $autorisationMateriauxConstructionRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_autorisation_materiaux_construction_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $autorisationMateriauxConstruction = new AutorisationMateriauxConstruction();
        $form = $this->createForm(AutorisationMateriauxConstructionType::class, $autorisationMateriauxConstruction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($autorisationMateriauxConstruction);
            $entityManager->flush();

            return $this->redirectToRoute('app_autorisation_materiaux_construction_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('autorisation_materiaux_construction/new.html.twig', [
            'autorisation_materiaux_construction' => $autorisationMateriauxConstruction,
            'form' => $form,
        ]);
    }

    #[Route('/{matricule}', name: 'app_autorisation_materiaux_construction_show', methods: ['GET'])]
    public function show(AutorisationMateriauxConstruction $autorisationMateriauxConstruction): Response
    {
        return $this->render('autorisation_materiaux_construction/show.html.twig', [
            'autorisation_materiaux_construction' => $autorisationMateriauxConstruction,
        ]);
    }

    #[Route('/{matricule}/edit', name: 'app_autorisation_materiaux_construction_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, AutorisationMateriauxConstruction $autorisationMateriauxConstruction, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AutorisationMateriauxConstructionType::class, $autorisationMateriauxConstruction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_autorisation_materiaux_construction_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('autorisation_materiaux_construction/edit.html.twig', [
            'autorisation_materiaux_construction' => $autorisationMateriauxConstruction,
            'form' => $form,
        ]);
    }

    #[Route('/{matricule}', name: 'app_autorisation_materiaux_construction_delete', methods: ['POST'])]
    public function delete(Request $request, AutorisationMateriauxConstruction $autorisationMateriauxConstruction, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$autorisationMateriauxConstruction->getMatricule(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($autorisationMateriauxConstruction);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_autorisation_materiaux_construction_index', [], Response::HTTP_SEE_OTHER);
    }
}

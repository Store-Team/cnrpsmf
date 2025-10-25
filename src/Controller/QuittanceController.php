<?php

namespace App\Controller;

use App\Entity\Quittance;
use App\Form\QuittanceType;
use App\Repository\QuittanceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/quittance')]
final class QuittanceController extends AbstractController
{
    #[Route(name: 'app_quittance_index', methods: ['GET'])]
    public function index(QuittanceRepository $quittanceRepository): Response
    {
        return $this->render('quittance/index.html.twig', [
            'quittances' => $quittanceRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_quittance_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $quittance = new Quittance();
        $form = $this->createForm(QuittanceType::class, $quittance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($quittance);
            $entityManager->flush();

            return $this->redirectToRoute('app_quittance_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('quittance/new.html.twig', [
            'quittance' => $quittance,
            'form' => $form,
        ]);
    }

    #[Route('/{matricule}', name: 'app_quittance_show', methods: ['GET'])]
    public function show(Quittance $quittance): Response
    {
        return $this->render('quittance/show.html.twig', [
            'quittance' => $quittance,
        ]);
    }

    #[Route('/{matricule}/edit', name: 'app_quittance_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Quittance $quittance, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(QuittanceType::class, $quittance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_quittance_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('quittance/edit.html.twig', [
            'quittance' => $quittance,
            'form' => $form,
        ]);
    }

    #[Route('/{matricule}', name: 'app_quittance_delete', methods: ['POST'])]
    public function delete(Request $request, Quittance $quittance, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$quittance->getMatricule(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($quittance);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_quittance_index', [], Response::HTTP_SEE_OTHER);
    }
}

<?php

namespace App\Controller;

use App\Entity\AutorisationConvoiExceptionel;
use App\Form\AutorisationConvoiExceptionelType;
use App\Repository\AutorisationConvoiExceptionelRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/autorisation/convoiexceptionel')]
final class AutorisationConvoiExceptionelController extends AbstractController
{
    #[Route(name: 'app_autorisation_convoi_exceptionel_index', methods: ['GET'])]
    public function index(AutorisationConvoiExceptionelRepository $autorisationConvoiExceptionelRepository): Response
    {
        return $this->render('autorisation_convoi_exceptionel/index.html.twig', [
            'autorisation_convoi_exceptionels' => $autorisationConvoiExceptionelRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_autorisation_convoi_exceptionel_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $autorisationConvoiExceptionel = new AutorisationConvoiExceptionel();
        $form = $this->createForm(AutorisationConvoiExceptionelType::class, $autorisationConvoiExceptionel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($autorisationConvoiExceptionel);
            $entityManager->flush();

            return $this->redirectToRoute('app_autorisation_convoi_exceptionel_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('autorisation_convoi_exceptionel/new.html.twig', [
            'autorisation_convoi_exceptionel' => $autorisationConvoiExceptionel,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_autorisation_convoi_exceptionel_show', methods: ['GET'])]
    public function show(AutorisationConvoiExceptionel $autorisationConvoiExceptionel): Response
    {
        return $this->render('autorisation_convoi_exceptionel/show.html.twig', [
            'autorisation_convoi_exceptionel' => $autorisationConvoiExceptionel,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_autorisation_convoi_exceptionel_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, AutorisationConvoiExceptionel $autorisationConvoiExceptionel, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AutorisationConvoiExceptionelType::class, $autorisationConvoiExceptionel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_autorisation_convoi_exceptionel_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('autorisation_convoi_exceptionel/edit.html.twig', [
            'autorisation_convoi_exceptionel' => $autorisationConvoiExceptionel,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_autorisation_convoi_exceptionel_delete', methods: ['POST'])]
    public function delete(Request $request, AutorisationConvoiExceptionel $autorisationConvoiExceptionel, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$autorisationConvoiExceptionel->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($autorisationConvoiExceptionel);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_autorisation_convoi_exceptionel_index', [], Response::HTTP_SEE_OTHER);
    }
}

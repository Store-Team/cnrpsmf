<?php

namespace App\Controller;

use App\Entity\InspectionConvoi;
use App\Form\InspectionConvoiType;
use App\Repository\InspectionConvoiRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/inspection/convoi')]
final class InspectionConvoiController extends AbstractController
{
    #[Route(name: 'app_inspection_convoi_index', methods: ['GET'])]
    public function index(InspectionConvoiRepository $inspectionConvoiRepository): Response
    {
        return $this->render('inspection_convoi/index.html.twig', [
            'inspection_convois' => $inspectionConvoiRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_inspection_convoi_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $inspectionConvoi = new InspectionConvoi();
        $form = $this->createForm(InspectionConvoiType::class, $inspectionConvoi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($inspectionConvoi);
            $entityManager->flush();

            return $this->redirectToRoute('app_inspection_convoi_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('inspection_convoi/new.html.twig', [
            'inspection_convoi' => $inspectionConvoi,
            'form' => $form,
        ]);
    }

    #[Route('/{matricule}', name: 'app_inspection_convoi_show', methods: ['GET'])]
    public function show(InspectionConvoi $inspectionConvoi): Response
    {
        return $this->render('inspection_convoi/show.html.twig', [
            'inspection_convoi' => $inspectionConvoi,
        ]);
    }

    #[Route('/{matricule}/edit', name: 'app_inspection_convoi_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, InspectionConvoi $inspectionConvoi, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(InspectionConvoiType::class, $inspectionConvoi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_inspection_convoi_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('inspection_convoi/edit.html.twig', [
            'inspection_convoi' => $inspectionConvoi,
            'form' => $form,
        ]);
    }

    #[Route('/{matricule}', name: 'app_inspection_convoi_delete', methods: ['POST'])]
    public function delete(Request $request, InspectionConvoi $inspectionConvoi, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$inspectionConvoi->getMatricule(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($inspectionConvoi);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_inspection_convoi_index', [], Response::HTTP_SEE_OTHER);
    }
}

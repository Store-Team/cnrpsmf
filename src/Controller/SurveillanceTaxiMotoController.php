<?php

namespace App\Controller;

use App\Entity\SurveillanceTaxiMoto;
use App\Form\SurveillanceTaxiMotoType;
use App\Repository\SurveillanceTaxiMotoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/surveillance/taxi/moto')]
final class SurveillanceTaxiMotoController extends AbstractController
{
    #[Route(name: 'app_surveillance_taxi_moto_index', methods: ['GET'])]
    public function index(SurveillanceTaxiMotoRepository $surveillanceTaxiMotoRepository): Response
    {
        return $this->render('surveillance_taxi_moto/index.html.twig', [
            'surveillance_taxi_motos' => $surveillanceTaxiMotoRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_surveillance_taxi_moto_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $surveillanceTaxiMoto = new SurveillanceTaxiMoto();
        $form = $this->createForm(SurveillanceTaxiMotoType::class, $surveillanceTaxiMoto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($surveillanceTaxiMoto);
            $entityManager->flush();

            return $this->redirectToRoute('app_surveillance_taxi_moto_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('surveillance_taxi_moto/new.html.twig', [
            'surveillance_taxi_moto' => $surveillanceTaxiMoto,
            'form' => $form,
        ]);
    }

    #[Route('/{matricule}', name: 'app_surveillance_taxi_moto_show', methods: ['GET'])]
    public function show(SurveillanceTaxiMoto $surveillanceTaxiMoto): Response
    {
        return $this->render('surveillance_taxi_moto/show.html.twig', [
            'surveillance_taxi_moto' => $surveillanceTaxiMoto,
        ]);
    }

    #[Route('/{matricule}/edit', name: 'app_surveillance_taxi_moto_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SurveillanceTaxiMoto $surveillanceTaxiMoto, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SurveillanceTaxiMotoType::class, $surveillanceTaxiMoto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_surveillance_taxi_moto_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('surveillance_taxi_moto/edit.html.twig', [
            'surveillance_taxi_moto' => $surveillanceTaxiMoto,
            'form' => $form,
        ]);
    }

    #[Route('/{matricule}', name: 'app_surveillance_taxi_moto_delete', methods: ['POST'])]
    public function delete(Request $request, SurveillanceTaxiMoto $surveillanceTaxiMoto, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$surveillanceTaxiMoto->getMatricule(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($surveillanceTaxiMoto);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_surveillance_taxi_moto_index', [], Response::HTTP_SEE_OTHER);
    }
}

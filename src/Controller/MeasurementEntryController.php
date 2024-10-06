<?php

namespace App\Controller;

use App\Entity\MeasurementEntry;
use App\Form\MeasurementEntryType;
use App\Repository\MeasurementEntryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/measurement/entry')]
final class MeasurementEntryController extends AbstractController
{
    #[Route(name: 'app_measurement_entry_index', methods: ['GET'])]
    public function index(MeasurementEntryRepository $measurementEntryRepository): Response
    {
        return $this->render('measurement_entry/index.html.twig', [
            'measurement_entries' => $measurementEntryRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_measurement_entry_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $measurementEntry = new MeasurementEntry();
        $form = $this->createForm(MeasurementEntryType::class, $measurementEntry, [
            'validation_groups' => ['create'],
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($measurementEntry);
            $entityManager->flush();

            return $this->redirectToRoute('app_measurement_entry_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('measurement_entry/new.html.twig', [
            'measurement_entry' => $measurementEntry,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_measurement_entry_show', methods: ['GET'])]
    public function show(MeasurementEntry $measurementEntry): Response
    {
        return $this->render('measurement_entry/show.html.twig', [
            'measurement_entry' => $measurementEntry,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_measurement_entry_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, MeasurementEntry $measurementEntry, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MeasurementEntryType::class, $measurementEntry, [
            'validation_groups' => ['edit'],
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_measurement_entry_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('measurement_entry/edit.html.twig', [
            'measurement_entry' => $measurementEntry,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_measurement_entry_delete', methods: ['POST'])]
    public function delete(Request $request, MeasurementEntry $measurementEntry, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$measurementEntry->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($measurementEntry);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_measurement_entry_index', [], Response::HTTP_SEE_OTHER);
    }
}

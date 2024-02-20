<?php

namespace App\Controller;

use App\Entity\FeedbackDon;
use App\Form\FeedbackDonType;
use App\Repository\FeedbackDonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/feedback/don')]
class FeedbackDonController extends AbstractController
{
    #[Route('/', name: 'app_feedback_don_index', methods: ['GET'])]
    public function index(FeedbackDonRepository $feedbackDonRepository): Response
    {
        return $this->render('feedback_don/index.html.twig', [
            'feedback_dons' => $feedbackDonRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_feedback_don_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $feedbackDon = new FeedbackDon();
        $form = $this->createForm(FeedbackDonType::class, $feedbackDon);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($feedbackDon);
            $entityManager->flush();

            return $this->redirectToRoute('app_feedback_don_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('feedback_don/new.html.twig', [
            'feedback_don' => $feedbackDon,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_feedback_don_show', methods: ['GET'])]
    public function show(FeedbackDon $feedbackDon): Response
    {
        return $this->render('feedback_don/show.html.twig', [
            'feedback_don' => $feedbackDon,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_feedback_don_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, FeedbackDon $feedbackDon, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(FeedbackDonType::class, $feedbackDon);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_feedback_don_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('feedback_don/edit.html.twig', [
            'feedback_don' => $feedbackDon,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_feedback_don_delete', methods: ['POST'])]
    public function delete(Request $request, FeedbackDon $feedbackDon, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$feedbackDon->getId(), $request->request->get('_token'))) {
            $entityManager->remove($feedbackDon);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_feedback_don_index', [], Response::HTTP_SEE_OTHER);
    }
}

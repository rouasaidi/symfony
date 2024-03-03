<?php

namespace App\Controller;

use App\Entity\Donation;
use App\Entity\FeedbackDon;
use App\Form\DonationType;
use App\Repository\DonationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/donation')]
class DonationController extends AbstractController
{
    #[Route('/', name: 'app_donation_index', methods: ['GET'])]
    public function index(DonationRepository $donationRepository): Response
    {
        return $this->render('donation/showF.html.twig', [
            'donations' => $donationRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_donation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $donation = new Donation();
        $donation->setStatus(0);
        $form = $this->createForm(DonationType::class, $donation);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($donation);
            $entityManager->flush();

            $donationId = $donation->getId();

            // Redirection vers l'action show avec l'ID de l'utilisateur nouvellement ajouté
            return $this->redirectToRoute('app_donation_show', ['id' => $donationId], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('donation/new.html.twig', [
            'donation' => $donation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_donation_show', methods: ['GET'])]
    public function show(Donation $donation): Response
    {
        return $this->render('donation/show.html.twig', [
            'donation' => $donation,
        ]);
    }

    #[Route('/A/{id}', name: 'app_donation_Ashow', methods: ['GET'])]
    public function Ashow(Donation $donation ,$id ,DonationRepository $donationRepository): Response
    {
        
        $donation123=new Donation();
        $donation123=$donationRepository->find($id);
        $donationFDesc = $donation123->getFeedbackDons(); 
        $feedbackid =$donation123->getFeedbackDons(); 
        return $this->render('donation/Ashow.html.twig', [
            'donation' => $donation,  'donationFDesc'=>$donationFDesc, 'feedbackid'=>$feedbackid
        
        ]);
    }


    #[Route('/{id}/edit', name: 'app_donation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Donation $donation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DonationType::class, $donation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $donationId = $donation->getId();

            return $this->redirectToRoute('app_donation_show', ['id' => $donationId], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('donation/edit.html.twig', [
            'donation' => $donation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_donation_delete', methods: ['POST'])]
    public function delete(Request $request, Donation $donation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$donation->getId(), $request->request->get('_token'))) {
            $entityManager->remove($donation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_donation_new', [], Response::HTTP_SEE_OTHER);
    }

   
  
}

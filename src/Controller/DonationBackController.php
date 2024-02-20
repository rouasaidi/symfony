<?php

namespace App\Controller;

use App\Entity\Donation;
use App\Form\Donation1Type;
use App\Repository\DonationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/donation/back')]
class DonationBackController extends AbstractController
{
    #[Route('/', name: 'app_donation_back_index', methods: ['GET'])]
    public function index(DonationRepository $donationRepository): Response
    {
        return $this->render('donation_back/index.html.twig', [
            'donations' => $donationRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'app_donation_back_show', methods: ['GET'])]
    public function show(Donation $donation): Response
    {
        return $this->render('donation_back/show.html.twig', [
            'donation' => $donation,
        ]);
    }

   
    #[Route('/{id}', name: 'app_donation_back_delete', methods: ['POST'])]
    public function delete(Request $request, Donation $donation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$donation->getId(), $request->request->get('_token'))) {
            $entityManager->remove($donation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_donation_back_index', [], Response::HTTP_SEE_OTHER);
    }
}

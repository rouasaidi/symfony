<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\User;
use App\Form\CommandeType;
use App\Repository\CommandeRepository;
use App\Repository\PanierRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/commande')]
class CommandeController extends AbstractController
{
    #[Route('/', name: 'app_commande_index', methods: ['GET'])]
    public function index(CommandeRepository $commandeRepository): Response
    {
        return $this->render('commande/index.html.twig', [
            'commandes' => $commandeRepository->findAll(),
        ]);
    }



    #[Route('/newcomm/{id}', name: 'app_commande_new', methods: ['GET', 'POST'])]
    public function new($id, Request $request, UserRepository $userRepository, EntityManagerInterface $entityManager): Response
    {
        $user = $userRepository->find($id);
    
        // Récupérer les paniers de l'utilisateur
        $paniers = $user->getPaniers();
    
        // Initialiser les totaux de la commande
        $totalPrice = 0;
        $totalQuant = 0;
    
        // Parcourir les paniers de l'utilisateur pour calculer les totaux
        foreach ($paniers as $panier) {
            $totalPrice += $panier->getTotalPrice();
            $totalQuant += $panier->getTotalQuant();
        }
    
        // Créer une nouvelle commande
        $commande = new Commande();
    
        // Mettre à jour les totaux de la commande avec les totaux calculés
        $commande->setTotalPrice($totalPrice);
        $commande->setTotalQuant($totalQuant);
        // Ajouter la date de validation actuelle
        $commande->setDateValidation(new \DateTime());
    
        // Associer le dernier panier trouvé à la commande (s'il y en a)
        if (count($paniers) > 0) {
            $lastPanier = $paniers[count($paniers) - 1];
            $commande->setPanier($lastPanier);
        }
    
        // Associer l'utilisateur à la commande
        $commande->setUser($user);
    
        // Enregistrer la nouvelle commande
        $entityManager->persist($commande);
        $entityManager->flush();
    
        return $this->redirectToRoute('app_commande_index', [], Response::HTTP_SEE_OTHER);
    }
    

    // #[Route('/newcomm/{id}', name: 'app_commande_new', methods: ['GET', 'POST'])]
    // public function new($id, Request $request, PanierRepository $panierRepository): Response
    // {
    //     // Rechercher l'utilisateur par son ID
    //     $user = $this->getDoctrine()->getRepository(User::class)->find($id);
    //     if (!$user) {
    //         throw $this->createNotFoundException('User not found');
    //     }
    
    //     // Trouver tous les paniers de l'utilisateur
    //     $paniers = $panierRepository->findBy(['user' => $user]);
    
    //     // Initialiser les totaux de la commande
    //     $totalPrice = 0;
    //     $totalQuant = 0;
    
    //     // Parcourir les paniers de l'utilisateur pour calculer les totaux
    //     foreach ($paniers as $panier) {
    //         $totalPrice += $panier->getTotalPrice();
    //         $totalQuant += $panier->getTotalQuant();
    //     }
    
    //     // Créer une nouvelle commande
    //     $commande = new Commande();
    //     $commande->setUser($user);
    //     $commande->setTotalPrice($totalPrice);
    //     $commande->setTotalQuant($totalQuant);
    //     $commande->setDateValidation(new \DateTime());
    
    //     // Associer un panier à la commande (pour la sauvegarde de l'ID du panier)
    //     // Par exemple, si vous voulez lier la dernière panier à la commande :
    //     if (count($paniers) > 0) {
    //         $lastPanier = $paniers[count($paniers) - 1];
    //         $commande->setPanier($lastPanier);
    //     }
    
    //     $entityManager = $this->getDoctrine()->getManager();
    //     $entityManager->persist($commande);
    //     $entityManager->flush();
    
    //     return $this->redirectToRoute('app_commande_index');
    // }


    // #[Route('/newcomm/{id}', name: 'app_commande_new', methods: ['GET', 'POST'])]
    // public function new($id,Request $request,UserRepository $userRepository, EntityManagerInterface $entityManager): Response
    // {
    //     $user=$userRepository->find($id);//tasjil el commande bel user
    //     $commande = new Commande();
    //     $form = $this->createForm(CommandeType::class, $commande);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $entityManager->persist($commande);
    //         $entityManager->flush();

    //         return $this->redirectToRoute('app_commande_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->renderForm('commande/new.html.twig', [
    //         'commande' => $commande,
    //         'form' => $form,
    //     ]);
    // }

    #[Route('/{id}', name: 'app_commande_show', methods: ['GET'])]
    public function show(Commande $commande): Response
    {
        return $this->render('commande/show.html.twig', [
            'commande' => $commande,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_commande_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Commande $commande, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CommandeType::class, $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_commande_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('commande/edit.html.twig', [
            'commande' => $commande,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_commande_delete', methods: ['POST'])]
    public function delete(Request $request, Commande $commande, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$commande->getId(), $request->request->get('_token'))) {
            $entityManager->remove($commande);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_commande_index', [], Response::HTTP_SEE_OTHER);
    }
}

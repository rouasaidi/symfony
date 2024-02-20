<?php

namespace App\Controller;
use App\Repository\UserRepository;
use App\Entity\User;
use App\Entity\Panier;
use App\Entity\Product;
use App\Form\PanierType;
use App\Form\SignupType;
use App\Repository\PanierRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PanierController extends AbstractController
{

    #[Route('/panier', name: 'app_panier_index', methods: ['GET'])]
    public function indexf(PanierRepository $panierRepository): Response
    {
        // Get all paniers
        $paniers = $panierRepository->findAll();
    
        // Calculate total quantity and total price for each panier
        // $panierData = [];
        // foreach ($paniers as $panier) {
        //     $totalQuantity = 0;
        //     $totalPrice = 0;
    
            // Iterate over products in the panier to calculate total quantity and total price
            // foreach ($panier->getProducts() as $product) {
            //     $totalQuantity += 1;
            //     $totalPrice += $totalQuantity * $product->getPrice();
            // }
    
            // Add panier data to array
        //     $panierData[] = [
        //         'panier' => $panier,
        //         'totalQuantity' => $totalQuantity,
        //         'totalPrice' => $totalPrice,
        //     ];
        // }
    
        return $this->render('panier/index.html.twig', [
            'panierData' => $paniers,
        ]);
    }

    // #[Route('/panier/new', name: 'app_panier_new', methods: ['GET', 'POST'])]
    // public function new(Request $request, EntityManagerInterface $entityManager): Response
    // {
    //     $panier = new Panier();
    //     $form = $this->createForm(PanierType::class, $panier);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $entityManager->persist($panier);
    //         $entityManager->flush();

    //         return $this->redirectToRoute('app_panier_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->renderForm('panier/new.html.twig', [
    //         'panier' => $panier,
    //         'form' => $form,
    //     ]);
    // }

    #[Route('/panier/{id}', name: 'app_panier_show', methods: ['GET'])]
    public function show(Panier $panier): Response
    {
        return $this->render('panier/show.html.twig', [
            'panier' => $panier,
        ]);
    }
    #[Route('/panier/{id}/edit', name: 'app_panier_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Panier $panier, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PanierType::class, $panier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newQuantity = $form->get('total_quant')->getData();
            $productPrice = $panier->getProducts()->first()->getPrice();
            $newTotalPrice = $newQuantity * $productPrice;
            $panier->setTotalPrice($newTotalPrice);
            $entityManager->persist($panier);
            $entityManager->flush();

            return $this->redirectToRoute('app_panier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('panier/edit.html.twig', [
            'panier' => $panier,
            'form' => $form,
        ]);
    }

    #[Route('/panier/{id}', name: 'app_panier_delete', methods: ['POST'])]
    public function delete(Request $request, Panier $panier, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$panier->getId(), $request->request->get('_token'))) {
            $entityManager->remove($panier);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_panier_index', [], Response::HTTP_SEE_OTHER);
    }

    // #[Route('/showab/{id1}', name: 'app_product_showab')]
    // public function showab($id,Panier $p ,Product $product,ProductRepository $m): Response
    // {

    //     $product=$m->find($id);
    //     $p->addProduct($product);
    //     return $this->redirectToRoute('app_product_showab', ['p' => $p]);
    //     return $this->redirectToRoute('app_panier', ['p' => $p]);
    //     return $this->render('product/show.html.twig', [
    //         'product' => $product,
    //         'p'=>$p,
    //     ]);
    // }

    // #[Route('/showab/{id}', name: 'app_product_showab')]
    // public function showab($id, ProductRepository $productRepository, EntityManagerInterface $entityManager): Response
    // {
    //     $pannier = new Panier();

    //     // Find the product by id using the repository
    //     $product = $productRepository->find($id);
    //     if (!$product) {
    //         throw $this->createNotFoundException('Product not found');
    //     }
        
    //     // Fetch the user with ID 1 from the database
    //     $user = $entityManager->getRepository(User::class)->find(1);
    //     if (!$user) {
    //         throw $this->createNotFoundException('User not found');
    //     }

    //     // Add the product to the panier
    //     $pannier->addProduct($product);
    //     $pannier->setTotalQuant(1);
    //     $pannier->setTotalPrice($product->getPrice());
    //     $pannier->setUser($user);
    //     $pannier->setStatus('client');

    //     $entityManager->persist($pannier);
    //     $entityManager->flush();

    //     // Redirect to the product's index page
    //     return $this->redirectToRoute('app_product_index');
    // }
    // #[Route('/showab/{id}', name: 'app_product_showab')]
    // public function showab($id, ProductRepository $productRepository, EntityManagerInterface $entityManager, PanierRepository $panierRepository): Response
    // {
    //     // Find the product by id using the repository
    //     $product = $productRepository->find($id);
    //     if (!$product) {
    //         throw $this->createNotFoundException('Product not found');
    //     }
        
    //     // Fetch the user with ID 1 from the database
    //     $user = $entityManager->getRepository(User::class)->find(1);
    //     if (!$user) {
    //         throw $this->createNotFoundException('User not found');
    //     }
    
    //     // Find the panier for the current user
    //     $pannier = $panierRepository->findOneBy(['products' => $product]);
    //     if (!$pannier) {
    //         // If panier does not exist, create a new one
    //         $pannier = new Panier();
    //         $pannier->setUser($user);
    //         $pannier->setStatus('client');
    //     }
    
    //     // Update totalQuant and totalPrice
    //     $currentTotalQuant = $pannier->getTotalQuant() ?? 0;
    //     $currentTotalPrice = $pannier->getTotalPrice() ?? 0;
    
    //     $pannier->addProduct($product);
    //     $pannier->setTotalQuant($currentTotalQuant + 1);
    //     $pannier->setTotalPrice($currentTotalPrice + $product->getPrice());
    
    //     $entityManager->persist($pannier);
    //     $entityManager->flush();
    
    //     // Redirect to the product's index page
    //     return $this->redirectToRoute('app_product_index');
    // }

    #[Route('/showab/{id}', name: 'app_product_showab')]
public function showab($id, ProductRepository $productRepository, EntityManagerInterface $entityManager, PanierRepository $panierRepository): Response
{
    // Find the product by ID
    $product = $productRepository->find($id);
    if (!$product) {
        throw $this->createNotFoundException('Product not found');
    }
    
    // Find or create a Panier for the product
    $panier = $product->getPanier();
    if (!$panier) {
        $user = $entityManager->getRepository(User::class)->find(1);
        

        $panier = new Panier();
        $panier->setUser($user);
        $panier->addProduct($product);
        $panier->setTotalQuant(1);
        $panier->setTotalPrice($product->getPrice());
        $panier->setStatus('client');
        $entityManager->persist($panier);
    } else {
        // Update totalQuant and totalPrice
        $currentTotalQuant = $panier->getTotalQuant() ?? 0;
        $currentTotalPrice = $panier->getTotalPrice() ?? 0;
        $panier->setTotalQuant($currentTotalQuant + 1);
        $panier->setTotalPrice($currentTotalPrice + $product->getPrice());
    }

    $entityManager->flush();

    // Redirect to the product's index page
    return $this->redirectToRoute('app_product_index');
}

    //allah yrabbah
    






  
    // #[Route('/signup', name: 'app_signup')]
    // public function addformulaire( ManagerRegistry $ManagerRegistry,Request $req )
    // {
      
    // $en =$ManagerRegistry->getManager();
    // $users=new User();
    // $form=$this->createform(SignupType::class,$users);
    // $form->handleRequest($req);
    // if ($form->isSubmitted() and $form->isValid())
    // {
    
    // $en->persist($users);
    // $en->flush();
    // return $this->redirectToRoute('app_afficher', ['id' => $users->getId()]);
    // return $this->redirectToRoute('app_panier', ['id1' => $users->getId()]);
    // //return $this->redirectToRoute("app_signup");
    
    // }
    //     return $this->renderForm("signup/index.html.twig",[
    //         'form'=>$form]);
    // }
    #[Route('/panier/{p}/{id1}', name: 'app_panier')]
    public function index(ManagerRegistry $pss,$p,UserRepository $rep,$id1): Response
    {
        $Panier =new Panier();
        $Panier=$p;
        $u=new User();
        $u=$rep->find($id1);
        $u->addPanier($Panier);
       
        
        return $this->render('panier/index.html.twig', [
            'controller_name' => 'PanierController',
        ]);
    }
}

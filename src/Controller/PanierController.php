<?php

namespace App\Controller;
use App\Repository\UserRepository;
use App\Entity\User;
use App\Entity\Panier;
use App\Entity\Product;
use App\Form\SignupType;
use App\Repository\ProductRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PanierController extends App\Controller\AbstractController
{
    #[Route('/showab/{id1}', name: 'app_product_showab')]
    public function showab($id,Panier $p ,Product $product,ProductRepository $m): Response
    {

        $product=$m->find($id);
        $p->addProduct($product);
        return $this->redirectToRoute('app_product_showab', ['p' => $p]);
        return $this->redirectToRoute('app_panier', ['p' => $p]);
        return $this->render('product/show.html.twig', [
            'product' => $product,
            'p'=>$p,
        ]);
    }






  
    #[Route('/signup', name: 'app_signup')]
    public function addformulaire( ManagerRegistry $ManagerRegistry,Request $req )
    {
      
    $en =$ManagerRegistry->getManager();
    $users=new User();
    $form=$this->createform(SignupType::class,$users);
    $form->handleRequest($req);
    if ($form->isSubmitted() and $form->isValid())
    {
    
    $en->persist($users);
    $en->flush();
    return $this->redirectToRoute('app_afficher', ['id' => $users->getId()]);
    return $this->redirectToRoute('app_panier', ['id1' => $users->getId()]);
    //return $this->redirectToRoute("app_signup");
    
    }
        return $this->renderForm("signup/index.html.twig",[
            'form'=>$form]);
    }
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

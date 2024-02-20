<?php

namespace App\Controller;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Form\AdminType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class AdminController extends AbstractController
{
   /* #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
*/
    

  #[Route('/afficher_admin', name: 'app_afficher_admin')]
  public function affciher(UserRepository $repository, Request $req): Response
  {
      $users=$repository ->findAll();//select tous
     
  return $this->render("admin/index.html.twig",[
      'user'=>$users]);
  }
  
  #[Route('/addadmin', name: 'app_addadmin')]
  public function addformulaire( ManagerRegistry $ManagerRegistry,Request $req )
  {
    
  $en =$ManagerRegistry->getManager();
  $users=new User();
  $form=$this->createform(AdminType::class,$users);
  $form->handleRequest($req);
  if ($form->isSubmitted() and $form->isValid())
  {
  
  $en->persist($users);
  $en->flush();
  return $this->redirectToRoute('app_afficher_admin', ['id' => $users->getId()]);
  //return $this->redirectToRoute("app_signup");
  
  }
      return $this->renderForm("admin/addadmin.html.twig",[
          'form'=>$form]);
  }

  #[Route('/edditadmin/{id}=', name: 'app_edditadmin')]
  public function editadmin($id, UserRepository $repository1, ManagerRegistry $ManagerRegistry, Request $req): Response 
  {
  
    //var_dump($id) . die();
    $users=new User();
    $en =$ManagerRegistry->getManager();
    $dataid=$repository1->find($id);
    $form=$this->createform(AdminType::class,$dataid);
    $form->handleRequest($req);
  if ($form->isSubmitted() and $form->isValid())
  {
  
  $en->persist($dataid);
  $en->flush();
  return $this->redirectToRoute('app_afficher_admin' , ['id' => $dataid->getId()]);
  }
      return $this->renderForm("admin/editeadmin.html.twig",[
          'formedit' => $form]);
  }



  #[Route('/deleteadmin/{id}', name: 'app_deleteadmin')]
  public function delete($id,UserRepository $repository2,ManagerRegistry $ManagerRegistry,Request $req): Response
  { $en =$ManagerRegistry->getManager();
      $fin=$repository2->find($id);
      $en->remove($fin);
      $en->flush();
      return $this->redirectToRoute("app_afficher_admin");
  }

 



}

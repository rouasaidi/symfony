<?php

namespace App\Controller;
use App\Entity\User;
use App\Form\SignupType;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class SignupController extends AbstractController
{
   /* #[Route('/signup', name: 'app_signup')]
    public function index(): Response
    {
        return $this->render('signup/index.html.twig', [
            'controller_name' => 'SignupController',
        ]);
    }*/
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
//return $this->redirectToRoute("app_signup");

}
    return $this->renderForm("signup/index.html.twig",[
        'form'=>$form]);
}


#[Route('/eddit/{id}=', name: 'app_eddit')]
public function editFormulaire($id, UserRepository $repository1, ManagerRegistry $ManagerRegistry, Request $req): Response 
{

  //var_dump($id) . die();
  $users=new User();
  $en =$ManagerRegistry->getManager();
  $dataid=$repository1->find($id);
  $form=$this->createform(SignupType::class,$dataid);
  $form->handleRequest($req);
if ($form->isSubmitted() and $form->isValid())
{

$en->persist($dataid);
$en->flush();
return $this->redirectToRoute('app_afficher' , ['id' => $dataid->getId()]);
}
    return $this->renderForm("signup/show_user_edit.html.twig",[
        'formedit' => $form]);
}


  #[Route('/afficher/{id}', name: 'app_afficher')]
  public function afficher(User $users,UserRepository $repository, Request $req): Response
  {
    //  $authors=$repository ->OrderAutByEmail();//select tous
    
     
     // $users=$repository ->findAll();//select tous
     
  return $this->render("signup/show_user.html.twig",[
      'user'=>$users]);
  }

  #[Route('/delete/{id}', name: 'app_delete')]
  public function delete($id,UserRepository $repository2,ManagerRegistry $ManagerRegistry,Request $req): Response
  { $en =$ManagerRegistry->getManager();
      $fin=$repository2->find($id);
      $en->remove($fin);
      $en->flush();
      return $this->redirectToRoute("app_login");
  }

 

}


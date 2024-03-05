<?php

namespace App\Controller;
use App\Entity\User;
use App\Form\SignupType;
use App\Form\SignupEditeType;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\service\SendMailService;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Label\Font\NotoSans;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Writer\PngWriter;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class SignupController extends AbstractController
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }
   /* #[Route('/signup', name: 'app_signup')]
    public function index(): Response
    {
        return $this->render('signup/index.html.twig', [
            'controller_name' => 'SignupController',
        ]);
    }*/
    #[Route('/signup', name: 'app_signup')]
public function addformulaire( ManagerRegistry $ManagerRegistry,Request $req,SendMailService $mail)
{
  
$en =$ManagerRegistry->getManager();
$users=new User();
$form=$this->createform(SignupType::class,$users);
$form->handleRequest($req);
if ($form->isSubmitted() and $form->isValid())
{

    $users->setPassword($this->passwordEncoder->encodePassword($users, $users->getPassword()));
    $selectedRoles = $form->get('roles')->getData();
    $users->setRoles($selectedRoles);
    $users->setIsBanned(false);
$en->persist($users);
$en->flush();

$mail->send(
    'no-reply@monsite.net',
    $users->getEmail(),
    'Activation de votre compte sur le site e-commerce',
    'register',
    compact('users')
);
//return $this->redirectToRoute('app_afficher', ['id' => $users->getId()]);
return $this->redirectToRoute("app_login");

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
  $form=$this->createform(SignupEditeType::class,$dataid);
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


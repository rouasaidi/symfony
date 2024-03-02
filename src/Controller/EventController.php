<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use App\Repository\EventRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EventController extends AbstractController
{
    #[Route('/event', name: 'app_event')]
    public function index(): Response
    {
        return $this->render('event/index.html.twig', [
            'controller_name' => 'EventController',
        ]);
    }
    #[Route('/addevent', name: 'app_addevent')]
    public function addevent(EventType $f, ManagerRegistry $em,Request $req ): Response
    {
        $Event1 = new Event();
        $Event1->setImage("default");
$em=$em->getManager();
$f=$this->createForm(EventType::class,$Event1);
$f->handleRequest($req);
if($f->isSubmitted() and $f->isValid())
{
   
    $em->persist($Event1);
    $em->flush();
}
        return $this->renderForm('event/addevent.html.twig', [
            'controller_name' => 'EventController',
            'f'=>$f,
        ]);
    }
  
    
    #[Route('/appshowdbevent', name: 'app_showauthordb')]
    public function showdb(EventRepository $event145): Response
    {
        $name=$event145->findAll();
        //dd($name);
       // var_dump($name).die();
       // print_r($name);
       // $nigffger=$author145->find
        return $this->render('event/showevents.html.twig', [
            'controller_name' => 'AZIZ',
            'base_events'=>$name,
            
       ]);
    }
    #[Route('/appdeleteevent/{id}', name: 'app_delete')]
    public function delete(EventRepository $repo,$id,ManagerRegistry $manager): Response
    {
         $emm = $manager->getManager();
            $idremove = $repo->find($id);
            $emm->remove($idremove);
            $emm->flush();
        return $this->redirectToRoute('appback_showeventdb');
        }
            



#[Route('/backshowdbevent', name: 'appback_showeventdb')]
    public function showback_event(EventRepository $event145): Response
    {
        $name=$event145->findAll();
        //dd($name);
       // var_dump($name).die();
       // print_r($name);
       // $nigffger=$author145->find
        return $this->render('event/showback.html.twig', [
            'controller_name' => 'AZIZ',
            'base_events'=>$name,
            
       ]);
    }

    #[Route('/modifierevent/{id}', name: 'modifierevent')]
    public function modifierauthor($id,EventType $form,EventRepository $event123, ManagerRegistry $em,Request $req): Response
    {
//var_dump($id).die();
$em=$em->getmanager();

        $namkde= $event123->find($id);
        //var_dump($namkde).die();
       
        //$author=new Authorentity();
        $form = $this->createForm(EventType::class, $namkde);
        $form->handleRequest($req);
       
       if($form->isSubmitted() and $form->isValid())
       {
       $em->persist($namkde);
    $em->flush();
    return $this->redirectToRoute('appback_showeventdb');
       }
       return $this->renderForm('event/modifyevent.html.twig', [
        'controller_name' => 'EventController',
        'f'=>$form,
    ]);


    }
}

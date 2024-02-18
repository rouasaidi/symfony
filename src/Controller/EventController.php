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
if($f->isSubmitted())
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
   

}

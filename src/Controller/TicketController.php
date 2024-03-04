<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Event;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Entity\Ticket;
use App\Form\EventType;
use App\Form\TicketType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Repository\EventRepository;
use App\Repository\TicketRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\Request;


class TicketController extends AbstractController
{
    #[Route('/ticket', name: 'app_ticket')]
    public function index(): Response
    {
        return $this->render('ticket/index.html.twig', [
            'controller_name' => 'TicketController',
        ]);
    }
    #[Route('/appaddTiddcket/{id}', name: 'app_addticddket')]
    public function addtiddcket(EventRepository $event145, $id, Request $request, ManagerRegistry $em, FlashyNotifier $flashy): Response
    {
        $event = $event145->find($id);
        $em1 = $em->getManager();
        $ticket = new Ticket();
        $ticket->setEvent($event);
        $form = $this->createForm(TicketType::class, $ticket, [
            'event' => $event,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $type = $ticket->getType();
            if ($type === 'VIP') {
                $ticket->setPrice(35);
            } elseif ($type === 'Standard') {
                $ticket->setPrice(20);
            }
            $flashy->success('Ticket bought successfully, Have fun in the event', 'Operation completed successfully.');
            $em1->persist($ticket);
            $em1->flush();
        }

        return $this->render('ticket/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }



    #[Route('/showticketbyid/{id}', name: 'app_showticketbyid')]
    public function show_ticketsbyid($id, TicketRepository $tickrepo, EventRepository $eventrepo, FlashyNotifier $flashy): Response
    {
        $vipPercentage=0;
        $standardPercentage=0;
        $event145 = new Event();
        $vipnb = $eventrepo->countVipTicketsByEventId($id);
        $event145 = $eventrepo->find($id);
        $quantitytotal = $event145->getQuantity();
        $base_ticketsid = $event145->getTickets();
        $standardnb = $quantitytotal - $vipnb;
        $sum = 0;
        foreach ($base_ticketsid as $tik) {
            $sum += $tik->getPrice();
        }
        $flashy->success('Ticket bought successfully, Have fun in the event', 'Operation completed successfully.');
    
        // Calculate the percentage of VIP tickets
        if($quantitytotal==0)
        {
            echo('there is no ticket');
        }
        else{
            $vipPercentage = ($vipnb / $quantitytotal) * 100;
        
            // Calculate the percentage of standard tickets
            $standardPercentage = ($standardnb / $quantitytotal) * 100;


        }
        
    
        return $this->render('ticket/showbyid.html.twig', [
            'controller_name' => 'TicketController',
            'base_tickets' => $base_ticketsid,
            'event' => $event145,
            'sum' => $sum,
            'total' => $quantitytotal,
            'nbvip' => $vipnb,
            'nbstandard' => $standardnb,
            'vipPercentage' => $vipPercentage,
            'standardPercentage' => $standardPercentage,
        ]);
    }
    #[Route('/showticket', name: 'app_showtickets')]
    public function show_ticket(TicketRepository $tickrepo,FlashyNotifier $flashy): Response
    {


        $base_ticketsid=$tickrepo->findAll();
        $sum = 0;
        foreach($base_ticketsid as $tik)
        {
            $sum+=$tik->getPrice();
        }


        return $this->render('ticket/showticketdb.html.twig', [
            'controller_name' => 'TicketController',
            'base_tickets'=>$base_ticketsid,
            'sum'=>$sum,
        

        ]);
    }
    #[Route('/appdeleteticket/{id}', name: 'app_deleteticket')]
    public function delete(TicketRepository $repo,$id,ManagerRegistry $manager,FlashyNotifier $flashy): Response
    {
         $emm = $manager->getManager();
            $idremove = $repo->find($id);
            $emm->remove($idremove);
            $emm->flush();
            $flashy->success('Ticket bought successfully, Have fun in the event', 'Operation completed successfully.');
        return $this->redirectToRoute('app_showtickets');
        }

            

}

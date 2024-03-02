<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Ticket;
use App\Repository\EventRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use App\Form\TicketType;
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
    public function addtiddcket(EventRepository $event145,$id,Request $request,ManagerRegistry $em): Response
    {   $event = $event145->find($id);
        $em1=$em->getManager();
        $ticket = new Ticket();
        $ticket->setEvent($event);
        $form = $this->createForm(TicketType::class, $ticket, [
            'event' => $event,
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $type = $ticket->getType();
            $type = $ticket->getType();
        if ($type === 'VIP') {
            $ticket->setPrice(35);
        } elseif ($type === 'Standard') {
            $ticket->setPrice(20);
        }
        $em1->persist($ticket);
        $em1->flush();
        return $this->redirectToRoute('app_showauthordb');
        }
       
        return $this->render('ticket/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

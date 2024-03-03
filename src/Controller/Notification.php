<?php

namespace App\Controller;
use App\Repository\NotificationRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\NotificationService;

class NotificationController extends AbstractController
{
    
   /* #[Route("/notifications", name:"notification_list")]
    
    public function listNotifications(NotificationRepository $notificationRepository)
    {
        // Récupérer les notifications de l'utilisateur connecté
        $user = $this->getUser();
        $notifications = $notificationRepository->findBy(['user' => $user], ['createdAt' => 'DESC']);

        // Créer un tableau des données des notifications
        $data = [];
        foreach ($notifications as $notification) {
            $data[] = [
                'id' => $notification->getId(),
                'message' => $notification->getMessage(),
                'createdAt' => $notification->getCreatedAt()->format('Y-m-d H:i:s'),
            ];
        }

        // Retourner les données au format JSON
        return new JsonResponse($data);
    }*/
    #[Route("/notifications", name:"notification_list")]
    public function sendNotification(NotificationService $notificationService)
    {
        $message = "Nouvelle notification !";
        $notificationService->sendNotification($message);

        return $this->redirectToRoute('app_donation_index');
    }
}

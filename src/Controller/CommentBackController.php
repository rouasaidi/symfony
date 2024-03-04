<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\Comment1Type;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use MercurySeries\FlashyBundle\FlashyNotifier ;


#[Route('/comment/back')]
class CommentBackController extends AbstractController
{
    #[Route('/', name: 'app_comment_back_index', methods: ['GET'])]
    public function index(CommentRepository $commentRepository): Response
    {
        return $this->render('comment_back/index.html.twig', [
            'comments' => $commentRepository->findAll(),
        ]);
    }


    #[Route('/{id}', name: 'app_back_comment_delete', methods: ['POST'])]
public function deleteBackComment(Request $request,FlashyNotifier $flashy  ,Comment $comment, EntityManagerInterface $entityManager): Response
{
    // Check if the CSRF token is valid
    if (!$this->isCsrfTokenValid('delete'.$comment->getId(), $request->request->get('_token'))) {
        // Handle invalid CSRF token, perhaps redirect back to the article or show an error message
        throw $this->createAccessDeniedException('Invalid CSRF token.');
    }

    // Get the article ID before removing the comment
    $articleId = $comment->getArticle()->getId();

    // Remove and flush the comment entity
    $entityManager->remove($comment);
    $entityManager->flush();
   

    // Redirect to the article's back page after successful deletion
    return $this->redirectToRoute('app_back_article_show', ['id' => $articleId]);
    $flashy->error('Article supprimé!', 'http://your-awesome-link.com');
    
   
    


}}

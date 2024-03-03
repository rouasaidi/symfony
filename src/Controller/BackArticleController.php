<?php

namespace App\Controller;

use App\Entity\Article;

use App\Repository\ArticleRepository;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\RedirectResponse;

#[Route('/back/article')]
class BackArticleController extends AbstractController
{
    #[Route('/', name: 'app_back_article_index', methods: ['GET'])]
    public function index(ArticleRepository $articleRepository): Response
    {
        return $this->render('back_article/index.html.twig', [
            'articles' => $articleRepository->findAll(),
        ]);
    }

    
    

#[Route('det/back/article/{id}', name: 'app_back_article_show', methods: ['GET'])]
    public function showback(Article $article,CommentRepository $cmr): Response
    {
        $commentaires=$cmr->findBy(["article"=>$article->getId()]);
        return $this->render('back_article/showback.html.twig', [
            'article' => $article,'commentaires'=>$commentaires
        ]);
    }




    #[Route('/det/back/delete/{id}', name: 'app_back_article_delete', methods: ['POST'])]
    public function delete(Request $request, Article $article, EntityManagerInterface $entityManager): RedirectResponse
    {
        // Check if the CSRF token is valid
        if (!$this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            // Handle invalid CSRF token, perhaps redirect back to the article or show an error message
            throw $this->createAccessDeniedException('Invalid CSRF token.');
        }
    
        // Remove and flush the article entity
        $entityManager->remove($article);
        $entityManager->flush();
    
        // Redirect to the index page after successful deletion
        return $this->redirectToRoute('app_back_article_index');
    }
    
    
}

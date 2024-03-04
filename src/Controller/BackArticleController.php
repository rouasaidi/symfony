<?php

namespace App\Controller;

use App\Entity\Article;
use Symfony\Component\HttpFoundation\RequestStack;
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
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

use Knp\Component\Pager\PaginatorInterface;


#[Route('/back/article')]
class BackArticleController extends AbstractController
{
    #[Route('/', name: 'app_back_article_index', methods: ['GET'])]
    public function index(Request $request,ArticleRepository $articleRepository,PaginatorInterface $paginator): Response
    {
        $articlesQuery = $articleRepository->createQueryBuilder('a')
        ->getQuery();

    // Paginate the results
    $pagination = $paginator->paginate(
        $articlesQuery,
        $request->query->getInt('page', 1), // Page number
        2// Number of items per page
    );

    return $this->render('back_article/index.html.twig', [
        'pagination' => $pagination,
    ]);
        
    }
    #[Route('/trie', name: 'app_back_article_index_triedatee', methods: ['GET'])]
    public function index_trie(Request $request,ArticleRepository $articleRepository,PaginatorInterface $paginator): Response
    {
        $searchTerm = $request->query->get('searchTerm', '');
        $order = $request->query->get('order', 'desc');
    
        $queryBuilder = $articleRepository->createQueryBuilder('a');
    
        if (!empty($searchTerm)) {
            $queryBuilder->andWhere('a.title LIKE :searchTerm')
                         ->setParameter('searchTerm', '%' . $searchTerm . '%');
        }
    
        $queryBuilder->orderBy('a.date', $order);
    
        // Paginate the results
        $pagination = $paginator->paginate(
            $queryBuilder->getQuery(), // Doctrine QueryBuilder
            $request->query->getInt('page', 1), // Page number
            10 // Number of items per page
        );
    
        return $this->render('back_article/index.html.twig', [
            'pagination' => $pagination,
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
    public function delete(Request $request,FlashyNotifier $flashy , Article $article, EntityManagerInterface $entityManager,MailerInterface $mailer): RedirectResponse
    {
        // Check if the CSRF token is valid
        if (!$this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            // Handle invalid CSRF token, perhaps redirect back to the article or show an error message
            throw $this->createAccessDeniedException('Invalid CSRF token.');
        }
    
        // Remove and flush the article entity
        $entityManager->remove($article);
        $entityManager->flush();
        $userr=$article->getUser();
        // Envoi d'un e-mail à l'utilisateur
    $email = (new Email())
    ->from('hello@example.com')
    ->to($userr->getEmail())
    //->cc('cc@example.com')
    //->bcc('bcc@example.com')
    //->replyTo('fabien@example.com')
    //->priority(Email::PRIORITY_HIGH)
    ->subject('Votre Article a été supprimé !')
    ->text('Sending emails is fun again!')
    ->html( $this->renderView(
        'article/article_deleted.html.twig',
        ['article' => $article, 'user' => $userr]
    ),
    'text/html'
);

$mailer->send($email);
        // Redirect to the index page after successful deletion
        return $this->redirectToRoute('app_back_article_index');
        $flashy->error('Article deleted!', 'http://your-awesome-link.com');
    }
    
    
}

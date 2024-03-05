<?php

namespace App\Controller;
<<<<<<< HEAD

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
=======
use App\Repository\ArticleRepository;
use App\Repository\UserRepository;

>>>>>>> Dev_masters-3A57/malek
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
<<<<<<< HEAD
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\String\Slugger\SluggerInterface;

use MercurySeries\FlashyBundle\FlashyNotifier as FlashyBundleFlashyNotifier;

#[Route('/article')]
class ArticleController extends AbstractController
{
    #[Route('/', name: 'app_article_index')]
    public function index(ArticleRepository $articleRepository): Response
    {
        return $this->render('article/index.html.twig', [
            'articles' => $articleRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_article_new')]
public function new(Request $request,FlashyBundleFlashyNotifier $flashy, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
{
    $article = new Article();
    $article->setDateCmt(new \DateTime('now'));
    $form = $this->createForm(ArticleType::class, $article);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // Handle file upload
       

        // Persist the article to the database
        $entityManager->persist($article);
        $entityManager->flush();    
        $flashy->success('Article ajouté!', 'http://your-awesome-link.com');

        // Redirect to the index page after successful creation
        return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
    }

    // Render the form if it's not submitted or not valid
    return $this->renderForm('article/new.html.twig', [
        'article' => $article,
        'form' => $form,
    ]);
}
    #[Route('det/front/{id}', name: 'app_article_show', methods: ['GET'])]
    public function show(Article $article): Response
    {
        return $this->render('article/show.html.twig', [
            'article' => $article,
        ]);
    }

    

    #[Route('/{id}/edit', name: 'app_article_edit', methods: ['GET', 'POST'])]
public function edit(Request $request, Article $article, EntityManagerInterface $entityManager): Response
{
    $form = $this->createForm(ArticleType::class, $article);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager->flush();

        $this->addFlash('success', 'Article updated successfully.');

        return $this->redirectToRoute('app_article_index');
    }

    return $this->render('article/edit.html.twig', [
        'article' => $article,
        'form' => $form->createView(),
    ]);


    }

    #[Route('/{id}', name: 'app_article_delete', methods: ['POST'])]
    public function delete(Request $request, Article $article, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            $entityManager->remove($article);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
        
    }

    

}
=======

class ArticleController extends AbstractController
{
    #[Route('/article', name: 'app_article')]
    public function index(): Response
    {
        return $this->render('article/index.html.twig', [
            'controller_name' => 'ArticleController',
        ]);
    }
}


>>>>>>> Dev_masters-3A57/malek

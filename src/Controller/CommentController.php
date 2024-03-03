<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\Routing\Annotation\Route;

#[Route('/comment')]
class CommentController extends AbstractController
{
    #[Route('/', name: 'app_comment_index', methods: ['GET'])]
    public function index(CommentRepository $commentRepository): Response
    {
        $comments = $commentRepository->findAll();
        return $this->render('comment/index.html.twig', [
            'comments' => $comments,
        ]);
    }

    #[Route('/new', name: 'app_comment_new', methods: ['GET', 'POST'])]
public function new(Request $request, CommentRepository $commentRepository): Response
{
    $comment = new Comment();
    $comment->setDatecmt(new \DateTime('now'));
    $form = $this->createForm(CommentType::class, $comment);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($comment);
        $entityManager->flush();

        // Redirect to the article page where the comment was added
        return $this->redirectToRoute('app_article_show', ['id' => $comment->getArticle()->getId()]);
    }

    return $this->renderForm('comment/new.html.twig', [
        'comment' => $comment,
        'form' => $form,
    ]);


    }

    #[Route('/{id}', name: 'app_comment_show', methods: ['GET'])]
    public function show(Comment $comment): Response
    {
        return $this->render('comment/show.html.twig', [
            'comment' => $comment,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_comment_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Comment $comment, CommentRepository $commentRepository): Response
    {
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commentRepository->save($comment);
            return $this->redirectToRoute('app_article_show', ['id' => $comment->getArticle()->getId()]);
        }

        return $this->renderForm('comment/edit.html.twig', [
            'comment' => $comment,
            'form' => $form,
          
        ]);
    }

    #[Route('/{id}', name: 'app_comment_delete', methods: ['POST', 'DELETE'])]
public function delete(Request $request, Comment $comment, EntityManagerInterface $entityManager): Response
{
    if ($this->isCsrfTokenValid('delete'.$comment->getId(), $request->request->get('_token'))) {
        $entityManager->remove($comment);
        $entityManager->flush();
    }

    return $this->redirectToRoute('app_article_show', ['id' => $comment->getArticle()->getId()]);
}





    
}

<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ArticleRepository;
use App\Entity\Article;
use MercurySeries\FlashyBundle\FlashyNotifier;
use App\Entity\Dislike;
use App\Entity\Like;
use App\Entity\User;
use Symfony\Component\Routing\Annotation\Route;
use Snipe\BanBuilder\CensorWords;

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

    #[Route('/comment/new/{id}', name: 'app_comment_new_a', methods: ['GET', 'POST'])]
public function new(Request $request, CommentRepository $commentRepository,ArticleRepository $articleRepository,Article $article): Response
{
    //$articleId=$_POST["idarticle"];
    $article=$articleRepository->findOneBy(['id' => $article->getId()]);
    $comment = new Comment();
    $comment->setArticle($article);
    $comment->setDatecmt(new \DateTime('now'));
    $comment->setNblike(0);
    $comment->setNbdislike(0);
    $form = $this->createForm(CommentType::class, $comment);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager = $this->getDoctrine()->getManager();
        $censor = new CensorWords;
            $langs = array('fr','it','en-us','en-uk','es');
            $badwords = $censor->setDictionary($langs);
            $censor->setReplaceChar("*");
            $string = $censor->censorString($comment->getContent());
            $comment->setContent($string['clean']);
       // $entityManager->persist($comment);
        //$entityManager->flush();
//$flashy->success('Commentaire ajouté!', 'http://your-awesome-link.com');


            $commentRepository->save($comment, true);
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
    public function edit(Request $request, Comment $commentaire, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CommentType::class, $commentaire);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
    
            return $this->redirectToRoute('app_article_show', ['id' => $commentaire->getArticle()->getId()], Response::HTTP_SEE_OTHER);
        }
    
        return $this->renderForm('comment/edit.html.twig', [
            'commentaire' => $commentaire,
            'form' => $form,
        ]);
    }


#[Route('/{id}', name: 'app_comment_delete', methods: ['POST','DELETE'])]
public function delete(Request $request, Comment $comment, EntityManagerInterface $entityManager): Response
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
    return $this->redirectToRoute('app_article_show', ['id' => $articleId]);
}


#[Route('/like/{id}', name: 'app_commentaire_like', )]
    public function like(Request $request, Comment $id, FlashyNotifier $flashy,EntityManagerInterface $entityManager): Response
    {        $dislikeee=$entityManager->getRepository(Dislike::class)->findoneBy(['commentaire'=>$id->getId(),'userr'=>1]);
        $likeee=$entityManager->getRepository(Like::class)->findBy(['commentaire'=>$id->getId(),'userr'=>1]);
    if($likeee==null){

        $id->setNblike($id->getNblike()+1);
        $like = new Like();
        $like->setCommentaire($id);
        $user=$entityManager->getRepository(User::class)->find(1);
        $like->setUserr($user);
        $entityManager->persist($like);
        if($dislikeee!=null)
        {
            $id->setNbdislike($id->getNbdislike()-1);
            $entityManager->remove($dislikeee);

        }
        $entityManager->flush();}
    else
    {
        dump($likeee);
        $flashy->error('vous avez deja liker ce commentaire', 'http://your-awesome-link.com');
    }
    return $this->redirectToRoute('app_article_show',['id'=> $id->getArticle()->getId()]);       


    }

    #[Route('/dislike/{id}', name: 'app_commentaire_dislike', )]

    public function dislike(Request $request, Comment $id, FlashyNotifier $flashy,EntityManagerInterface $entityManager): Response
    {        $likeee=$entityManager->getRepository(Like::class)->findoneBy(['commentaire'=>$id->getId(),'userr'=>1]);
        $dislikeee=$entityManager->getRepository(Dislike::class)->findBy(['commentaire'=>$id->getId(),'userr'=>1]);
    if($dislikeee==null){

        $id->setNbdislike($id->getNbdislike()+1);
        $dislike = new Dislike();
        $dislike->setCommentaire($id);
        $user=$entityManager->getRepository(User::class)->find(1);
        $dislike->setUserr($user);
        $entityManager->persist($dislike);
        if($likeee!=null)
        {
            $id->setNblike($id->getNblike()-1);
            $entityManager->remove($likeee);

        }
        $entityManager->flush();}
    else
    {
        dump($dislikeee);
        $flashy->error('vous avez deja disliker ce commentaire', 'http://your-awesome-link.com');
    }
    return $this->redirectToRoute('app_article_show',['id'=> $id->getArticle()->getId()]);       


    }

}

    


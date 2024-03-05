<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Rating;
use App\Entity\User;
use App\Form\ProductType;
use App\Form\RatingFormType;
use App\Repository\CategorieRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use HTTP_Request2;
use HTTP_Request2_Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\RatingRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping\Id;

#[Route('/product')]
class ProductController extends AbstractController
{
    #[Route('/aa', name: 'app_product_indexaa', methods: ['GET'])]
    public function index(ProductRepository $productRepository, CategorieRepository $categorieRepository, PaginatorInterface $paginator, Request $request, CacheInterface $cache): Response
    {
        $limit = 6;


        $page = (int)$request->query->get("page", 1);


        $filters = $request->get("categories");

        $produits = $productRepository->getPaginatedProduits($page, $limit, $filters);

        $total = $productRepository->getTotalProduits($filters);



        $pagination = $paginator->paginate(
            $produits,
            $request->query->getInt('page', 1),
            6
        );


        /* if ($request->get('ajax')) {
            return new JsonResponse([
                'content' => $this->renderView('product/backk.html.twig', compact('produits', 'total', 'limit', 'page'))
            ]);
        }*/
        $categories = $cache->get('app_categorie_index', function (ItemInterface $item) use ($categorieRepository) {
            $item->expiresAfter(3600);

            return $categorieRepository->findAll();
        });

        $categorieRepository;
        $categories = $categorieRepository->findAll();




        return $this->render('product/backk.html.twig', [

            'products' => $productRepository->findAll(),
            'pagination' => $pagination,
            'categories' => $categories,
        ]);
        // return $this->render('product/index.html.twig', [
        //     'products' => $productRepository->findAll(),
        // ]);
    }
    #[Route('/', name: 'app_product_index', methods: ['GET'])]
    public function indexaa(ProductRepository $productRepository): Response
    {
        return $this->render('product/index.html.twig', [
            'products' => $productRepository->findAll(),
        ]);
    }


    #[Route('/topproducts', name: 'app_product_topproducts', methods: ['GET'])]
    public function topproducts(ProductRepository $productRepository): Response
    {
        return $this->render('product/index.html.twig', [
            'products' => $productRepository->FindBestALLTimeSellers(),
        ]);
    }
    #[Route('/lowerprice', name: 'app_product_lowerprice', methods: ['GET'])]
    public function lowerprice(ProductRepository $productRepository): Response
    {
        return $this->render('product/index.html.twig', [
            'products' => $productRepository->FilterbyPriceUp(),
        ]);
    }

    #[Route('/upperprice', name: 'app_product_upperprice', methods: ['GET'])]
    public function upperprice(ProductRepository $productRepository): Response
    {
        return $this->render('product/index.html.twig', [
            'products' => $productRepository->FilterbyPriceDown(),
        ]);
    }

    #[Route('/new', name: 'app_product_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);





        if ($form->isSubmitted() && $form->isValid()) {
            /* image metier*/
            $pictureFile = $form->get('image')->getData();
            if ($pictureFile) {
                $pictureFileName = uniqid() . '.' . $pictureFile->guessExtension();
                $pictureFile->move(
                    $this->getParameter('picture_directory_products'),
                    $pictureFileName
                );
                $pictureFileName = 'images/products/' . $pictureFileName;
                $product->setimage($pictureFileName);
            } else
                $product->setimage("images/products/NoImageFound.png");

            /*
            $request = new HTTP_Request2();
            $request->setUrl('https://3g48gv.api.infobip.com/sms/2/text/advanced');
            $request->setMethod(HTTP_Request2::METHOD_POST);
            $request->setConfig(array(
                'follow_redirects' => TRUE
            ));
            $request->setHeader(array(
                'Authorization' => 'App d1f3f0b56d3c1a7bd6553724408201e4-059d2158-cd04-4c06-9fbb-ffd144aeebdb',
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ));
            $request->setBody('{"messages":[{"destinations":[{"to":"21650406305"}],"from":"ServiceSMS","text":"Hello,\\n\\nThis is a test message from JoySpirt We invite you to check out website for our new product. Have a nice day!"}]}');
            try {
                $response = $request->send();
                if ($response->getStatus() == 200) {
                } else {
                    echo 'Unexpected HTTP status: ' . $response->getStatus() . ' ' .
                        $response->getReasonPhrase();
                }
            } catch (HTTP_Request2_Exception $e) {
                echo 'Error: ' . $e->getMessage();
            }

*/

            $entityManager->persist($product);

            $entityManager->flush();

            return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('product/new.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_product_show', methods: ['GET', 'POST'])]
    public function show(Product $product, Request $request, EntityManagerInterface $entityManager, RatingRepository $ratingRepository, UserRepository $userRepository, ProductRepository $productRepository, $id): Response
    {
        $rating = new Rating();
        $user = $userRepository->find(1);
        $foundProduct = $productRepository->find($id);
        $form = $this->createForm(RatingFormType::class, $rating);
        $form->handleRequest($request);
        $AveRating = $ratingRepository->findByAveRatingById($id);
        if ($form->isSubmitted() && $form->isValid()) {
            $currentDate = new \DateTime();
            $rating->setRatingDate($currentDate);

            $rating->setUser($user);
            $rating->setProduct($foundProduct);


            $ratingRepository->save($rating, true);


            return $this->renderForm('product/show.html.twig', [
                'product' => $product,
                'form' => $form,
                'AvregeRating' => $AveRating[0][1],


            ]);
        }





        return $this->renderForm('product/show.html.twig', [
            'product' => $product,
            'form' => $form,
            'AvregeRating' => $AveRating[0][1],
        ]);
    }

    #[Route('/{id}/edit', name: 'app_product_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Product $product, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $pictureFile = $form->get('image')->getData();
            if ($pictureFile) {
                $pictureFileName = uniqid() . '.' . $pictureFile->guessExtension();
                $pictureFile->move(
                    $this->getParameter('picture_directory_products'),
                    $pictureFileName
                );
                $pictureFileName = 'images/products/' . $pictureFileName;
                $product->setimage($pictureFileName);
            }



            $entityManager->flush();

            return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('product/edit.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_product_delete', methods: ['POST'])]
    public function delete(Request $request, Product $product, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $product->getId(), $request->request->get('_token'))) {
            $entityManager->remove($product);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('/product/aa/paginated', name: 'products_paginated_list', methods: ['GET'])]
    public function paginatedList(Request $request, ProductRepository $productRepository): JsonResponse
    {
        // Récupérer le numéro de page à partir des paramètres de requête
        $page = $request->query->getInt('page', 1);
        // Récupérer le nombre d'éléments par page à partir des paramètres de requête
        $limit = $request->query->getInt('limit', 10);

        // Calculer l'offset en fonction du numéro de page et du nombre d'éléments par page
        $offset = ($page - 1) * $limit;

        // Récupérer les utilisateurs paginés depuis la base de données
        $paginatedProducts = $productRepository->findPaginated($limit, $offset);

        // Renvoyer les utilisateurs paginés sous forme de réponse JSON
        return $this->json($paginatedProducts);
    }
    #[Route('/rechercheproduct', name: 'app_product_search' )]
    public function search(Request $request, EntityManagerInterface $entityManager )
    {
        $searchTerm = $request->query->get('q');

        // If no search term is provided, fetch all items
        if (empty($searchTerm)) {
            $queryBuilder = $entityManager->createQueryBuilder();
            $queryBuilder
                ->select('p')
                ->from(Product::class, 'p');
        } else {
            // If search term is provided, filter the results by the search term
            $queryBuilder = $entityManager->createQueryBuilder();
            $queryBuilder
                ->select('p')
                ->from(Product::class, 'p')
                ->where('p.name LIKE :searchTerm')
                ->setParameter('searchTerm', '%' . $searchTerm . '%');
        }

        $products = $queryBuilder->getQuery()->getResult();
        return $this->render('product/index.html.twig', [
            'products' => $products,
            'searchTerm' => $searchTerm
        ]);
    }
}

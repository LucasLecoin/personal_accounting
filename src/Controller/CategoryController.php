<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: ['fr' => 'catégories', 'en' => 'categories'], name: 'app_category_')]
class CategoryController extends AbstractController
{
    #[Route(path: ['fr' => '/', 'en' => '/'], name: 'index', methods: [Request::METHOD_GET, Request::METHOD_POST])]
    public function index(Request $request, EntityManagerInterface $em, CategoryRepository $categoryRepository): Response
    {
        $category = new Category();
        $formAdd = $this->createForm(CategoryType::class, $category, [
            'method' => Request::METHOD_POST
        ])->handleRequest($request);
        if ($formAdd->isSubmitted() && $formAdd->isValid()) {
            $em->persist($category);
            $em->flush();

//            $this->addFlash('notice', 'flash_message.category_added');
            return $this->redirectToRoute('app_category_index');
        }

        return $this->render('app/category/index.html.twig', [
            'formAdd' => $formAdd,
            'data' => $categoryRepository->getBalancedData(),
        ]);
    }

    #[Route(path: ['fr' => '/{id}', 'en' => '/{id}'], name: 'show', methods: [Request::METHOD_GET])]
    public function show(Category $category) : Response
    {
        return $this->render('app/category/show.html.twig', [
            'category' => $category
        ]);
    }
}
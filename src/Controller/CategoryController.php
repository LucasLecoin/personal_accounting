<?php

namespace App\Controller;

use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: ['fr' => 'catégories', 'en' => 'categories'], name: 'app_category_')]
class CategoryController extends AbstractController
{
    #[Route(path: ['fr' => '/', 'en' => '/'], name: 'index', methods: [Request::METHOD_GET, Request::METHOD_POST])]
    public function index(): Response
    {
        return $this->render('app/category/index.html.twig', [
            //TODO
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
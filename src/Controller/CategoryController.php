<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: ['fr' => 'catégories', 'en' => 'categories'], name: 'app_category_')]
class CategoryController extends AbstractController
{

}
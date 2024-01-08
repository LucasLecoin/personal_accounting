<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/expenses', name: 'app_expense_')]
class ExpenseController extends AbstractController
{
    #[Route(path: '/', name: 'index', methods: [Request::METHOD_GET, Request::METHOD_POST])]
    public function index(Request $request): Response
    {
        return $this->render('app/expense/index.html.twig', [
            //TODO
        ]);
    }
}
<?php

namespace App\Controller;

use App\Entity\Expense;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: ['fr' => 'dépenses', 'en' => 'expenses'], name: 'app_expense_')]
class ExpenseController extends AbstractController
{
    #[Route(path: ['fr' => '/', 'en' => '/'], name: 'index', methods: [Request::METHOD_GET, Request::METHOD_POST])]
    public function index(): Response
    {
        return $this->render('app/expense/index.html.twig', [
            //TODO
        ]);
    }

    #[Route(path: ['fr' => '/{id}', 'en' => '/{id}'], name: 'show', methods: [Request::METHOD_GET])]
    public function show(Expense $expense) : Response
    {
        return $this->render('app/expense/show.html.twig', [
            'expense' => $expense
        ]);
    }
}
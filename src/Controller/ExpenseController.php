<?php

namespace App\Controller;

use App\Entity\Expense;
use App\Form\ExpenseType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: ['fr' => 'dépenses', 'en' => 'expenses'], name: 'app_expense_')]
class ExpenseController extends AbstractController
{
    #[Route(path: ['fr' => '/', 'en' => '/'], name: 'index', methods: [Request::METHOD_GET, Request::METHOD_POST])]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $expense = new Expense();
        $formAdd = $this->createForm(ExpenseType::class, $expense, [
            'method' => Request::METHOD_POST
        ])->handleRequest($request);
        if ($formAdd->isSubmitted() && $formAdd->isValid()) {
            $em->persist($expense);
            $em->flush();

//            $this->addFlash('notice', 'flash_message.expense_added');
            return $this->redirectToRoute('app_expense_index');
        }

        return $this->render('app/expense/index.html.twig', [
            'formAdd' => $formAdd
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
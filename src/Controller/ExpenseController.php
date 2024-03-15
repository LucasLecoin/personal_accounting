<?php

namespace App\Controller;

use App\Entity\Expense;
use App\Filters\FilterExpense;
use App\Form\ExpenseType;
use App\Form\Filters\FilterExpenseType;
use App\Repository\ExpenseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: ['fr' => 'dépenses', 'en' => 'expenses'], name: 'app_expense_')]
class ExpenseController extends AbstractController
{
    #[Route(path: ['fr' => '/', 'en' => '/'], name: 'index', methods: [Request::METHOD_GET, Request::METHOD_POST])]
    public function index(Request $request, EntityManagerInterface $em, ExpenseRepository $expenseRepository): Response
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

        $filter = new FilterExpense();
        $formFilter = $this->createForm(FilterExpenseType::class, $filter, [
            'method' => Request::METHOD_GET
        ]);
        $formFilter->handleRequest($request);

        return $this->render('app/expense/index.html.twig', [
            'formAdd' => $formAdd,
            'data' => $expenseRepository->getTableData($filter)
        ]);
    }

    #[Route(path: ['fr' => '/{id}', 'en' => '/{id}'], name: 'show', methods: [Request::METHOD_GET])]
    public function show(Expense $expense): Response
    {
        return $this->render('app/expense/show.html.twig', [
            'expense' => $expense
        ]);
    }
}
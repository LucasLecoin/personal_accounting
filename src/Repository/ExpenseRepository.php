<?php

namespace App\Repository;

use App\Entity\Expense;
use App\Filters\FilterExpense;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Expense>
 *
 * @method Expense|null find($id, $lockMode = null, $lockVersion = null)
 * @method Expense|null findOneBy(array $criteria, array $orderBy = null)
 * @method Expense[]    findAll()
 * @method Expense[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExpenseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Expense::class);
    }

    /**
     * @return Expense[]
     */
    public function getTableData(FilterExpense $filter): array
    {
        $qb = $this->createQueryBuilder('e')
            ->orderBy('e.date', 'DESC');
        return $this->applyFilterExpense($qb, $filter)
            ->getQuery()->getResult();
    }

    private function applyFilterExpense(QueryBuilder $qb, FilterExpense $filter): QueryBuilder
    {
        if($filter->getStart()) {
            $qb ->andWhere('e.date >= :start')
                ->setParameter('start', $filter->getStart());
        }
        if($filter->getEnd()) {
            $qb ->andWhere('e.date <= :end')
                ->setParameter('end', $filter->getEnd());
        }
        if($filter->getCategory()) {
            $qb ->andWhere('e.category = :category')
                ->setParameter('category', $filter->getCategory());
        }
        if($filter->getMinAmount()) {
            $qb ->andWhere('e.amount >= :minAmount')
                ->setParameter('minAmount', $filter->getMinAmount());
        }
        if($filter->getMaxAmount()) {
            $qb ->andWhere('e.amount <= :maxAmount')
                ->setParameter('maxAmount', $filter->getMaxAmount());
        }
        if(!is_null($filter->getIsCash())) {
            $qb->andWhere('e.isCash '. ($filter->getIsCash() ? '':'!') . '= 1');
        }
        if(!is_null($filter->getIsGain())) {
            $qb->andWhere('e.isGain '. ($filter->getIsGain() ? '':'!') . '= 1');
        }

        return $qb;
    }
}

<?php

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Category>
 *
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }
    private function isGainFilter(bool $isGain): string {
        return 'e.isGain '. ($isGain ? '':'!') . '= 1';
    }

    /**
     * return array of [title => c.title, totalAmount => SUM(e.amount)] <string,int>
     */
    public function queryExpenseGain(bool $isGain = false): array {
        return $this->createQueryBuilder('c')
            ->leftJoin('c.expenses', 'e')
            ->select('c.name, SUM(e.amount) as totalAmount')
            ->where($this->isGainFilter($isGain))
            ->orWhere('e IS NULL')
            ->orderBy('totalAmount', 'DESC')
            ->addOrderBy('c.name', 'ASC')
            ->groupBy('c.name')
            ->getQuery()
            ->getResult();
    }

    public function getBalancedData(): array {
        $case = "CASE WHEN e.isGain = 1 THEN 1 ELSE -1 END";
        $results = $this->createQueryBuilder('c')
            ->leftJoin('c.expenses', 'e')
            ->select("c.name, SUM($case * e.amount ) as totalAmount")
            ->orderBy('totalAmount', 'DESC')
            ->addOrderBy('c.name', 'ASC')
            ->groupBy('c.name')
            ->getQuery()
            ->getResult();
        return array_map(function($item) {
            $item['balance'] =
                $item['totalAmount'] < 0 ? 'expense' :
                ($item['totalAmount'] > 0 ? 'gain' : 'neutral');
            return $item;
        }, $results);
    }
}

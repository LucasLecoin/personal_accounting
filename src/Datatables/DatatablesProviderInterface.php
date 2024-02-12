<?php

declare(strict_types=1);

namespace App\Datatables;

use Doctrine\ORM\QueryBuilder;

interface DatatablesProviderInterface
{
    public function findForDatatables(array $search = [], array $filter = [], array $orderBy = [], int $limit = 10, int $offset = 0, array $params = []): iterable;

    public function countForDatatables(array $search = [], array $filter = [], array $params = []): int;

    public function findForExport(array $search = [], array $filter = [], array $orderBy = []): iterable;

    public function count(array $params);

    public function searchQuery(QueryBuilder $qb, array $search);

    public function filterQuery(QueryBuilder $qb, array $filter);

    public function orderQuery(QueryBuilder $qb, array $orderBy);
}

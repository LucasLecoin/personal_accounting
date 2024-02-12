<?php

declare(strict_types=1);

namespace App\Datatables;

use Symfony\Component\HttpFoundation\Request;

class DatatablesRequestHandler
{
    public function __construct(private DatatablesFormatter $formatter)
    {
    }

    public function getPayload(Request $request, DatatablesProviderInterface $provider): array
    {
        $orderBy = $this->getOrderBy($request);
        $search = $this->getSearch($request); // Will generate LIKE in SQL -> firstName LIKE '%test%'
        $filter = $this->getFilter($request); // Will generate = in SQL -> firstName = 'test'
        $limit = $request->query->getInt('length', 10);
        $offset = $request->query->getInt('start', 0);

        $data = $provider->findForDatatables(
            $search,
            $filter,
            $orderBy,
            $limit,
            $offset,
            [
                'user' => $request->query->get('user', ''),
                'user_id' => $request->query->get('user_id', '')
            ]
        );
        $count = $provider->countForDatatables(
            $search,
            $filter,
            [
                'user' => $request->query->get('user', ''),
                'user_id' => $request->query->get('user_id', '')
            ]
        );

        return [
            'data' => $this->formatter->format($request, $data),
            'draw' => $request->query->getInt('draw', 1),
            'recordsTotal' => $provider->count([]),
            'recordsFiltered' => $count,
        ];
    }

    public function getForExport(Request $request, DatatablesProviderInterface $provider, $additionnalFilter = []): iterable
    {
        $orderBy = $this->getOrderBy($request);
        $search = $this->getSearch($request); // Will generate LIKE in SQL -> firstName LIKE '%test%'
        $filter = $this->getFilter($request); // Will generate = in SQL -> firstName = 'test'
        $filter = array_merge($filter, $additionnalFilter);

        return $provider->findForExport($search, $filter, $orderBy);
    }

    public function getOrderBy(Request $request): array
    {
        $columns = $request->query->all()['columns'] ?? [];
        $orders = $request->query->all()['order'] ?? [];
        $orderBy = [];
        foreach ($orders as $order) {
            $columnIndex = $order['column'];
            if (isset($columns[$columnIndex]) && 'true' === $columns[$columnIndex]['orderable']) {
                $orderBy[$columns[$columnIndex]['name']] = $order['dir'];
            }
        }

        return $orderBy;
    }

    public function getSearch(Request $request): array
    {
        $columns = $request->query->all()['columns'] ?? [];
        $query = $request->query->all()['search'] ?? [];

        if (null === $query || empty($query['value'])) {
            return [];
        }

        $search = [];
        foreach ($columns as $column) {
            if ('true' === $column['searchable']) {
                $search[$column['name']] = $query['value'];
            }
        }

        return $search;
    }

    public function getFilter(Request $request): array
    {
        $columns = $request->query->all()['columns'] ?? [];

        $filter = [];
        foreach ($columns as $column) {
            if ('' !== $column['search']['value']) {
                $filter[$column['name']] = $column['search']['value'];
            }
        }

        return $filter;
    }
}

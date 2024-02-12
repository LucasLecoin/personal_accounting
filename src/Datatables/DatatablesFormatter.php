<?php

declare(strict_types=1);

namespace App\Datatables;

use Symfony\Component\HttpFoundation\Request;

class DatatablesFormatter
{
    public function format(Request $request, iterable $data = []): array
    {
        $results = [];
        foreach ($data as $datum) {
            $result = [];
            $columns = $request->query->all()['columns'] ?? [];
            foreach ($columns as $column) {
                if (\array_key_exists($column['name'], $datum)) {
                    $result[] = $this->formatValue($datum[$column['name']]);
                } else {
                    $result[] = '';
                }
            }
            $results[] = $result;
        }

        return $results;
    }

    private function formatValue($value): ?string
    {
        if ($value instanceof \DateTime) {
            return $value->format('d/m/Y');
        }

        if (null === $value) {
            return '-';
        }

        if (\is_bool($value)) {
            return true === $value ? '1' : '0';
        }

        if(\is_numeric($value)) {
            return strval($value);
        }

        return $value;
    }
}

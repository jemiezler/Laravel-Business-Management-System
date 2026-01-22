<?php

namespace App\Builders;

use App\Connections\DummyConnection;
use App\Models\Employee;
use Illuminate\Database\Connection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\File;

class JsonOnlyBuilder extends Builder
{
    protected array|null $fallbackData = null;
    protected array $customWheres = [];

    public function __construct($model)
    {
        /** @var Connection $connection */
        $connection = new DummyConnection();

        $query = new QueryBuilder(
            $connection,
            $connection->getQueryGrammar(),
            $connection->getPostProcessor()
        );

        parent::__construct($query);
        $this->setModel($model);
    }

    public function where($column, $operator = null, $value = null, $boolean = 'and')
    {
        if (is_callable($column)) {
            return $this;
        }

        if (func_num_args() === 2) {
            $value = $operator;
            $operator = '=';
        }

        $this->customWheres[] = compact('column', 'operator', 'value');

        return $this;
    }

    public function whereIn($column, $values, $boolean = 'and', $not = false)
    {
        $this->customWheres[] = [
            'column'   => $column,
            'operator' => $not ? 'not_in' : 'in',
            'value'    => is_array($values) ? $values : $values->toArray(),
        ];

        return $this;
    }

    public function get($columns = ['*'])
    {
        $data  = $this->getFallbackData();
        $table = $this->model->getTable();

        if (!isset($data[$table])) {
            return $this->model->newCollection();
        }

        $items = collect($data[$table]);

        // Apply where filters
        foreach ($this->customWheres as $where) {
            $items = $items->filter(function ($item) use ($where) {
                $itemValue = $item[$where['column']] ?? null;
                $value = $where['value'];

                return match ($where['operator']) {
                    '='      => $itemValue == $value,
                    '!='     => $itemValue != $value,
                    '>'      => $itemValue > $value,
                    '<'      => $itemValue < $value,
                    '>='     => $itemValue >= $value,
                    '<='     => $itemValue <= $value,
                    'in'     => in_array($itemValue, (array) $value, true),
                    'not_in' => !in_array($itemValue, (array) $value, true),
                    'like'   => preg_match(
                        '/^' . str_replace('%', '.*', preg_quote($value, '/')) . '$/i',
                        (string) $itemValue
                    ),
                    default  => $itemValue == $value,
                };
            });
        }

        // 🔥 Hydrate employees once
        $employees = collect($data['employees'] ?? [])
            ->map(fn($e) => new Employee($e))
            ->keyBy('id');

        return $this->model->newCollection(
            $items->map(function ($item) use ($employees) {
                $model = $this->model->newFromBuilder((array) $item);

                // 🔥 GENERIC employee hydration
                if (array_key_exists('employee_id', $item)) {
                    $employee = $employees->get($item['employee_id']);

                    if ($employee) {
                        $model->setRelation('employee', $employee);
                    }
                }

                return $model;
            })->values()->all()
        );
    }

    public function first($columns = ['*'])
    {
        return $this->get($columns)->first();
    }

    public function count($columns = '*')
    {
        return $this->get()->count();
    }

    public function sum($column)
    {
        return $this->get()->sum($column);
    }

    public function paginate($perPage = null, $columns = ['*'], $pageName = 'page', $page = null, $total = null)
    {
        $perPage ??= $this->model->getPerPage();
        $page ??= Paginator::resolveCurrentPage($pageName);
        $total ??= $this->count();

        $items = $this->get()
            ->slice(($page - 1) * $perPage, $perPage)
            ->values();

        return new LengthAwarePaginator(
            $items,
            $total,
            $perPage,
            $page,
            [
                'path'     => Paginator::resolveCurrentPath(),
                'pageName' => $pageName,
            ]
        );
    }

    protected function getFallbackData(): array
    {
        if ($this->fallbackData !== null) {
            return $this->fallbackData;
        }

        $path = database_path('fallback_data.json');

        return $this->fallbackData = File::exists($path)
            ? json_decode(File::get($path), true) ?? []
            : [];
    }

    public function value($column)
    {
        return $this->first([$column])?->{$column};
    }

    public function exists()
    {
        return $this->count() > 0;
    }
}

<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class JsonFallbackBuilder extends Builder
{
    protected $fallbackData = null;

    /**
     * Execute the query as a "select" statement.
     *
     * @param  array  $columns
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function get($columns = ['*'])
    {
        $tableName = $this->model->getTable();
        $data = $this->getFallbackData();

        if (isset($data[$tableName])) {
            $items = collect($data[$tableName]);

            // Simple filtering based on 'where' clauses
            foreach ($this->query->wheres as $where) {
                if ($where['type'] === 'Basic') {
                    $column = $where['column'];
                    $value = $where['value'];
                    $operator = $where['operator'];

                    $items = $items->filter(function ($item) use ($column, $value, $operator) {
                        $itemValue = $item[$column] ?? null;

                        switch ($operator) {
                            case '=':
                                return $itemValue == $value;
                            case '!=':
                                return $itemValue != $value;
                            case '>':
                                return $itemValue > $value;
                            case '<':
                                return $itemValue < $value;
                            case '>=':
                                return $itemValue >= $value;
                            case '<=':
                                return $itemValue <= $value;
                            default:
                                return $itemValue == $value;
                        }
                    });
                }
            }

            return $this->model->newCollection(
                $items->map(fn($item) => $this->model->newFromBuilder((array) $item))->all()
            );
        }

        return $this->model->newCollection();
    }

    /**
     * Execute the query and get the first result.
     *
     * @param  array  $columns
     * @return \Illuminate\Database\Eloquent\Model|static|null
     */
    public function first($columns = ['*'])
    {
        return $this->get($columns)->first();
    }

    /**
     * Retrieve the fallback data from the JSON file.
     *
     * @return array
     */
    protected function getFallbackData()
    {
        if ($this->fallbackData === null) {
            $path = database_path('fallback_data.json');
            if (File::exists($path)) {
                $this->fallbackData = json_decode(File::get($path), true);
            } else {
                $this->fallbackData = [];
            }
        }

        return $this->fallbackData;
    }

    /**
     * Handle aggregate calls (count, sum, etc.)
     *
     * @param  string  $function
     * @param  array  $columns
     * @return mixed
     */
    public function aggregate($function, $columns = ['*'])
    {
        $data = $this->getFallbackData();
        $tableName = $this->model->getTable();

        if (isset($data[$tableName])) {
            $items = collect($data[$tableName]);

            // Simple filtering based on 'where' clauses
            foreach ($this->query->wheres as $where) {
                if ($where['type'] === 'Basic') {
                    $column = $where['column'];
                    $value = $where['value'];
                    $operator = $where['operator'];

                    $items = $items->filter(function ($item) use ($column, $value, $operator) {
                        $itemValue = $item[$column] ?? null;

                        switch ($operator) {
                            case '=':
                                return $itemValue == $value;
                            case '!=':
                                return $itemValue != $value;
                            case '>':
                                return $itemValue > $value;
                            case '<':
                                return $itemValue < $value;
                            case '>=':
                                return $itemValue >= $value;
                            case '<=':
                                return $itemValue <= $value;
                            default:
                                return $itemValue == $value;
                        }
                    });
                }
            }

            $column = $columns[0] === '*' ? null : $columns[0];

            switch ($function) {
                case 'count':
                    return $items->count();
                case 'sum':
                    return $items->sum($column);
                case 'avg':
                    return $items->avg($column);
                case 'min':
                    return $items->min($column);
                case 'max':
                    return $items->max($column);
                default:
                    return $items->$function($column);
            }
        }

        return 0;
    }
}

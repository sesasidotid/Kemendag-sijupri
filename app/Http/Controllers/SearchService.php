<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;

trait SearchService
{
    private $page = 1;
    private $limit = 10;
    private $conds = [];
    private $attrs = [];
    private $ordrs = [];

    private $query = null;

    public function setAttr($attrs)
    {
        if (is_array($attrs) && count($attrs) > 0) {
            $this->attrs = array_merge($this->attrs, $attrs);
        }
        return $this;
    }

    public function setCond($conds)
    {
        if (is_array($conds) && count($conds) > 0) {
            $this->conds = array_merge($this->conds, $conds);
        }
        return $this;
    }

    public function setOrdr($ordrs)
    {
        if (is_array($ordrs) && count($ordrs) > 0) {
            $this->ordrs = array_merge($this->ordrs, $ordrs);
        }
        return $this;
    }

    public function findSearchPaginate(array $data)
    {
        $this->page =  $data['page'] ?? $this->page;
        $this->limit =  $data['limit'] ?? $this->limit;
        $this->attrs = $data['attr'] ?? $this->attrs;
        $this->conds = $data['cond'] ?? $this->conds;
        $this->ordrs = $data['ordrs'] ?? $this->ordrs;

        return $this->run($data)->createpaginate();
    }

    public function run($data = null)
    {
        $this->page =  $data['page'] ?? $this->page;
        $this->limit =  $data['limit'] ?? $this->limit;
        $this->query = $this->query();
        $this->query->where(function ($query) {
            foreach ($this->attrs as $column => $value) {
                $this->searchHelper($query, $column, $value);
            }
        });

        return $this;
    }

    public function createpaginate()
    {
        if (count($this->ordrs) > 0) {
            foreach ($this->ordrs as $key => $value) {
                $this->query->orderBy($key, $value);
            }
        }
        return $this->query->paginate($this->limit, ['*'], 'page', $this->page);
    }

    private function searchHelper($query, $column, $value)
    {
        if ($value !== null && $value !== '' && !in_array($column, ['num_rows', 'page'])) {
            if (is_array($value)) {
                foreach ($value as $associate_column => $associate_value) {
                    if ($associate_value !== null && $associate_value !== '') {
                        $query->whereHas($column, function (Builder $query) use ($column, $associate_column, $associate_value) {
                            if (is_array($associate_value))
                                $this->searchHelper($query, $associate_column, $associate_value);
                            else if (isset($this->conds[$column][$associate_column])) {
                                $query->where($associate_column, $this->conds[$column][$associate_column], $associate_value == 'null' ? null : ($associate_value == 'true' ? true : ($associate_value == 'false' ? false : $associate_value)));
                            } else
                                $query->Where($associate_column, 'LIKE', '%' . $associate_value . '%');
                        });
                    }
                }
            } else {
                if (isset($this->conds[$column])) {
                    $query->where($column, $this->conds[$column], $value == 'null' ? null : ($value == 'true' ? true : ($value == 'false' ? false : $value)));
                } else
                    $query->Where($column, 'LIKE', '%' . $value . '%');
            }
        }
    }
}

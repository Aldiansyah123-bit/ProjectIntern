<?php

namespace App\Filters\vendor;

use App\Filters\vendor\Eloquent\Relations\BelongsTo;
use App\Filters\vendor\Eloquent\Relations\BelongsToOne;
use App\Filters\vendor\Eloquent\Relations\BelongsToThrough;
use App\Filters\vendor\AtnicFilter as Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Query\Expression;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

/**
 * BaseFilter Filter
 */
class BaseFilter extends Filter
{
    /** @var array Array Findable */
    protected $findables = [];

    /**
     * @param $name
     * @param $arguments
     * @return Builder
     */
    public function __call($name, $arguments)
    {
        if (str_contains($name, '__')) {
            $operations = explode('__', $name, 2);
            return $this->{$operations[1]}($operations[0], $arguments[0]);
        }
        if (isset($this->findables[$name]) || in_array($name, $this->findables)) {
            return $this->find("{$name}={$arguments[0]}");
        }
        else parent::__call($name, $arguments);
    }


    /**
     * Fetch all relevant filters from the request.
     *
     * @return array
     */
    protected function getFilters()
    {
        $filters = array_diff(get_class_methods($this), [
            '__construct', '__call', 'apply', 'getFilters', 'getSearchables', 'getFindables', 'getSortables', 'buildSearch', 'buildSql',
            'ne', 'lt', 'lte', 'gt', 'gte', 'between', 'in', 'null'
        ]);
        $filters = array_merge($filters, array_map(function ($searchable, $key) {
            return is_array($searchable) ? $key : $searchable;
        }, $this->searchables, array_keys($this->searchables)));
        $filters = array_merge($filters, array_map(function ($findable, $key) {
            return is_array($findable) ? $key : $findable;
        }, $this->findables, array_keys($this->findables)));
        $filters = array_merge($filters, array_filter($this->request->keys(), function ($key) {
            return str_contains($key, '__');
        }));

        return Arr::only($this->request->query(), array_unique($filters));
    }

    /**
     * @return array
     */
    public function getFindables()
    {
        return $this->findables;
    }

    /**
     * Select
     * @param $values
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function select($values)
    {
        $selects = explode(',', $values);
        $selects = collect($selects)->flatMap(function ($select) {
            if (str_contains($select, '.')) return [ $select => $select ];
            $column = $this->builder->qualifyColumn($select);
            if ($column instanceof Expression) return [ $select => DB::raw("{$column} as $select") ];
            else return [ $select => $column ];
        })->toArray();
        $validator = validator([ 'values' => $selects ], [ 'values' => 'array|min:1' ]);
        return $this->builder->when(!$validator->fails(), function (Builder $query) use($selects) {
            $query->select($selects);
        });
    }

    /**
     * Sort
     * @param  mixed $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function sort($value)
    {
        $sorted_columns = $value ? explode('|', $value) : [];
        $sorts = [];
        foreach ($sorted_columns as $key => $sorted_column) {
            $sort = $sorted_column ? explode(',', $sorted_column) : [];
            if (!is_array($sort) || !in_array($sort[0], $this->sortables)) continue;
            array_push($sorts, [
                'column' => $sort[0],
                'dir' => isset($sort[1]) ? $sort[1] : 'asc'
            ]);
        }
        $validator = validator([ 'sorts' => $sorts ], [
            'sorts.*.column' => 'in:'.implode(',', $this->sortables),
            'sorts.*.dir' => 'in:asc,desc'
        ]);
        return $this->builder->when(!$validator->fails(), function (Builder $query) use($sorts) {
            if (empty($query->getQuery()->columns)) $query->select([ '*' => $query->qualifyColumn('*') ]);
            foreach ($sorts as $sort) {
                if (str_contains($sort['column'], '.')) {
                    $join = explode('.', $sort['column']);
                    /** @var Relation $relation */
                    $relation = Relation::noConstraints(function () use($query, $join) {
                        return $query->getModel()->{$join[0]}();
                    });
                    $related = clone $relation->getModel();
                    $related->setTable('t'.strtolower(str_random(8)));
                    if (in_array(class_basename($relation), [ 'BelongsTo', 'MorphTo', 'HasOne', 'MorphOne', 'BelongsToOne', 'BelongsToThrough' ])) {
                        if (in_array(class_basename($relation), [ 'BelongsTo', 'MorphTo' ])) {
                            /** @var BelongsTo|MorphTo $relation */
                            $query->leftJoin(DB::raw('('. $this->buildSql($relation->getQuery()).') as '.$related->getTable()), "{$related->getTable()}.{$relation->getOwnerKey()}", $relation->getQualifiedForeignKey());
                        } elseif (in_array(class_basename($relation), [ 'HasOne', 'MorphOne' ])) {
                            /** @var HasOne|MorphOne $relation */
                            $query->leftJoin(DB::raw('('.$this->buildSql($relation->getQuery()).') as '.$related->getTable()), "{$related->getTable()}.{$relation->getForeignKeyName()}", $relation->getQualifiedParentKeyName());
                        } elseif (in_array(class_basename($relation), [ 'BelongsToOne' ])) {
                            /** @var BelongsToOne $relation */
                            $query->leftJoin(DB::raw('('.$this->buildSql($relation->getQuery()->addSelect([
                                    '*' => $relation->getRelated()->qualifyColumn('*') ,
                                    $relation->getForeignPivotKeyName() => $relation->getTable().'.'.$relation->getForeignPivotKeyName()
                                ])).') as '.$related->getTable()), $relation->getQualifiedParentKeyName(), $related->getTable().'.'.$relation->getForeignPivotKeyName());
                        } elseif (in_array(class_basename($relation), [ 'BelongsToThrough' ])) {
                            /** @var BelongsToThrough $relation */
                            $query->leftJoin(DB::raw('('.$this->buildSql($relation->getQuery()->addSelect([
                                    '*' => $relation->getRelated()->qualifyColumn('*') ,
                                    $relation->getSecondKeyName() => $relation->getQualifiedSecondOwnerKeyName().' as '.$relation->getSecondKeyName()
                                ])).') as '.$related->getTable()), $relation->getQualifiedFarKeyName(), $related->getTable().'.'.explode('.', $relation->getQualifiedForeignKeyName())[1]);
                        }
                        $query->orderByRaw("({$related->getTable()}.{$join[1]} IS NULL)");
                        $query->orderBy($related->getTable().'.'.$join[1], $sort['dir']);
                        $query->addSelect(DB::raw($related->getTable().'.'.$join[1].' as '.$join[0].'_'.$join[1]));
                    }
                } else {
                    if (!($query->qualifyColumn($sort['column']) instanceof Expression))
                        $query->orderByRaw("({$query->qualifyColumn($sort['column'])} IS NULL)");
                    $query->orderBy($query->qualifyColumn($sort['column']), $sort['dir']);
                }
            }
        });
    }

    /**
     * @param $value
     * @return mixed
     */
    public function updated_after($value)
    {
        $validator = validator([ 'value' => $value ], [ 'value' => 'date' ]);
        return $this->builder->when(!$validator->fails(), function (Builder $query) use($value) {
            $query->where($query->qualifyColumn($query->getModel()->getUpdatedAtColumn()), '>=', $value);
        });
    }

    /**
     * Sort
     * @param  mixed $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function find($value)
    {
        $finded_columns = $value ? explode('|', $value) : [];
        $finds = [];
        foreach ($finded_columns as $key => $finded_column) {
            $find = $finded_column ? explode('=', $finded_column) : [];
            if (!is_array($find) || !in_array($find[0], $this->findables) || !$find[1]) continue;
            array_push($finds, [
                'column' => $find[0],
                'values' => explode(',', $find[1])
            ]);
        }
        $validator = validator(['finds' => $finds], [
            'finds.*.column' => 'in:' . implode(',', $this->findables),
            'finds.*.values' => 'array'
        ]);
        return $this->builder->when(!$validator->fails(), function (Builder $query) use($finds) {
            foreach ($finds as $find) {
                $query->whereIn($query->qualifyColumn($find['column']), $find['values']);
            };
        });
    }

    /**
     * @param $values
     * @return mixed
     */
    public function not_null($values)
    {
        $columns = explode(',', $values);
        $validator = validator([ 'value' => $columns ], [ 'value.*' => 'string' ]);
        return $this->builder->when(!$validator->fails(), function (Builder $query) use($columns) {
            foreach ($columns as $column) {
                $query->whereNotNull($column);
            }
        });
    }

    /**
     * With
     * @param  mixed $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function appends($value)
    {
        $appends = explode(',', $value);
        $validator = validator([ 'values' => $appends ], [ 'values.*' => 'string' ]);
        $appends = collect($appends)->mapWithKeys(function ($append) {
            return [ $append => DB::raw("NULL as $append") ];
        })->toArray();
        return $this->builder->when(!$validator->fails(), function (Builder $query) use($appends) {
            if (is_null($query->getQuery()->columns)) $query->select([ '*' => $query->qualifyColumn('*') ]);
            $query->addSelect($appends);
        });
    }

    /**
     * With
     * @param  mixed $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function with($value)
    {
        $withs = explode(',', $value);
        $model = $this->builder->getModel();
        $withs = collect($withs)->filter(function ($with) use($model) {
            if (str_contains($with, '.')) return method_exists($model, explode('.', $with)[0]) && ($model->{explode('.', $with)[0]}() instanceof Relation);
            return method_exists($model, $with) && $model->{$with}() instanceof Relation;
        })->toArray();
        return $this->builder->when(count($withs), function (Builder $query) use($withs) {
            $query->with($withs);
        });
    }

    public function without_global_scopes($value)
    {
        $validator = validator([ 'value' => $value ], [ 'value' => 'boolean' ]);
        return $this->builder->when(!$validator->fails(), function (Builder $query) use($value) {
            if ($value) $query->withoutGlobalScopes()->byUser();
        });
    }

    /**
     * @param string $column
     * @param string $value
     * @return Builder
     */
    public function ne($column, $value)
    {
        return $this->builder->where($this->builder->qualifyColumn($column), '<>', $value);
    }

    /**
     * @param string $column
     * @param string $value
     * @return Builder
     */
    public function lt($column, $value)
    {
        return $this->builder->where($this->builder->qualifyColumn($column), '<', $value);
    }

    /**
     * @param string $column
     * @param string $value
     * @return Builder
     */
    public function lte($column, $value)
    {
        return $this->builder->where($this->builder->qualifyColumn($column), '<=', $value);
    }

    /**
     * @param string $column
     * @param string $value
     * @return Builder
     */
    public function gt($column, $value)
    {
        return $this->builder->where($this->builder->qualifyColumn($column), '>', $value);
    }

    /**
     * @param string $column
     * @param string $value
     * @return Builder
     */
    public function gte($column, $value)
    {
        return $this->builder->where($this->builder->qualifyColumn($column), '>=', $value);
    }

    /**
     * @param string $column
     * @param string $value
     * @return Builder
     */
    public function between($column, $value)
    {
        return $this->builder->whereBetween($this->builder->qualifyColumn($column), explode(',', $value));
    }

    /**
     * @param string $column
     * @param string $value
     * @return Builder
     */
    public function in($column, $value)
    {
        return $this->builder->whereIn($this->builder->qualifyColumn($column), explode(',', $value));
    }

    /**
     * @param string $column
     * @return Builder
     */
    public function null($column)
    {
        return $this->builder->whereNull($this->builder->qualifyColumn($column));
    }
}

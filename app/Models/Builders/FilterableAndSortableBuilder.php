<?php

namespace App\Models\Builders;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use function PHPUnit\Framework\isNan;

class FilterableAndSortableBuilder extends Builder
{
    public const ID_IDENTIFIER = "#";

    public function initializeFilters()
    {
        $term = request() ? request()->get("search", "") : "";
        $isIdSearch = !empty($term) && Str::startsWith($term, self::ID_IDENTIFIER);
        $idParam = str_replace(self::ID_IDENTIFIER, "",  $term);

        if($isIdSearch && !empty($idParam))
        {
            $id =  intval($idParam); //TODO:INTVAL return 0 when string is not numeric

            $this->where("id", $id);
            return $this->filterByRequest();
        }

        //TODO:THIS OVERRIDES USER SELECT
        $this->generateJoins()
            ->orderByRequest()
            ->searchByRequest()
            ->filterByRequest()->select($this->model->getTable().".*");

        return $this;
    }

    private function generateJoins()
    {
        if(!request() || !(request()->has("sort") || request()->has("search"))) return $this;

        $columns =  $this->model->getSearchableColumns();

        collect($columns)->filter(function ($value) {
            return Str::contains($value, ".");
        })->each(function ($value) {
            $this->recoursiveJoin($value);
        });

        return $this;
    }

    private $as = [];

    private $joined = [

    ];

    private function recoursiveJoin($column, $lastRel = null, $childEager = null)
    {
        $explode = explode(".", $column, 2);
        $model = !empty($childEager) ? $childEager->getRelated() : $this->model;
        $eager = !empty($childEager) ? $model->{$explode[0]}() : $model->{$explode[0]}();
        $as = $lastRel ? $lastRel . "_" . $eager->getRelated()->getTable() : $eager->getRelated()->getTable();
        $this->as[$explode[0]] = $as;
        if(!(isset($this->joined[$eager->getRelated()->getTable()]) && $this->joined[$eager->getRelated()->getTable()] == $eager->getForeignKeyName()))
        {
            $this->joined[$eager->getRelated()->getTable()] = $eager->getForeignKeyName();
            $this->leftJoin(
                $eager->getRelated()->getTable() . ($as != $eager->getRelated()->getTable() ? " as $as" : ""),
                $model->getTable() . "." . $eager->getForeignKeyName(),
                "=",
                $as . "." . $eager->getOwnerKeyName()
            );
        }
        if (count($explode) > 1 && Str::contains($explode[1], ".")) {
            $this->recoursiveJoin($explode[1], $as, $eager);
        }
    }

    public function searchByRequest($term = null): Builder
    {
        $term = empty($term) ? request()->get("search", null) : $term;
        if (empty($term)) {
            return $this;
        }

        $searchableColumns = $this->model->getSearchableColumns();

        $c = collect($searchableColumns)->map(function ($value) {
            return $this->getSortColumn($value);
        });

        $raw = implode(",", $c->toArray());

        $this->where(DB::raw("CONCAT($raw)"), $this->getCaseInsensitiveLikeKeyWord(), "%" . $term . "%");
        return $this;
    }

    public function filterByRequest(array $attr = []): Builder
    {
        if (request()) {
            request()->request->add($attr);
        }

        $request = request() ? request() : collect($attr);

        if (empty($this->model) || empty($request)) return $this;

        $filterableColumns = $this->model->getFilterableColumns();

        collect($request->all())->each(function ($value, $key) use ($filterableColumns) {
            if (isset($filterableColumns[$key])) {
                $relationshipRoute = explode(".", $filterableColumns[$key]);

                if (count($relationshipRoute) >= 2) {

                    $this->whereRelation(
                        implode(".", array_slice($relationshipRoute, 0, count($relationshipRoute) - 1)),
                        $relationshipRoute[count($relationshipRoute) - 1],
                        $value
                    );
                }
            }
        });
        return $this;
    }

    public function orderByRequest(string $column = null, bool $desc = false)
    {
        $column = request() ? request()->get("sort", null) : $column;
        $desc = request() ? request()->get("direction", "asc") == "desc" : $desc;

        $sortableColumns = $this->model->getSortableColumns();
        if (empty($column) || !array_key_exists($column, $sortableColumns)) return $this;

        $col = $this->getSortColumn($sortableColumns[$column]);

        $this->reorder($col, $desc ? "desc" : "asc");

        return $this;
    }

    private function getSortColumn($column) {
        $name = $column;

        if(!Str::contains($name, "."))
        {
            return $this->model->getTable() . "." . $name;
        }

        foreach($this->as as $key => $value)
        {
            $name = str_replace($key.".", $value.".", $name);
        }

        $count = count(explode(".", $name));
        $ex = explode(".", $name, $count - 1);

        return $ex[count($ex) - 1];
    }

    private function getCaseInsensitiveLikeKeyWord()
    {
        switch ($this->getCurrentDatabaseConnection()) {
            case "pgsql":
                return "ilike";
            default:
                return "like";
        }
    }

    private function getCurrentDatabaseConnection()
    {
        $driver = config("database.connections")[env("DB_CONNECTION")]["driver"];

        return $driver;
    }
}

<?php

namespace App\Models\Traits;

use App\Models\Builders\FilterableAndSortableBuilder;

trait FilterableAndSortable {

    /**
     * Defines the columns to search when the "search" query param is used
     */
    abstract function getSearchableColumns() : array;

    /**
     * Defines the columns to filter on search params
     */
    abstract function getFilterableColumns() : array;

    /**
     * Defines the columns that are sortable by using the "sort" and "direction" param
     */
    abstract function getSortableColumns() : array;

    public function newEloquentBuilder($query)
    {
        return new FilterableAndSortableBuilder($query);
    }

    public function newModelQuery() {
        return parent::newModelQuery()->initializeFilters();
    }
}

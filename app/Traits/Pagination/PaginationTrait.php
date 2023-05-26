<?php

namespace App\Traits\Pagination;

use App\Pagination\CustomPaginator;

trait PaginationTrait
{
    public function paginateCollection($collection, $resourceClass): CustomPaginator
    {
        return new CustomPaginator($resourceClass::collection($collection),
            $collection->total(),
            $collection->perPage(),
            $collection->currentPage());
    }
}

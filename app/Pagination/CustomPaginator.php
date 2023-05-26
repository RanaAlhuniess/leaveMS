<?php

namespace App\Pagination;

use Illuminate\Pagination\LengthAwarePaginator;

class CustomPaginator extends LengthAwarePaginator
{
    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'data' => $this->items->toArray(),
            'currentPage' => $this->currentPage(),
            'perPage' => $this->perPage(),
            'totalPages' => $this->lastPage(),
        ];
    }
}

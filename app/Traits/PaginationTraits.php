<?php

namespace App\Traits;

trait PaginationTraits
{
    public function getOffset(int $page,int $perPage): int
    {
        return ($page - 1) * $perPage;
    }

    public function getPaginationFormate(int $total,int $perPage, int $page): array
    {
        $pagination = [
            'total' => $total,
            'per_page' => $perPage,
            'current_page' => $page,
            'last_page' => ceil($total / $perPage),
        ];
        return $pagination;
    }

    public function getDataWithPagination($data, $pagination): array
    {
        $data = [ 
            'data' => $data,
            'pagination' => $pagination
        ];
        return $data;
    }
}

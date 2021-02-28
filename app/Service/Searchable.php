<?php

namespace App\Service;

trait Searchable
{
    public static function search($search, $columns)
    {
        $query = self::query();
        foreach ($columns as $key => $column) {
            $key == 0 ? $query = $query->where($column, 'like', "%{$search}%") : $query = $query->orWhere($column, 'like', "%{$search}%");
        }

        return $query->get();
    }
}

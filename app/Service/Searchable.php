<?php

namespace App\Service;

trait Searchable
{
    public static function search($search, $columns)
    {
        if (! isset($search) | ! isset($columns) | empty($search)) {
            return;
        }

        if (is_array($columns)) {
            $query = self::query();
            foreach ($columns as $key => $column) {
                $key == 0 ? $query = $query->where($column, 'like', "%{$search}%") : $query = $query->orWhere($column, 'like', "%{$search}%");
            }

            return $query->get();
        }
        if (is_string($columns)) {
            return self::where($columns, 'like', "%{$search}%")->get();
        }
    }
}

<?php

namespace App;

trait Searchable
{
    public static function search($search, $columns)
    {
        return $search;
        // if ($search) {
        //     return $this->query()->where($columns, 'like', "%{$search}%")->get();
        // }
    }
}

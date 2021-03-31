<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

abstract class TableComponent extends Component
{
    use WithPagination;

    // Pagination:
    protected $paginationTheme = 'bootstrap';
    public $paginate = 10;

    public function sortBy($field)
    {
        if ($this->sortDirection == 'desc') {
            $this->sortDirection = 'asc';
        } else {
            $this->sortDirection = 'desc';
        }

        return $this->sortBy = $field;
    }
}

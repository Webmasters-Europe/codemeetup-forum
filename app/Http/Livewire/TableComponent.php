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

    public function dispatchBrowserEventByAction($action)
    {
        switch ($action) {
            case 'delete':
                $this->dispatchBrowserEvent('openDeleteModelInstanceModal');
                break;
            case 'update':
                $this->dispatchBrowserEvent('openUpdateModelInstanceModal');
                break;
            case 'restore':
                $this->dispatchBrowserEvent('openRestoreModelInstanceModal');
                break;
        }
    }

    public function resetPaginatorPage()
    {
        $this->resetPage();
    }
}

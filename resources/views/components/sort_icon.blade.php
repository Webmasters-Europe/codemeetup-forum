@if ($sortBy !== $field)
    <i class="fas fa-arrows-alt-v text-secondary"></i>
@elseif ($sortDirection == 'asc')
    <i class="fas fa-sort-alpha-up"></i>
@else
    <i class="fas fa-sort-alpha-down"></i>
@endif
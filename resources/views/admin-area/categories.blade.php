@extends('layouts.app')

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin-area.dashboard') }}">Admin Area</a></li>
            <li class="breadcrumb-item active" aria-current="page">Categories</li>
        </ol>
    </nav>

    <h1>Administrate Categories</h1>
    
    @livewire('admin-area-categories') 

@endsection

@push('scripts')
<script>
    window.addEventListener('openAddCategoryModal', event => {
        $('#addCategoryModal').modal('show');
    });
    window.addEventListener('closeAddCategoryModal', event => {
        $('#addCategoryModal').modal('hide');
    });
    window.addEventListener('openUpdateModal', event => {
        $('#updateCategoryModal').modal('show');
    });
    window.addEventListener('closeUpdateModal', event => {
        $('#updateCategoryModal').modal('hide');
    });
    window.addEventListener('openDeleteModal', event => {
        $('#deleteCategoryModal').modal('show');
    });
    window.addEventListener('closeDeleteModal', event => {
        $('#deleteCategoryModal').modal('hide');
    });
    window.addEventListener('openRestoreModal', event => {
        $('#restoreCategoryModal').modal('show');
    });
    window.addEventListener('closeRestoreModal', event => {
        $('#restoreCategoryModal').modal('hide');
    });
</script>
@endpush

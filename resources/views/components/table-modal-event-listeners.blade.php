@push('scripts')
    <script>
        window.addEventListener('openAddModelInstanceModal', event => {
            $('#addModelInstanceModal').modal('show');
        });
        window.addEventListener('closeAddModelInstanceModal', event => {
            $('#addModelInstanceModal').modal('hide');
        });
        window.addEventListener('openUpdateModelInstanceModal', event => {
            $('#updateModelInstanceModal').modal('show');
        });
        window.addEventListener('closeUpdateModelInstanceModal', event => {
            $('#updateModelInstanceModal').modal('hide');
        });
        window.addEventListener('openDeleteModelInstanceModal', event => {
            $('#deleteModelInstanceModal').modal('show');
        });
        window.addEventListener('closeDeleteModelInstanceModal', event => {
            $('#deleteModelInstanceModal').modal('hide');
        });
        window.addEventListener('openRestoreModelInstanceModal', event => {
            $('#restoreModelInstanceModal').modal('show');
        });
        window.addEventListener('closeRestoreModelInstanceModal', event => {
            $('#restoreModelInstanceModal').modal('hide');
        });
    </script>
@endpush

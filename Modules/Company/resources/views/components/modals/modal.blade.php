<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="exampleModalScrollable2" data-bs-keyboard="false" aria-hidden="true">
    <!-- Scrollable modal -->
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="staticBackdropLabel2">Conferma Eliminazione</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Sei sicuro di voler eliminare questa azienda?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"
                    data-bs-dismiss="modal">Annulla</button>
                <button type="button" class="btn btn-primary" wire:click="delete">Conferma</button>
            </div>
        </div>
    </div>
</div>

@script
    <script>
        $wire.on('open-modal', () => {
            new bootstrap.Modal(document.getElementById('confirmDeleteModal')).show();
        });
    </script>
@endscript
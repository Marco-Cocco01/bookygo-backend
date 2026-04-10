<div class="row">
    <div class="col-xl-12">
        <select  wire:model ="selectedRule" wire:change="getModulesByRules" class="form-select" aria-label="Default select example">
        <option selected>Selezionare un ruolo dall'elenco</option>
        @foreach($rules as $key => $value)
            <option value="{{ $key }}">{{ $value }}</option>
        @endforeach
        
    </select>
    </div>
    <div class="col-xl-12">
        <div class="table-responsive mt-3">
            <table class="table text-nowrap table-bordered">
                <thead>
                    <tr >
                        <th scope="col">Modulo</th>
                        <th class="text-center" scope="col">Lettura</th>
                        <th class="text-center" scope="col">Scrittura</th>
                        <th class="text-center" scope="col">Modifica</th>
                        <th class="text-center" scope="col">Eliminazione</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ( $modules as $index => $module )
                        <tr>
                            <td >{{ $module['name'] }}</td>
                            <td class="text-center"><input type="checkbox" wire:model="modules.{{ $index }}.can_view" class="form-check-input" wire:change="updatePermission({{ $module['id'] }}, 'can_view', $event.target.checked)" {{ $module['can_view'] ? 'checked' : '' }}></td>
                            <td class="text-center"><input type="checkbox" wire:model="modules.{{ $index }}.can_add" class="form-check-input" wire:change="updatePermission({{ $module['id'] }}, 'can_add', $event.target.checked)" {{ $module['can_add'] ? 'checked' : '' }}></td>
                            <td class="text-center"><input type="checkbox" wire:model="modules.{{ $index }}.can_edit" class="form-check-input" wire:change="updatePermission({{ $module['id'] }}, 'can_edit', $event.target.checked)" {{ $module['can_edit'] ? 'checked' : '' }}></td>
                            <td class="text-center"><input type="checkbox" wire:model="modules.{{ $index }}.can_delete" class="form-check-input" wire:change="updatePermission({{ $module['id'] }}, 'can_delete', $event.target.checked)" {{ $module['can_delete'] ? 'checked' : '' }}></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@script
<script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('notify', (event) => {
            toastr.success(event.message, 'Successo', {
                positionClass: 'toast-top-right',
                timeOut: 3000,
            });
        });
    });
</script>
@endscript
<div class="row">
    <select  wire:model.live="selectedRule" class="form-select" aria-label="Default select example">
        <option selected>Selezionare un ruolo dall'elenco</option>
        @foreach($types as $type)
            <option value="{{ $type->id }}">{{ $type->name }}</option>
        @endforeach
    </select>
    <div class="row">
        @foreach ($modules as $module)
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mt-3">
                <div class="card custom-card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            {{ $module->title }}
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-check">
                            <input
                                type="checkbox"
                                class="form-check-input"
                                id="{{ $module->title }}"
                                wire:click="createOrUpdateRule({{ $module->id }}, $event.target.checked)"
                                @foreach($modulesActive as $value)
                                    @if($value == $module->id)
                                        @checked(true)
                                    @endif
                                @endforeach
                                @if($selectedRule == 0)
                                    disabled
                                @endif
                            />
                            <label class="form-check-label" for="{{ $module->title }}">
                                {{ $module->description }}
                            </label>
                        </div>
                    </div>
                    <div class="card-footer d-none border-top-0">

                    </div>
                </div>
            </div>
        @endforeach
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
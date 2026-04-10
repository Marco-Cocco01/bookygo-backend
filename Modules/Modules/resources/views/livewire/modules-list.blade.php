<div class="row">
    @foreach ($modules as $module)
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
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
                            id="flexCheckDefault"
                            @checked($modulesState[$module->id])
                            wire:click="toggleModule({{ $module->id }})"
                        />
                        <label class="form-check-label" for="flexCheckDefault">
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
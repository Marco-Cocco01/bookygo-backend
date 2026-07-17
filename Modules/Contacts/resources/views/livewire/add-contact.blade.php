<div>
    <div class="row">
        <div class="col-lg-12">
            <!-- Errore/i -->
            @if(session('message_ok'))
                <div class="alert alert-success" role="alert">
                    {{session('message_ok')}}
                </div>
            @endif
            @if(session('message_ko'))
                <div class="alert alert-danger" role="alert">
                    {{session('message_ko')}}
                </div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger pt-3" role="alert">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li style="list-style-type: square;">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">
                        &nbsp;
                    </div>
                </div>
                <div class="card-body">
                   <form wire:submit=@if($is_edit)"update" @else "add" @endif>
                        <div class="row mb-3">
                            <label for="inputEmail3" class="col-sm-2 col-form-label">Nominativo</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control w-50" id="name" wire:model="name" placeholder="Mario Rossi">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="email" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10">
                                <input type="email" class="form-control w-50" id="email" wire:model="email">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="phone" class="col-sm-2 col-form-label">Telefono</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control w-50" id="phone" wire:model="phone">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="cell" class="col-sm-2 col-form-label">Cellulare</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control w-50" id="cell" wire:model="cell">
                            </div>
                        </div>
                        <div class="row mb-3">   
                            <label for="inputPassword3" class="col-sm-2 col-form-label">Attivo</label>
                            <div class="col-sm-10">
                                <div class="custom-toggle-switch d-flex align-items-center mt-2">
                                    <input id="is_active"  type="checkbox" wire:model="is_active" @if('checked') value="1" @endif  @if($is_active) checked @endif>
                                    <label for="is_active" class="label-primary"></label><span class="ms-3">&nbsp;</span>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mt-5">@if($is_edit)Modifica @else Aggiungi @endif Contatto </button>
                        @if($is_edit)
                            <button type="button" class="btn btn-secondary mt-5" wire:loading.attr="disabled" wire:click.prevent="addToBusinessUnit">Invita in Business Unit</button>
                         @endif
                    </form>
                    
                </div class="card-footer text-left">
                     &nbsp;
                </div>
        </div>
    </div>      <!-- End:: row-2 -->
</div>
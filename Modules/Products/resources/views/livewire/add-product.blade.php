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
                            <label for="inputEmail3" class="col-sm-2 col-form-label">Nome</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control w-50" id="name" wire:model="name" >
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="email" class="col-sm-2 col-form-label">Descrizione</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control w-50" id="description" wire:model="description">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="phone" class="col-sm-2 col-form-label">Tassazione in %</label>
                            <div class="col-sm-10">
                                <input type="number" min="1" step="0.01" class="form-control w-50" id="phone" wire:model="amount">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="cell" class="col-sm-2 col-form-label">Associata a</label>
                            <div class="col-sm-10">
                                <select class="form-select w-50" aria-label="Default select example" wire:model="id_client_type">
                                    <option value="" >Seleziona</option>
                                    @foreach($client_types as $key => $val)
                                        <option value="{{ $key }}">{{ $val }}</option>
                                    @endforeach
                                </select>
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
                        <button type="submit" class="btn btn-primary mt-5">@if($is_edit)Modifica @else Aggiungi @endif Tassa </button>
                    </form>
                    
                </div class="card-footer text-left">
                     &nbsp;
                </div>
        </div>
    </div>      <!-- End:: row-2 -->
</div>
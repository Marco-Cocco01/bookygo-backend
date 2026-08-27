<div>
  
    <div class="row">
        <div class="col-xl-12">
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
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">
                        <a class="btn btn-primary" href="{{ route('service.add') }}">Aggiungi Nuovo</a> 
                    </div>
                </div>
                <div class="card-body">
                    <table id="responsiveDataTable" class="table table-bordered text-wrap w-100">
                        <thead>
                            <tr>
                                <th scope="col">Nominativo</th>    
                                <th scope="col">Categoria servizio</th>
                                <th scope="col">Attivo</th>
                                <th scope="col">Data Creazione</th>
                                <th scope="col">Data Modifica</th>
                                <th scope="col">Azioni</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($services as $key => $val)
                            <tr>
                                <td>{{ $val['title'] }}</td>
                                <td>{{ $val->parent->title }}</td>
                                <td>@if($val['is_active']) <i class="bi bi-check2"></i> @else <i class="bi bi-x"></i> @endif</td>
                                <td>{{ $val['created_at'] }}</td>
                                <td>{{ $val['updated_at'] }}</td>
                                <td>
                                    <a href="{{ route('service.edit', $val['id']) }}"><i class="bi bi-pencil-square"></i></a>
                                    <a href="#" wire:click="confirmDelete({{ $val['id'] }})" class="ms-2"><i class="bi bi-trash"></i></a>
                                </td>
                            </tr>
                            @empty
                                <tr class="text-center">
                                    <td colspan="7" class="text-center">Nessun servizio trovato</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-5">
                        {{ $services->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>      <!-- End:: row-2 -->
      @include('company::components.modals.modal')
</div>

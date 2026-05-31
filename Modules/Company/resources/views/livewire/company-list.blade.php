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
                        <a class="btn btn-primary" href="{{route('company.add')}}">Aggiungi Nuovo</a> 
                    </div>
                </div>
                <div class="card-body">
                    <table id="responsiveDataTable" class="table table-bordered text-wrap w-100">
                        <thead>
                            <tr>
                                <th scope="col">Ragione Sociale</th>
                                <th scope="col">Nominativo</th>    
                                <th scope="col">Citt&Agrave;</th>
                                <th scope="col">PIVA</th>
                                <th scope="col">CF</th>
                                <th scope="col">Tipologia</th>
                                <th scope="col">Delegato</th>
                                <th scope="col">Telefono</th>
                                <th scope="col">E-mail</th>
                                <th scope="col">Attiva</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($companies as $key => $val)
                            <tr>
                                <td>{{ $val['name'] }}</td>
                                <td>{{ $val['owner'] }}</td>
                                <td>{{ $val['city'] }}</td>
                                <td>{{ $val['piva'] }}</td>
                                <td>{{ $val['cf'] }}</td>
                                <td>{{ $val['id_type'] }}</td>
                                <td></td>
                                <td>{{ $val['phone'] }}</td>
                                <td>{{ $val['email'] }}</td>
                                <td>@if($val['is_active']) <i class="bi bi-check2"></i> @else <i class="bi bi-x"></i> @endif</td>
                                <td>
                                    <a href="{{ route('company.edit', $val['id']) }}"><i class="bi bi-pencil-square"></i></a>
                                    <a href="#" wire:click="confirmDelete({{ $val['id'] }})" class="ms-2"><i class="bi bi-trash"></i></a>
                                </td>
                            </tr>
                            @empty
                                <td colspan="11" class="text-center">Nessun azienda trovata</td>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>      <!-- End:: row-2 -->
      @include('company::components.modals.modal')
</div>

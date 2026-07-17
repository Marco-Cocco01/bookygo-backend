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
                        <a class="btn btn-primary" href="{{route('categories.add')}}">Aggiungi Nuovo</a> 
                    </div>
                </div>
                <div class="card-body">
                    <table id="responsiveDataTable" class="table table-bordered text-wrap w-100">
                        <thead>
                            <tr>
                                <th scope="col">Titolo</th>
                                <th scope="col">N° Sottocategoria</th>    
                                <th scope="col">Prodotti</th>
                                <th scope="col">Attiva</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($subcategories as $category)
                            <tr>
                                <td>{{ $category->name }}</td>
                                <td><a href="">{{ $category->subcount }}</a></td>
                                <td>{{ $category->products }}</td>
                                <td>@if($category->is_active) <i class="bi bi-check2"></i> @else <i class="bi bi-x"></i> @endif</td>
                                <td>
                                    <a href="{{ route('categories.edit', ['id' => $category->id]) }}"><i class="bi bi-pencil-square"></i></a>
                                    <a href="#" wire:click="confirmDelete({{ $category->id }})" class="ms-2"><i class="bi bi-trash"></i></a>
                                </td>
                            </tr>
                            @empty
                                <td colspan="11" class="text-center">Nessuna sottocategoria trovata</td>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end">
                            {{ $subcategories->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>      <!-- End:: row-2 -->
      @include('company::components.modals.modal')
</div>

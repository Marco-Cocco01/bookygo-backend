<?php
namespace Modules\Categories\app\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Categories;

class CategoriesList extends Component
{
    use WithPagination;

    public $id;
    public $name;
    public $id_parent;
    public $is_active;
    

    public function confirmDelete($id)
    {
        $this->id = $id;
        $this->dispatchBrowserEvent('confirm-delete');
    }

    public function render()
    {

        return view('categories::livewire.categories-list',
            [
                'categories' => Categories::roots()->withCount('children')->paginate(10)
            ]
        );
    }
}
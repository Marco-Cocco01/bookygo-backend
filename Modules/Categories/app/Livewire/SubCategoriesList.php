<?php
namespace Modules\Categories\app\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Categories;

class SubCategoriesList extends Component
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

    public function render(int $id_parent = null)
    {

        return view('categories::livewire.sub-categories-list',
            [
                'categories' => Categories::withCount('children')->where('id_parent', $id_parent)->paginate(10)
            ]
        
        );
    }
}
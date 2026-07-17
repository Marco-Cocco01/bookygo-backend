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
    
    public function mount(int $id_parent)
    {
        $this->id_parent = $id_parent;
    }

    public function confirmDelete($id)
    {
        $this->id = $id;
        $this->dispatchBrowserEvent('confirm-delete');
    }

    public function render()
    {
        $category = Categories::find($this->id_parent);
        return view('categories::livewire.sub-categories-list',
            [
                'subcategories' => $category->children()->paginate(6),
                'subcount' => $category->children()->count(),
            ]
        );
    }
}
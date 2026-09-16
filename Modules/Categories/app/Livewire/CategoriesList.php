<?php
namespace Modules\Categories\app\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Categories;
use App\Models\User;
use App\Models\UserTypes;
use App\Models\UsersRights;

class CategoriesList extends Component
{
    use WithPagination;

    public $id;
    public $name;
    public $id_parent;
    public $is_active;

    public function getUserRights()
    {
        $user = auth()->user();
        $rights = [];

        if ($user) {
            $rights = [
                'can_create' => $user->can('create', Categories::class),
                'can_edit' => $user->can('update', Categories::class),
                'can_delete' => $user->can('delete', Categories::class),
            ];
        }

        return $rights;
    }
    

    public function confirmDelete($id)
    {
        $this->id = $id;
        $this->dispatchBrowserEvent('confirm-delete');
    }

    public function render()
    {
        $rights = $this->getUserRights();
        \Log::info('User Rights: ' . json_encode($rights));

        return view('categories::livewire.categories-list',
            [
                'rights' => $rights,
                'categories' => Categories::roots()->withCount('children')->paginate(10)
            ]
        );
    }
}
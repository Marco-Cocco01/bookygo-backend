<?php

namespace Modules\Permissions\app\Livewire;

use Livewire\Component;
use App\Models\Modules;
use App\Models\UsersRights;
use App\Models\UserTypes;
use App\Models\Rules;
use App\Models\Types;


class PermissionList extends Component
{

    public array $modulesState = [];
    public array $userRights = [];
    public string $selectedRule = '';
    public array $rules = [];
    public array $modules = [];

    /*
    * Initialize the component with user rights and module states
    */
    public function mount()
    {
        $this->rules = Types::all()->pluck('name', 'id')->toArray();
        
    }

    /**
     * Get modules by rules
     */
       
    public function getModulesByRules()
    {
        if (!$this->selectedRule) return;

        $modules = Types::find($this->selectedRule)->modules;

        // Prendi un utente del ruolo come riferimento per i permessi
        $userIds = Types::find($this->selectedRule)
            ->users
            ->pluck('id');

        $this->modules = $modules->map(function($module) use ($userIds) {
            $right = UsersRights::where('id_module', $module->id)
                ->whereIn('id_user', $userIds)
                ->first();

            return [
                'id'         => $module->id,
                'name'       => $module->title,
                'can_view'   => $right?->can_view ?? false,
                'can_add'    => $right?->can_add ?? false,
                'can_edit'   => $right?->can_edit ?? false,
                'can_delete' => $right?->can_delete ?? false,
            ];
        })->toArray();

        \Log::info('Modules for selected rule: ', $this->modules);    
    }


    public function updatedModulesState($value, $key)
    {
        Modules::find($key)?->update([
            'is_active' => $value
        ]);
    }

    public function updatePermission(int $moduleId, string $field, bool $value)
    {
        \Log::debug("ID_MODULO ".$moduleId. " - "." FIELD ".$field." - "."VALUE ".$value);
        // Prendi tutti gli utenti del ruolo
        $userIds = Types::find($this->selectedRule)
            ->users
            ->pluck('id');

        \Log::debug($userIds);    

        // Aggiorna il permesso per tutti gli utenti del ruolo
        UsersRights::where('id_module', $moduleId)
            ->whereIn('id_user', $userIds)
            ->update([$field => $value]);

        // Aggiorna array locale
        $this->modules = collect($this->modules)->map(function($module) use ($moduleId, $field, $value) {
            if ($module['id'] === $moduleId) {
                $module[$field] = $value;
            }
            return $module;
        })->toArray();
    }

    public function render()
    {
        return view('permissions::livewire.permission-list');
    }
}
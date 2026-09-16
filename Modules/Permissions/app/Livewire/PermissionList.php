<?php

namespace Modules\Permissions\app\Livewire;

use Livewire\Component;
use App\Models\{Modules, UsersRights, UserTypes, Rules, Types, Permissions};



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
        \Log::info('Modules for selected rule: '.$this->selectedRule, $modules->toArray());

        $userTypes = $this->selectedRule;

        $this->modules = $modules->map(function ($module) use ($userTypes) {
            $right = Permissions::where('id_module', $module->id)
                ->where('id_user_type', '=', $userTypes)
                ->first();    

            \Log::info('Right for module '.$module->id.': ', ['can_view' => $right?->can_view, 'can_add' => $right?->can_add, 'can_edit' => $right?->can_edit, 'can_delete' => $right?->can_delete]);    

            return [
                'id'         => $module->id,
                'name'       => $module->title,
                'can_view'   => $right?->can_view ?? 0,
                'can_add'    => $right?->can_add ?? 0,
                'can_edit'   => $right?->can_edit ?? 0,
                'can_delete' => $right?->can_delete ?? 0,
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

    /**
     * Update permission for a specific module
     */
    public function updatePermission(int $moduleId, string $field, bool $value)
    {
        \Log::debug("ID_MODULO ".$moduleId. " - "." FIELD ".$field." - "."VALUE ".$value);
        
        // Prendi tutti gli utenti del ruolo
        $userIds = Types::find($this->selectedRule)
            ->users
            ->pluck('id');

        \Log::debug($userIds);    

        // Aggiorna la tabella dei permessi {permissions} 
        Permissions::updateOrCreate(
            ['id_module' => $moduleId, 'id_user_type' => $this->selectedRule],
            [$field => $value]
        );

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
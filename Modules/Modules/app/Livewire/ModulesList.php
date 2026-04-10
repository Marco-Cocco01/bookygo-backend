<?php

namespace Modules\Modules\app\Livewire;

use Livewire\Component;
use App\Models\Modules;

class ModulesList extends Component
{

    public array $modulesState = [];

    public function mount()
    {
        $this->modulesState = Modules::all()
            ->mapWithKeys(fn($module) => [$module->id => (int) $module->is_active])
            ->toArray();
    }

    public function updatedModulesState($value, $key)
    {
        Modules::find($key)?->update([
            'is_active' => $value
        ]);
    }

    public function toggleModule(int $id)
    {
        $this->modulesState[$id] = !$this->modulesState[$id];
        
        Modules::find($id)?->update([
            'is_active' => $this->modulesState[$id]
        ]);
    }

    public function render()
    {
        return view('modules::livewire.modules-list', [
            'modules' => Modules::all(),
        ]);
    }
}
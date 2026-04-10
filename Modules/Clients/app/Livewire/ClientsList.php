<?php
namespace Modules\Clients\app\Livewire;

use Livewire\Component;

class ClientsList extends Component
{
    public function render()
    {
        return view('clients::livewire.index');
    }
}
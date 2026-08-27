<?php
namespace Modules\Services\app\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Services;
use App\Models\ServiceTypes;
use App\Models\User;
use App\Models\Categories;

class ServicesList extends Component
{
    use WithPagination;

    public $title;
    public $id_service_type = null;
    public $is_active;
    public $deleteId;
    //public $serviceTypes = [];

    public function mount()
    {
        $userId = auth()->id();
    
    }


    //Eliminazione del contatto, con gestione delle eccezioni per casi di errori o contatto non trovato
    public function delete()
    {
        try {
            Services::findOrFail($this->deleteId)->delete();
             $this->deleteId = null;
            $this->dispatch('close-modal');
            session()->flash('message_ok', 'Servizio eliminato con successo.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            session()->flash('message_ko', 'Servizio non trovato.');
        } catch (\Exception $e) {
            session()->flash('message_ko', 'Impossibile eliminare il Servizio.');
        }

        return redirect()->route('services.index');
    }

    //Modale
    public function confirmDelete($id){
        $this->deleteId = $id;
        $this->dispatch('open-modal');
    }


    public function render()
    {
        return view('services::livewire.services-list', [
            'services' => Services::with('parent')->paginate(10),
        ]);
    }
}
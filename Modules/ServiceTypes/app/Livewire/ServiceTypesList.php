<?php
namespace Modules\ServiceTypes\app\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ServiceTypes;
use App\Models\User;
use App\Models\Categories;

class ServiceTypesList extends Component
{
    use WithPagination;

    public $title;
    public $id_category = null;
    public $active;
    public $deleteId;
    //public $serviceTypes = [];

    public function mount()
    {
        $userId = auth()->id();
        
        /*
        $this->serviceTypes = ServiceTypes::select([
            "id",
            "title", 
            "id_category",
            "is_active",
            "created_at",
            "updated_at"
        ])
        ->with('category:id,name')
        ->paginate(10);
        */
    }


    //Eliminazione del contatto, con gestione delle eccezioni per casi di errori o contatto non trovato
    public function delete()
    {
        try {
            ServiceTypes::findOrFail($this->deleteId)->delete();
             $this->deleteId = null;
            $this->dispatch('close-modal');
            session()->flash('message_ok', 'Tipologia di servizio eliminato con successo.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            session()->flash('message_ko', 'Tipologia di servizio non trovata.');
        } catch (\Exception $e) {
            session()->flash('message_ko', 'Impossibile eliminare la Tipologia di servizio.');
        }

        return redirect()->route('service-types.index');
    }

    //Modale
    public function confirmDelete($id){
        $this->deleteId = $id;
        $this->dispatch('open-modal');
    }


    public function render()
    {
        return view('servicetypes::livewire.servicetypes-list', [
            'serviceTypes' => ServiceTypes::with('category')->paginate(8),
        ]);
    }
}
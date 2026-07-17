<?php
namespace Modules\Fee\app\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Fee;
use App\Models\User;

class FeeList extends Component
{
    use WithPagination;

    public $fees;
    public $deleteId = null;

    public function mount()
    {
        $userId = auth()->id();
        $this->fees = Fee::all()->toArray();
    }


    //Eliminazione del contatto, con gestione delle eccezioni per casi di errori o contatto non trovato
    public function delete(){
        try {
            Fee::findOrFail($this->deleteId)->delete();
             $this->deleteId = null;
            $this->dispatch('close-modal');
            session()->flash('message_ok', 'Tassazione eliminata con successo.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            session()->flash('message_ko', 'Tassazione non trovata.');
        } catch (\Exception $e) {
            session()->flash('message_ko', 'Impossibile eliminare la tassazione.');
        }

        return redirect()->route('fee.index');
    }

    //Modale
    public function confirmDelete($id){
        $this->deleteId = $id;
        $this->dispatch('open-modal');
    }


    public function render()
    {
        return view('fee::livewire.fee-list');
    }
}
<?php
namespace Modules\Contacts\app\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Contacts;
use App\Models\User;
use App\Models\TypeUser;

class ContactsList extends Component
{
    use WithPagination;

    public $contacts;
    //Per la modal di conferma eliminazione, memorizzo l'id dell'azienda da eliminare in una variabile pubblica che viene poi utilizzata nella funzione delete
    public $deleteId = null;

    public function mount()
    {
        $userId = auth()->id();
        $userType = $this->getUserType($userId);

        switch($userType){
            case 1:
                // admin vede tutto
                $this->contacts = Contacts::all()->toArray();
            break;
            case 2:
                // utente normale vede solo le sue
                $this->contacts = Contacts::where('id_owner', $userId)->get()->toArray();
            break;
            default:
                $this->contacts = [];
            break;
        }
    }

    //Verifico se sei admin o business
    public function getUserType(int $idUser) : int
    {
        return $userType = TypeUser::where('id_user', $idUser)->value('id_type');;
    }


    //Eliminazione del contatto, con gestione delle eccezioni per casi di errori o contatto non trovato
    public function delete(){
        try {
            Contacts::findOrFail($this->deleteId)->delete();
             $this->deleteId = null;
            $this->dispatch('close-modal');
            session()->flash('message_ok', 'Contatto eliminato con successo.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            session()->flash('message_ko', 'Contatto non trovato.');
        } catch (\Exception $e) {
            session()->flash('message_ko', 'Impossibile eliminare il contatto.');
        }

        return redirect()->route('contacts.index');
    }

    //Moddale
    public function confirmDelete($id){
        $this->deleteId = $id;
        $this->dispatch('open-modal');
    }


    public function render()
    {
        return view('contacts::livewire.contacts-list');
    }
}
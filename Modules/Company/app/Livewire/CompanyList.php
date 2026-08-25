<?php
namespace Modules\Company\app\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Company;
use App\Models\CompanyType;
use App\Models\TypeUser;
use App\Models\User;

class CompanyList extends Component
{
    use WithPagination;

    public $companies;
    //Per la modal di conferma eliminazione, memorizzo l'id dell'azienda da eliminare in una variabile pubblica che viene poi utilizzata nella funzione delete
    public $deleteId = null;

    public function mount()
    {
        $userId = auth()->id();
        $userType = $this->getUserType($userId);

        switch($userType){
            case 1:
                // admin vede tutto
                $this->companies = Company::all()->toArray();
            break;
            case 2:
                // Business vede solo le sue
                $this->companies = Company::where('id_user', $userId)->get()->toArray();
            break;
            case 4:
                // Business Unit vede quelle del business di riferimento
                $this->companies = Company::where('id_user', $userId)->get()->toArray();
            break;    
            default:
                $this->companies = [];
            break;
        }
    }

    //Verifico se sei admin o business
    public function getUserType(int $idUser) : int
    {
        return $userType = TypeUser::where('id_user', $idUser)->value('id_type');

    }


    //Eliminazione dell'azienda, con gestione delle eccezioni per casi di errori o azienda non trovata
    public function delete(){
        try {
            Company::findOrFail($this->deleteId)->delete();
             $this->deleteId = null;
            $this->dispatch('close-modal');
            session()->flash('message_ok', 'Azienda eliminata con successo.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            session()->flash('message_ko', 'Azienda non trovata.');
        } catch (\Exception $e) {
            session()->flash('message_ko', 'Impossibile eliminare l\'azienda.');
        }

        return redirect()->route('company.index');
    }

    //Moddale
    public function confirmDelete($id){
        $this->deleteId = $id;
        $this->dispatch('open-modal');
    }


    public function render()
    {
        return view('company::livewire.company-list');
    }
}
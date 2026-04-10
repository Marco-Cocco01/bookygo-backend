<?php
namespace Modules\Rules\app\Livewire;

use Livewire\Component;
use App\Models\Rules;
use App\Models\Modules;
use App\Models\Types;
use App\Models\TypeUser;
use App\Models\UsersRights;


class RulesList extends Component
{

    public $types = [];
    public $modules = [];
    public $modulesActive = [];
    public $selectedRule = 0;

    /**
     * Get the list of active modules. 
     * This property is computed and returns all modules that are currently active (is_active = 1).
     */
    public function mount()
    {
        $this->module = Modules::all()->where('is_active', 1);
        $this->loadCheckboxes();
    }

     // Quando la select torna a 0, resetta tutti i checkbox
    public function updatedSelectedRule($value)
    {
       
        if ($value == 0) {
            $this->checkboxes = array_map(fn() => false, $this->checkboxes);
        } else {
            $this->loadCheckboxes();
        }
    }

    
    // Esempio: carica i moduli con il loro stato
    public function loadCheckboxes()
    {
        $this->modulesActive = Rules::all()->where('id_type_user', $this->selectedRule)->pluck('id_module')->toArray();
    }


    // Make a row into user_rights table
    // With permission set to 1 for default (only read)

    public function addModuleToUsersRights(int $idType, int $idModule, int $idParent = null)
    {

        //Seleziono tutti gli utenti del tipo
        //Per ogni utente aggiungo una riga con il nuovo modulo selezionato
        //con tutti i privilegi disabilitati 

        $users = TypeUser::where('id_type', $idType)->pluck('id_user')->toArray();
        //dd($users);
        foreach($users as $idUser){
            \Log::debug(__METHOD__. "-". " ID_USER ". $idUser . "-". " ID_MODULE ".$idModule. "-". " ID_PARENT ".$idParent);
            UsersRights::updateOrCreate(
                [
                    "id_user"   => $idUser,
                    "id_module" => $idModule,
                ],
                [
                    "id_parent" => is_null($idParent) ? $idUser : $idParent,
                    "id_user" => $idUser,
                    "id_module" => $idModule,
                    "can_view" => 1,
                    "can_add" => 0,
                    "can_edit" => 0,
                    "can_delete" => 0,
                ]);
        }
    }


    // Delete a row into user_rights table
    // When module is disabled fot that user's category

    public function deleteModuleToUsersRights(int $idModule) : Bool
    {
        $users = TypeUser::where('id_type', $this->selectedRule)->pluck('id_user');
        $deleted = UsersRights::whereIn('id_user', $users)
               ->where('id_module', $idModule)
               ->delete();

        return $deleted === count($users);
    }



    /**
     * Toggle the status of a type for a given module. 
     * If the type is already associated with the module, it will be removed; otherwise, it will be added.
     * param int $idModule The ID of the module.
     * param int $idType The ID of the type.
     */
    public function createOrUpdateRule($idModule, $checked)
    {
        
        if ($checked) {
            \Log::debug("ID MODULO ".$idModule. "-". "ID_TYPE_USER ". $this->selectedRule );
            Rules::updateOrCreate(
                ['id_module' => $idModule, 'id_type_user' => $this->selectedRule], //Condizioni di ricerca
                [
                'id_type_user' => $this->selectedRule,
                'id_module' => $idModule,
                ] //Stati da Salvare
            );
            $this->addModuleToUsersRights($this->selectedRule, $idModule);
            $this->dispatch('notify', message: 'Regola salvata con successo!');
        } else {
           $deleteRule =  Rules::where('id_module', $idModule)
             ->where('id_type_user', $this->selectedRule)
             ->delete();
            if($this->deleteModuleToUsersRights($idModule) && $deleteRule){
                $this->dispatch('notify', message: 'Regola rimossa con successo!');
            } else {
                $this->dispatch('error', message: 'Impossibile eliminare la Regola');
            }
            
        }
    }

    public function render()
    {
        $this->types = Types::all();
        $this->modules = Modules::all()->where('is_active', 1);
        return view('rules::livewire.rules-list');
    }
}
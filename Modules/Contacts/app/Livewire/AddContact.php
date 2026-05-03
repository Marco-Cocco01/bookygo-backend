<?php
namespace Modules\Contacts\app\Livewire;

use Livewire\Component;
use Livewire\Attributes\Validate;
use App\Models\Contacts;
use App\Models\CompanyType;
use Illuminate\Validation\Rule;

class AddContact extends Component
{

    public $id_user;
    public $id_parent;
    public $name;
    public $email;
    public $phone;
    public $cell;
    public $is_active;
    public $is_edit = false;



    public function mount($id = null){
        $this->id_user = auth()->id();
        
        //Carico i dati se è presente un id, altrimenti rimangono vuoti per l'inserimento
        if($id){

            $contact = Contacts::findOrFail($id);
            $this->id_parent = Auth()->id();
            $this->name = $contact->name;
            $this->email = $contact->email;
            $this->phone = $contact->phone;
            $this->cell = $contact->cell;
            $this->is_active = $contact->is_active;
            $this->is_edit = true;
        }
    }


    //Viene ricaricata ad ogni render, quindi è importante che sia efficiente
    
    public function companyTypes()
    {    
        return Contacts::where('is_active', 1)->pluck('title', 'id'); 
    }

    public function add(){

        $validated = $this->validate(
            rules: [
                //'owner' => 'required|min:3',
                'name'  => 'required|min:3',
                'email'  => 'required|email|unique:users,email',
                'phone'  => 'required|numeric|digits:10',
                'cell'  => 'required|numeric|digits:10',

            ],
            messages: [
                //'owner.required' => 'Il nominativo è obbligatorio',
                //'owner.min'      => 'Il nominativo deve avere almeno 3 caratteri',
                'name.required'  => 'Il nome azienda è obbligatorio',
                'name.min'       => 'Il nome azienda deve avere almeno 3 caratteri',
                'email.required' => 'Il campo E-Mail è obbligatorio', 
                'email.email'    => 'Indirizzo E-Mail non valido',
                'email.unique'   => 'Indirizzo E-Mail già presente',
                'phone.required' => 'Il numero di telefono è obbligatorio', 
                'phone.numeric'  => 'Il telefono deve contenere solo numeri', 
                'phone.digits'   => 'Il telefono deve essere di 10 cifre',
                'cell.required'  => 'Il numero di cellulare è obbligatorio',  
                'cell.numeric'   => 'Il cellulare deve contenere solo numeri', 
                'cell.digits'    => 'Il cellulare deve essere di 10 cifre', 
            ],
        );

        $action = Contacts::create([
            'id_user' => $this->id_user,
            'id_parent' => Auth()->id(),
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'cell' => $this->cell,
            'is_active' => $this->is_active,
        ]);

        if($action){
            session()->flash('message_ok', 'Inserimento avvenuto con successo.');
        } else {
            session()->flash('message_ko', 'Impossibile inserire l\'azienda.');
        }

       return redirect()->route('company.add');
    }

    //Aggiornamento dei dati, simile alla funzione add ma con regole di validazione leggermente diverse (es. email e iban unici solo se modificati)
    public function update(){

   
        $validated = $this->validate(
            rules: [
                //'owner' => 'required|min:3',
                'name'  => 'required|min:3',
                'email'  => ['required', 'email', Rule::unique('users', 'email')->ignore($this->id_company)],
                'phone'  => 'required|numeric|digits:10',
                'cell'  => 'required|numeric|digits:10',


            ],
            messages: [
                //'owner.required' => 'Il nominativo è obbligatorio',
                //'owner.min'      => 'Il nominativo deve avere almeno 3 caratteri',
                'name.required'  => 'Il nome azienda è obbligatorio',
                'name.min'       => 'Il nome azienda deve avere almeno 3 caratteri',
                'email.required' => 'Il campo E-Mail è obbligatorio', 
                'email.email'    => 'Indirizzo E-Mail non valido',
                'email.unique'   => 'Indirizzo E-Mail già presente',
                'phone.required' => 'Il numero di telefono è obbligatorio', 
                'phone.numeric'  => 'Il telefono deve contenere solo numeri', 
                'phone.digits'   => 'Il telefono deve essere di 10 cifre',
                'cell.required'  => 'Il numero di cellulare è obbligatorio',  
                'cell.numeric'   => 'Il cellulare deve contenere solo numeri', 
                'cell.digits'    => 'Il cellulare deve essere di 10 cifre',
            ],
        );

        $action = Contacts::findOrFail($this->id_contact)->update([
            'id_user' => $this->id_user,
            'id_parent' => $this->id_parent,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'cell' => $this->cell,
            'is_active' => $this->is_active,
        ]);

        if($action){
            session()->flash('message_ok', 'Aggiornamento avvenuto con successo.');
        } else {
            session()->flash('message_ko', 'Impossibile aggiornare l\'azienda.');
        }
    }


    public function render()
    {
        return view('contacts::livewire.add-contact');
    }
}
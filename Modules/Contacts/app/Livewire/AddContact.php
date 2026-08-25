<?php
namespace Modules\Contacts\app\Livewire;

use Livewire\Component;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;
use App\Notifications\BusinessUserInvite;
use App\Models\Contacts;
use App\Models\CompanyType;
use App\Models\User;
use App\Models\TypeUser;
use App\Models\BusinessUnitInvitation;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
    public $id_contact;

    public function mount($id = null){
        $this->id_parent = auth()->id();
        
        //Carico i dati se è presente un id, altrimenti rimangono vuoti per l'inserimento
        if($id){

            $contact = Contacts::findOrFail($id);
            $this->id_contact = $id;
            $this->id_parent = auth()->id();
            $this->name = $contact->name;
            $this->email = $contact->email;
            $this->phone = $contact->phone;
            $this->cell = $contact->cell;
            $this->is_active = $contact->is_active;
            $this->is_edit = true;
        }
    }


    //Viene ricaricata ad ogni render, quindi è importante che sia efficiente
    public function add(){

        $validated = $this->validate(
            rules: [
                //'owner' => 'required|min:3',
                'name'  => 'required|min:3',
                'email'  => 'required|email|unique:contacts,email|unique:users,email',
                'phone'  => 'nullable|required_without:cell|numeric|digits:10',
                'cell'  => 'nullable|required_without:phone|numeric|digits:10',

            ],
            messages: [
                //'owner.required' => 'Il nominativo è obbligatorio',
                //'owner.min'      => 'Il nominativo deve avere almeno 3 caratteri',
                'name.required'  => 'Il nominativo è obbligatorio',
                'name.min'       => 'Il nominativo deve avere almeno 3 caratteri',
                'email.required' => 'Il campo E-Mail è obbligatorio', 
                'email.email'    => 'Indirizzo E-Mail non valido',
                'email.unique'   => 'Indirizzo E-Mail già presente',
                'phone.required_without' => 'Il numero di telefono è obbligatorio se il cellulare non è presente', 
                'phone.numeric'  => 'Il telefono deve contenere solo numeri', 
                'phone.digits'   => 'Il telefono deve essere di 10 cifre',
                'cell.required_without'  => 'Il numero di cellulare è obbligatorio se il telefono non è presente',  
                'cell.numeric'   => 'Il cellulare deve contenere solo numeri', 
                'cell.digits'    => 'Il cellulare deve essere di 10 cifre', 
            ],
        );

        $action = Contacts::create([
            'id_parent' => auth()->id(),
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'cell' => $this->cell,
            'is_active' => $this->is_active,
        ]);

        if($action){
            session()->flash('message_ok', 'Inserimento avvenuto con successo.');
        } else {
            session()->flash('message_ko', 'Impossibile inserire il contatto.');
        }

       return redirect()->route('contact.add');
    }

    //Aggiornamento dei dati, simile alla funzione add ma con regole di validazione leggermente diverse (es. email e iban unici solo se modificati)
    public function update(){


        if(!$this->id_contact){
            session()->flash('message_ko', 'Contatto non trovato.');
            return;
        }

        $validated = $this->validate(
            rules: [
                //'owner' => 'required|min:3',
                'name'  => 'required|min:3',
                'email'  => ['required', 'email', Rule::unique('users', 'email')->ignore($this->id_contact)],
                'phone'  => 'nullable|required_without:cell|numeric|digits:10',
                'cell'  => 'nullable|required_without:phone|numeric|digits:10',
            ],
            messages: [

                'name.required'  => 'Il nominativo è obbligatorio',
                'name.min'       => 'Il nominativo deve avere almeno 3 caratteri',
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
            session()->flash('message_ko', 'Impossibile aggiornare il contatto.');
        }
         return redirect()->route('contact.add');
    }


    /**
     * Invia un invito al contatto per unirsi alla Business Unit
     */
    public function addToBusinessUnit()
    {
        if(!$this->id_contact){
            session()->flash('message_ko', 'Contatto non trovato.');
            return;
        }
        $contact = Contacts::findOrFail($this->id_contact);

        //creo il contatto come utente nel sistema
        $user = User::create([
            'name' => $contact->name,
            'email' => $contact->email,
            'password' => bcrypt(str()->random(12)), // Genera una password casuale
        ]);

        $lastId = $user->id;

        $typeUser = TypeUser::updateOrCreate(
            [
                'id_user' => $lastId
            ],
            [
                'id_user' => $lastId,
                'id_type' => 2
            ]
        );

        
        //Genero il Token per l'invito, che sarà valido per 24 ore
        $token =  Str::random(64);

        //Tabella dove vengono immagazzinati i token di invito, con la data di scadenza e lo stato di utilizzo
        $invitation = $user->businessUnitInvitations()->create([
            'token' => Hash::make($token),
            'expires_at' => now()->addHours(48),
            'invited_by' => auth()->id(),
        ]);



        //Invio notifica di invito al contatto
        $user->notify(new BusinessUserInvite($user, $token));
        session()->flash('message_ok', 'Invito inviato con successo a ' . $user->name);
    }


    public function render()
    {
        return view('contacts::livewire.add-contact');
    }
}
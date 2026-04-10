<?php
namespace Modules\Company\app\Livewire;

use Livewire\Component;
use Livewire\Attributes\Validate;
use App\Models\Company;
use App\Models\CompanyType;
use Illuminate\Validation\Rule;

class AddCompany extends Component
{

    public $id_company;
    public $id_user;
    public $id_type;
    public $companyTypes;
    public $owner;
    public $name;
    public $piva;
    public $cf;
    public $address;
    public $city;
    public $email;
    public $phone;
    public $cell;
    public $iban;
    public $is_active;
    public $is_edit = false;



    public function mount($id = null){
        $this->companyTypes = $this->companyTypes();
        $this->id_user = auth()->id();
        

        //Carico i dati se è presente un id, altrimenti rimangono vuoti per l'inserimento
        if($id){

            $company = Company::findOrFail($id);
            $this->id_type = $company->id_type;
            $this->owner = $company->owner;
            $this->name = $company->name;
            $this->piva = $company->piva;
            $this->cf = $company->cf;
            $this->address = $company->address;
            $this->city = $company->city;
            $this->email = $company->email;
            $this->phone = $company->phone;
            $this->cell = $company->cell;
            $this->iban = $company->iban;
            $this->is_active = $company->is_active;
            $this->is_edit = true;
            $this->id_company = $id;
        }
    }


    //Viene ricaricata ad ogni render, quindi è importante che sia efficiente
    
    public function companyTypes()
    {    
        return CompanyType::where('is_active', 1)->pluck('title', 'id'); 
    }

    public function add(){

        $validated = $this->validate(
            rules: [
                'owner' => 'required|min:3',
                'name'  => 'required|min:3',
                'piva'  => 'required|max:11',
                'cf'  => 'required|max:16',
                'address'  => 'required',
                'city' =>  'required',
                'email'  => 'required|email|unique:users,email',
                'phone'  => 'required|numeric|digits:10',
                'cell'  => 'required|numeric|digits:10',
                'iban'  => 'required|unique:company,iban|regex:/^[A-Z]{2}[0-9]{2}[A-Z0-9]{11,30}$/',

            ],
            messages: [
                'owner.required' => 'Il nominativo è obbligatorio',
                'owner.min'      => 'Il nominativo deve avere almeno 3 caratteri',
                'name.required'  => 'Il nome azienda è obbligatorio',
                'name.min'       => 'Il nome azienda deve avere almeno 3 caratteri',
                'piva.required'  => 'La partita IVA è obbligatoria',
                'piva.max'       => 'La partita IVA non può superare 11 caratteri',
                'cf.required'    => 'Il Codice Fiscale è obbligatorio',
                'cf.max'         => 'Il Codice Fiscale non può superare 16 caratteri',
                'address.required' => 'L\'indirizzo è obbligatorio',  
                'city.required'  => 'La città è obbligatoria', 
                'email.required' => 'Il campo E-Mail è obbligatorio', 
                'email.email'    => 'Indirizzo E-Mail non valido',
                'email.unique'   => 'Indirizzo E-Mail già presente',
                'phone.required' => 'Il numero di telefono è obbligatorio', 
                'phone.numeric'  => 'Il telefono deve contenere solo numeri', 
                'phone.digits'   => 'Il telefono deve essere di 10 cifre',
                'cell.required'  => 'Il numero di cellulare è obbligatorio',  
                'cell.numeric'   => 'Il cellulare deve contenere solo numeri', 
                'cell.digits'    => 'Il cellulare deve essere di 10 cifre',
                'iban.required'  => 'L\'IBAN è obbligatorio',
                'iban.unique'    => 'Questo IBAN è già presente',
                'iban.regex'     => 'Il formato IBAN non è valido', 
            ],
        );

        $action = Company::create([
            'id_user' => $this->id_user,
            'id_type' => $this->id_type,
            'owner' => $this->owner,
            'name' => $this->name,
            'piva' => $this->piva,
            'cf' => $this->cf,
            'address' => $this->address,
            'city' => $this->city,
            'email' => $this->email,
            'id_type' => $this->id_type,
            'phone' => $this->phone,
            'cell' => $this->cell,
            'iban' => $this->iban,
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
                'owner' => 'required|min:3',
                'name'  => 'required|min:3',
                'piva'  => 'required|max:11',
                'cf'  => 'required|max:16',
                'address'  => 'required',
                'city' =>  'required',
                'email'  => ['required', 'email', Rule::unique('users', 'email')->ignore($this->id_company)],
                'phone'  => 'required|numeric|digits:10',
                'cell'  => 'required|numeric|digits:10',
                'iban'  => ['required', Rule::unique('company', 'iban')->ignore($this->id_company), 'regex:/^[A-Z]{2}[0-9]{2}[A-Z0-9]{11,30}$/'],

            ],
            messages: [
                'owner.required' => 'Il nominativo è obbligatorio',
                'owner.min'      => 'Il nominativo deve avere almeno 3 caratteri',
                'name.required'  => 'Il nome azienda è obbligatorio',
                'name.min'       => 'Il nome azienda deve avere almeno 3 caratteri',
                'piva.required'  => 'La partita IVA è obbligatoria',
                'piva.max'       => 'La partita IVA non può superare 11 caratteri',
                'cf.required'    => 'Il Codice Fiscale è obbligatorio',
                'cf.max'         => 'Il Codice Fiscale non può superare 16 caratteri',
                'address.required' => 'L\'indirizzo è obbligatorio',  
                'city.required'  => 'La città è obbligatoria', 
                'email.required' => 'Il campo E-Mail è obbligatorio', 
                'email.email'    => 'Indirizzo E-Mail non valido',
                'email.unique'   => 'Indirizzo E-Mail già presente',
                'phone.required' => 'Il numero di telefono è obbligatorio', 
                'phone.numeric'  => 'Il telefono deve contenere solo numeri', 
                'phone.digits'   => 'Il telefono deve essere di 10 cifre',
                'cell.required'  => 'Il numero di cellulare è obbligatorio',  
                'cell.numeric'   => 'Il cellulare deve contenere solo numeri', 
                'cell.digits'    => 'Il cellulare deve essere di 10 cifre',
                'iban.required'  => 'L\'IBAN è obbligatorio',
                'iban.unique'    => 'Questo IBAN è già presente',
                'iban.regex'     => 'Il formato IBAN non è valido', 
            ],
        );

        $action = Company::findOrFail($this->id_company)->update([
            'id_user' => $this->id_user,
            'id_type' => $this->id_type,
            'owner' => $this->owner,
            'name' => $this->name,
            'piva' => $this->piva,
            'cf' => $this->cf,
            'address' => $this->address,
            'city' => $this->city,
            'email' => $this->email,
            'phone' => $this->phone,
            'cell' => $this->cell,
            'iban' => $this->iban,
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
        return view('company::livewire.add-company');
    }
}
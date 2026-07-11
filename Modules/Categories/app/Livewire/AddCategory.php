<?php
namespace Modules\Categories\app\Livewire;

use Livewire\Component;
use Livewire\Attributes\Validate;
use App\Models\Categories;
use Illuminate\Validation\Rule;

class AddCategory extends Component
{

    public $id_category;
    public $id_user;
    public $id_parent = null;
    public $selectedParent = [];
    public $children = [];
    public $pathFamily = [];
    public $name;
    public $description;
    public $is_active;
    public $is_edit = false;
    public $parentCategories = [];

    protected $casts = [
        'id_parent' => 'integer',
    ];

    public function mount($id = null)
    {

        $this->parentCategories = Categories::whereNull('id_parent')->get();
        $this->id_user = auth()->id();
        
        //Carico i dati se è presente un id, altrimenti rimangono vuoti per l'inserimento
        if($id){
           
            $category = Categories::findOrFail($id);
            $this->id_type = $category->id_type;
            $this->owner = $category->owner;
            $this->name = $category->name;
            $this->is_active = $category->is_active;
            $this->is_edit = true;
            $this->id_category = $id;
        }
    }

    public function add(){


        $validated = $this->validate(
            rules: [
                'name'  => 'required|min:3|unique:categories,name',
                'id_parent' => 'nullable|exists:categories,id',
            ],
            messages: [
                'name.required' => 'Il nome della categoria è obbligatorio',
                'name.min' => 'Il nome della categoria deve avere almeno 3 caratteri',
                'name.unique' => 'Esiste già una categoria con questo nome',
                'id_parent.exists' => 'La categoria padre selezionata non esiste',
            ],
        );

        $action = Categories::create([
            'name' => $this->name,
            'description' => $this->description,
            'id_parent' => end($this->pathFamily),
            'is_active' => $this->is_active,
        ]);

        if($action){
            session()->flash('message_ok', 'Inserimento avvenuto con successo.');
        } else {
            session()->flash('message_ko', 'Impossibile inserire la categoria.');
        }

       return redirect()->route('categories.add');
    }


    /**Controlla che la categoria abbia figli / nipoti */
    public function checkSubCategories($id){

        // Salva la selezione per questo livello
        array_push($this->selectedParent, $id);
        array_push($this->pathFamily, end($this->selectedParent) );

        \Log::info('Current path family: ' . implode(' > ', $this->pathFamily));

        $subCategory = Categories::where('id_parent', $id)
            ->where('is_active', 1)
            ->get(['id', 'name']);
        if(count($subCategory) > 0)
        {
            $this->children[] = $subCategory->toArray();
        }
    }

    //Aggiornamento dei dati, simile alla funzione add ma con regole di validazione leggermente diverse (es. email e iban unici solo se modificati)
    public function update(){

        $validated = $this->validate(
            rules: [
                'owner' => 'required|min:3',
                'name'  => 'required|min:3|unique:categories,name',

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

        $action = Categories::findOrFail($this->id_category)->update([
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
        return view('categories::livewire.add-categories', [
            'parentCategories' => Categories::whereNull('id_parent')->get()
        ]);
    }
}
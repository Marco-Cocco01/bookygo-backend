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
        //dd($this->parentCategories);
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
            $this->id_parent = $category->id_parent;
            $this->selectedParent = [$category->id_parent]; 
            \Log::info('Editing category: ID Parent: ' . $this->id_parent . ' - Name: ' . $this->name . ' (ID: ' . $this->id_category . ')');
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

       $action = Categories::where('id', $this->id_category)->update([
            'name' => $this->name,
            'description' => $this->description,
            'id_parent' => $this->id_parent,
            'is_active' => $this->is_active,
        ]);

        if($action){
            session()->flash('message_ok', 'Aggiornamento avvenuto con successo.');
        } else {
            session()->flash('message_ko', 'Impossibile aggiornare la categoria.');
        }
    }

    public function render()
    {
        return view('categories::livewire.add-categories', [
            'parentCategories' => Categories::whereNull('id_parent')->get()
        ]);
    }
}
<?php
namespace Modules\ProductRules\app\Livewire;

use Livewire\Component;
use Livewire\Attributes\Validate;
use App\Models\ProductRules;
use App\Models\User;
use App\Models\Types;
use App\Models\Categories;
use Illuminate\Validation\Rule;

class AddProductRules extends Component
{
    public $title;
    public $categories = [];
    public $is_active = false;
    public $is_edit = false;
    public $id_productrule = null;
    public $id_category;


    protected function getValidationRules($id_productrule = null): array
    {
        return [
            'title' => [
                'required',
                'min:3',
                 Rule::unique('product_rules', 'title')->ignore($id_productrule),
            ],
            'id_category' => 'required',
        ];
    }

    protected function getValidationMessages(): array
    {
        return [
            'title.required'           => 'Il nominativo è obbligatorio',
            'title.min'                => 'Il nominativo deve avere almeno 3 caratteri',
            'title.unique'             => 'Questo nome è già stato utilizzato', 
            'id_category.required'     => 'Specificare uan categoria di appartenenza',
        ];
    }



    public function mount($id = null)
    {
        $this->id_parent = auth()->id();
        //Categorie Principali
        $this->categories = Categories::whereNull('id_parent')
        ->where('is_active', '=', 1)
        ->pluck("name", "id")
        ->toArray();
        

        if($id)
        {
            $productRule = ProductRules::findOrFail($id);
            $this->id_productrule = $id;
            $this->title = $productRule->title;
            $this->id_category = $productRule->id_category;
            $this->is_active = $productRule->is_active;
            $this->is_edit = true;
        }
    }


    public function add(){

        $validated = $this->validate(
            rules: $this->getValidationRules($this->id_productrule), 
            messages: $this->getValidationMessages()
        );

        $action = ProductRules::create([
            'title' => $this->title,
            'id_category' => $this->id_category,
            'is_active' => $this->is_active ? 1 : 0
        ]);

        if($action){
            
            session()->flash('message_ok', 'Inserimento avvenuto con successo.');
        } else {
            session()->flash('message_ko', 'Impossibile inserire la regola.');
        }
        $this->reset(['title', 'id_category', 'is_active']);

        return redirect()->route('product-rule.add');
    }

    public function update(){

        if(!$this->id_productrule){
            session()->flash('message_ko', 'Regola non trovata.');
            return;
        }

        $validated = $this->validate(
            rules: $this->getValidationRules(($this->id_productrule)), 
            messages: $this->getValidationMessages()
        );

        $action = ProductRules::findOrFail($this->id_productrule)->update([
            'title' => $this->title,
            'id_category' => $this->id_category,            
            'is_active' => $this->is_active,
        ]);

        if($action){
            session()->flash('message_ok', 'Aggiornamento avvenuto con successo.');
        } else {
            session()->flash('message_ko', 'Impossibile aggiornare la tassazione.');
        }

        $this->reset(['title', 'id_category', 'is_active']);
        return redirect()->route('product-rule.add');
    }
    

    public function render()
    {
        return view('productrules::livewire.add-product-rules');
    }
}
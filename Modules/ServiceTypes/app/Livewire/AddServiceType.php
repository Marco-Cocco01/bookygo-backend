<?php
namespace Modules\ServiceTypes\app\Livewire;

use Livewire\Component;
use Livewire\Attributes\Validate;
use App\Models\ServiceTypes;
use App\Models\User;
use App\Models\Types;
use App\Models\Categories;
use Illuminate\Validation\Rule;

class AddServiceType extends Component
{
    public $title;
    public $categories = [];
    public $is_active = false;
    public $is_edit = false;
    public $id_servicetype;
    public $id_category;


    protected function getValidationRules($id_servicetype = null): array
    {
        return [
            'title' => [
                'required',
                'min:3',
                 Rule::unique('service_types', 'title')->ignore($id_servicetype),
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
            $serviceType = ServiceTypes::findOrFail($id);
            $this->id_servicetype = $id;
            $this->title = $serviceType->title;
            $this->id_category = $serviceType->id_category;
            $this->is_active = $serviceType->is_active;
            $this->is_edit = true;
        }
    }


    public function add(){

        $validated = $this->validate(
            rules: $this->getValidationRules($id_servicetype), 
            messages: $this->getValidationMessages()
        );

        $action = ServiceTypes::create([
            'title' => $this->title,
            'id_category' => $this->id_category,
            'is_active' => $this->is_active ? 1 : 0
        ]);

        if($action){
            
            session()->flash('message_ok', 'Inserimento avvenuto con successo.');
        } else {
            session()->flash('message_ko', 'Impossibile inserire il tipo di servizio.');
        }
        $this->reset(['title', 'id_category', 'is_active']);

        return redirect()->route('service-type.add');
    }

    public function update(){

        if(!$this->id_servicetype){
            session()->flash('message_ko', 'Tipologia di servizio non trovato.');
            return;
        }

        $validated = $this->validate(
            rules: $this->getValidationRules(($this->id_servicetype)), 
            messages: $this->getValidationMessages()
        );

        $action = ServiceTypes::findOrFail($this->id_servicetype)->update([
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
        return redirect()->route('service-type.add');
    }
    

    public function render()
    {
        return view('servicetypes::livewire.add-service-type');
    }
}
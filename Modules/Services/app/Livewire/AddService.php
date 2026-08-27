<?php
namespace Modules\Services\app\Livewire;

use Livewire\Component;
use Livewire\Attributes\Validate;
use App\Models\ServiceTypes;
use App\Models\Services;
use App\Models\User;
use App\Models\Types;
use App\Models\Categories;
use Illuminate\Validation\Rule;

class AddService extends Component
{
    public $title;
    public $serviceTypes = [];
    public $is_active = false;
    public $is_edit = false;
    public $id_service = null;
    public $id_service_type;



    protected function getValidationRules($id_service = null): array
    {
        return [
            'title' => [
                'required',
                'min:3',
                 Rule::unique('services', 'title')->ignore($id_service),
            ],
            'id_service_type' => 'required',
        ];
    }

    protected function getValidationMessages(): array
    {
        return [
            'title.required'           => 'Il nominativo è obbligatorio',
            'title.min'                => 'Il nominativo deve avere almeno 3 caratteri',
            'title.unique'             => 'Questo nome è già stato utilizzato', 
            'id_service_type.required'     => 'Specificare uan categoria di appartenenza',
        ];
    }



    public function mount($id = null)
    {
        //Categorie di appartenenza + principali
        $this->serviceTypes = ServiceTypes::with('category')->get()->toArray();

        if($id)
        {
            $service = Services::findOrFail($id);
            $this->id_service = $id;
            $this->id_service_type = $service->id_service_type;
            $this->title = $service->title;
            $this->id_category = $service->id_category;
            $this->is_active = $service->is_active;
            $this->is_edit = true;
        }
    }


    public function add(){

        $validated = $this->validate(
            rules: $this->getValidationRules($this->id_service), 
            messages: $this->getValidationMessages()
        );

        $action = Services::create([
            'title' => $this->title,
            'id_service_type' => $this->id_service_type,
            'is_active' => $this->is_active ? 1 : 0
        ]);

        if($action){
            
            session()->flash('message_ok', 'Inserimento avvenuto con successo.');
        } else {
            session()->flash('message_ko', 'Impossibile inserire il tipo di servizio.');
        }
        $this->reset(['title', 'id_service_type', 'is_active']);

        return redirect()->route('service.add');
    }

    public function update(){

        if(!$this->id_service){
            session()->flash('message_ko', 'Servizio non trovato.');
            return;
        }

        $validated = $this->validate(
            rules: $this->getValidationRules(($this->id_service)), 
            messages: $this->getValidationMessages()
        );

        $action = Services::findOrFail($this->id_service)->update([
            'title' => $this->title,
            'id_service_type' => $this->id_service_type,            
            'is_active' => $this->is_active,
        ]);

        if($action){
            session()->flash('message_ok', 'Aggiornamento avvenuto con successo.');
        } else {
            session()->flash('message_ko', 'Impossibile aggiornare il servizio.');
        }

        $this->reset(['title', 'id_service_type', 'is_active']);
        return redirect()->route('service.add');
    }
    

    public function render()
    {
        return view('services::livewire.add-service');
    }
}
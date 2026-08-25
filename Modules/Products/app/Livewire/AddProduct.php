<?php
namespace Modules\Products\app\Livewire;

use Livewire\Component;
use Livewire\Attributes\Validate;
use App\Models\Fee;
use App\Models\User;
use App\Models\Types;
use Illuminate\Validation\Rule;

class AddProduct extends Component
{
    public $name;
    public $description;
    public $amount;
    public $is_active;
    public $is_edit = false;
    public $id_fee;
    public $id_client_type ;
    public $client_types = [];


    protected function getValidationRules($feeId = null): array
    {
        return [
            'name'           => 'required|min:3',
            'description'    => 'required|min:3',
            'amount'         => 'required|numeric|min:1',
            'id_client_type' => [
                'required',
                Rule::unique('fee', 'id_client_type')->ignore($feeId)
            ],
        ];
    }

    protected function getValidationMessages(): array
    {
        return [
            'name.required'           => 'Il nominativo è obbligatorio',
            'name.min'                => 'Il nominativo deve avere almeno 3 caratteri',
            'description.required'    => 'Il campo Descrizione è obbligatorio',
            'description.min'         => 'La descrizione deve avere almeno 3 caratteri',
            'amount.required'         => 'Il campo Importo è obbligatorio',
            'amount.numeric'          => 'L\'importo deve essere un numero',
            'amount.min'              => 'L\'importo deve essere un valore positivo',
            'id_client_type.required' => 'Il campo Tipo Utente è obbligatorio',
            'id_client_type.unique'   => 'Il tipo utente è già associato ad una tassa',
        ];
    }



    public function mount($id = null)
    {
        $this->id_parent = auth()->id();
        $this->client_types = Types::where('is_active', 1)
            ->whereIn('name', ['Client', 'Business'])
            ->pluck('name', 'id')
            ->toArray();

        if($id)
        {
            $fee = Fee::findOrFail($id);
            $this->id_fee = $id;
            $this->name = $fee->name;
            $this->description = $fee->description;
            $this->amount = $fee->amount;
            $this->is_active = $fee->is_active;
            $this->id_client_type = $fee->id_client_type;
            $this->is_edit = true;
        }
    }


    public function add(){

        $validated = $this->validate(
            rules: $this->getValidationRules(null), 
            messages: $this->getValidationMessages()
        );

        $action = Fee::create([
            'name' => $this->name,
            'description' => $this->description,
            'amount' => $this->amount,
            'id_client_type' => $this->id_client_type,
            'is_active' => $this->is_active,
        ]);

        if($action){
            
            session()->flash('message_ok', 'Inserimento avvenuto con successo.');
        } else {
            session()->flash('message_ko', 'Impossibile inserire la tassazione.');
        }
        $this->reset(['name', 'description', 'amount', 'id_client_type']);
        return redirect()->route('product.add');
    }

    public function update(){

        if(!$this->id_fee){
            session()->flash('message_ko', 'Tassazione non trovata.');
            return;
        }

        $validated = $this->validate(
            rules: $this->getValidationRules(($this->id_fee)), 
            messages: $this->getValidationMessages()
        );

        $action = Fee::findOrFail($this->id_fee)->update([
            'name' => $this->name,
            'description' => $this->description,
            'amount' => $this->amount,
            'id_client_type' => $this->id_client_type,
            'is_active' => $this->is_active,
        ]);

        if($action){
            session()->flash('message_ok', 'Aggiornamento avvenuto con successo.');
        } else {
            session()->flash('message_ko', 'Impossibile aggiornare la tassazione.');
        }

        $this->reset(['name', 'description', 'amount', 'id_client_type']);
        return redirect()->route('product.add');
    }
    

    public function render()
    {
        return view('product::livewire.add-product');
    }
}
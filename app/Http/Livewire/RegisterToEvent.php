<?php

namespace App\Http\Livewire;

use App\Models\Event;
use Livewire\Component;
use App\Models\Registration;
use Illuminate\Support\Facades\DB;
use App\Http\Livewire\Traits\HasConfirmation;
use Flasher\Prime\Notification\NotificationInterface;

class RegisterToEvent extends Component
{
    use HasConfirmation;
    public Event $event;
     public $name;
     public $phone;
     public $email;
     public $group;
     public $additional_phone;


    public $plans = [];
    public $total = 0;

    protected $rules = [
        'name' => ['required'],
        'phone' => ['required'],
        'email' => ['nullable', 'email'],
        'plans' => ['min:1', 'array'],
        'plans.*' => ['required'],
        'plans.*.quantity' => ['required', 'numeric', 'min:1'],
    ];

    protected $messages = [        
        'plans.min' => 'Favor poner cantidad en al menos un producto',
        // 'plans.*' => ['required'],
        'plans.*.quantity.min' => 'La cantidad minima permitida es 1',
    ];

    public function mount(Event $event)
    {
        $this->event = $event->load('plans');
    }
    public function render()
    {
        return view('livewire.register-to-event')
            ->layout('layouts.guest');
    }

    public function create()
    {
        $this->validate();

        DB::transaction(function() {
            $event = $this->event->registrations()->create([
                'name' => $this->name,
                'phone' => $this->phone,
                'email' => $this->email,
                'group' => $this->group,
                'additional_phone' => $this->additional_phone,
                'amount' => $this->total,
            ]);

            // Send Email notification


            
            foreach ($this->plans as $id => $plan) {
                $event->sales()->create([
                    'plan_id' => $id,
                    'count' => $plan['quantity'],
                    'unit_price' => $this->event->plans->where('id', $id)->first()->price
                ]);
            }


            $this->inform("Usted ha sido registrado al evento!", view('registration-created')->toHtml(), "OK");

            return redirect('/');
        });
    }

    public function calculateSubtotal($quantity, $price): float
    {
        return $quantity ?? 0 ? $quantity * $price : 0;
    }

    public function updatedPlans()
    {
        $this->resetValidation($this->plans);
        $this->total = $this->calculateTotal();
    }

    private function calculateTotal()
    {
        $total = 0;

        // dump($this->plans);
        foreach ($this->plans as $key => $plan) {
            if ($plan['quantity']) {
                $total += $this->event->plans->where('id', $key)->first()->price * $plan['quantity'] ?? 0;
            }
        }
        // dump($total);

        return $total;
    }

    public function clearProduct($product)
    {
        unset($this->plans[$product]);
        
        $this->total = $this->calculateTotal();
    }

    public function cancel()
    {
        $this->confirm('cancelConfirmed', 'Está seguro que quiere cancelar el proceso de registro?', NotificationInterface::ERROR);
    }

    public function cancelConfirmed()
    {
        $this->flash("Proceso de inscripción cancelado. ", NotificationInterface::ERROR);
        
        return redirect("/");
    }
}

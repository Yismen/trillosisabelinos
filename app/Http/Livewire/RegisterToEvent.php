<?php

namespace App\Http\Livewire;

use App\Models\Event;
use Livewire\Component;
use App\Models\Registration;
use Illuminate\Support\Facades\DB;

class RegisterToEvent extends Component
{
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
            $this->event->registrations()->create([
                'name' => $this->name,
                'phone' => $this->phone,
                'email' => $this->email,
                'group' => $this->group ?: 'ssf',
                'additional_phone' => $this->additional_phone,
                'amount' => $this->total,
            ]);

            // Send Email notification
            // Create sales

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
}

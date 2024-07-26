<?php

namespace App\Livewire\Customer;

use Filament\Tables\Contracts\HasTable;
use Livewire\Component;

class UnpaidCustomer extends Component
{
    // use InteractsWithTable;

    public function render()
    {
        return view('livewire.customer.unpaid-customer');
    }
}

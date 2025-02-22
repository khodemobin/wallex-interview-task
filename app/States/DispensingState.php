<?php

namespace App\States;

use App\Contracts\VendingMachineContext;
use App\Contracts\VendingMachineState;

class DispensingState implements VendingMachineState
{
    private VendingMachineContext $machine;

    public function __construct(VendingMachineContext $machine)
    {
        $this->machine = $machine;
    }

    public function insertCoin(): string
    {
        return 'Dispensing in progress. Please wait.';
    }

    public function selectProduct(string $product): string
    {
        return 'Dispensing in progress. Please wait.';
    }

    public function dispense(): string
    {
        $product = $this->machine->getSelectedProduct();
        $this->machine->reduceStock($product);
        $this->machine->setState(new IdleState($this->machine));

        return "Dispensed $product. Enjoy!";
    }
}

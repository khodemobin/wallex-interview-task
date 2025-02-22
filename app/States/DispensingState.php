<?php

namespace App\States;

use App\Interfaces\IMachineState;
use App\Interfaces\IVendingMachine;
use App\Models\Machine;

class DispensingState implements IMachineState
{
    private Machine $machine;

    public function __construct(Machine $machine)
    {
        $this->machine = $machine;
    }

    public static function name(): string
    {
        return 'Dispensing';
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

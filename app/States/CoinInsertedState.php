<?php

namespace App\States;

use App\Interfaces\IVendingMachine;
use App\Interfaces\IMachineState;
use App\Models\Machine;

class CoinInsertedState implements IMachineState
{
    private Machine $machine;

    public function __construct(Machine $machine)
    {
        $this->machine = $machine;
    }

    public static function name(): string
    {
        return 'CoinInserted';
    }

    public function insertCoin(): string
    {
        return 'Coin already inserted.';
    }

    public function selectProduct(string $product): string
    {
        if ($this->machine->hasStock($product)) {
            $this->machine->setSelectedProduct($product);
            $this->machine->setState(new DispensingState($this->machine));

            return "Dispensing $product...";
        }

        return 'Product unavailable or out of stock.';
    }

    public function dispense(): string
    {
        return 'Please select a product first.';
    }
}

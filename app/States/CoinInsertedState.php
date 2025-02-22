<?php

namespace App\States;

use App\Contracts\VendingMachineContext;
use App\Contracts\VendingMachineState;

class CoinInsertedState implements VendingMachineState
{
    private VendingMachineContext $machine;

    public function __construct(VendingMachineContext $machine)
    {
        $this->machine = $machine;
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

<?php

namespace App\States;

use App\Interfaces\iMachineState;
use App\Models\Machine;
use App\Models\Product;
use Throwable;

class IdleState implements iMachineState
{
    /**
     * @throws Throwable
     */
    public function insertCoin(Machine $machine, int $amount): string
    {
        $machine->state = CoinInsertedState::class;
        $machine->balance += $amount;
        $machine->save();

        Machine::updateState($machine, CoinInsertedState::class);

        return 'Coin inserted. Please select a product.';
    }

    public function selectProduct(Machine $machine, Product $product): string
    {
        throw new \RuntimeException('Please insert a coin first.');
    }

    public function dispense(Machine $machine): string
    {
        throw new \RuntimeException('No product to dispense.');
    }
}

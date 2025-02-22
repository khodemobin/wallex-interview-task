<?php

namespace App\Interfaces;

use App\Models\Machine;
use App\Models\Product;

interface iMachineState
{
    public function insertCoin(Machine $machine, int $amount): string;

    public function selectProduct(Machine $machine, Product $product): string;

    public function dispense(Machine $machine): string;
}

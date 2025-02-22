<?php

namespace App\Contracts;

interface VendingMachineState
{
    public function insertCoin(): string;

    public function selectProduct(string $product): string;

    public function dispense(): string;
}

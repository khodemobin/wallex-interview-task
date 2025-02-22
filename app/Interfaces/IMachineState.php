<?php

namespace App\Interfaces;

interface IMachineState
{
    public static function name(): string;

    public function insertCoin(): string;

    public function selectProduct(string $product): string;

    public function dispense(): string;
}

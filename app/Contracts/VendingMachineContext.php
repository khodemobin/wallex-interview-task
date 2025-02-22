<?php

namespace App\Contracts;


interface VendingMachineContext
{
    public function setState(VendingMachineState $state): void;

    public function hasStock(string $product): bool;

    public function reduceStock(string $product): void;

    public function getStock(): array;

    public function setSelectedProduct(string $product): void;

    public function getSelectedProduct(): ?string;
}

<?php

namespace App\Interfaces;


interface IVendingMachine
{
    public function setState(IMachineState $state): void;

    public function hasStock(string $product): bool;

    public function reduceStock(string $product): void;

    public function getProducts(): array;

    public function getStock(): array;

    public function setSelectedProduct(string $product): void;

    public function getSelectedProduct(): ?string;
}

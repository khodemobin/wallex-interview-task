<?php

namespace App\Services;

use App\Contracts\VendingMachineContext;
use App\Models\Product;
use App\Models\VendingMachine;

class VendingMachineService implements VendingMachineContext
{
    private mixed $state;

    private VendingMachine $model;

    private ?string $selectedProduct = null;

    public function __construct(VendingMachine $model)
    {
        $this->model = $model;
        $stateClass = 'App\\States\\'.$model->state;
        $this->state = new $stateClass($this);
    }

    public function setState(VendingMachine $state): void
    {
        $this->state = $state;
        $this->model->state = (new \ReflectionClass($state))->getShortName();
        $this->model->save();
    }

    public function insertCoin(): string
    {
        return $this->state->insertCoin();
    }

    public function selectProduct(string $product): string
    {
        return $this->state->selectProduct($product);
    }

    public function dispense(): string
    {
        return $this->state->dispense();
    }

    public function hasStock(string $product): bool
    {
        $productModel = Product::where('name', $product)->first();

        return $productModel && $productModel->stock > 0;
    }

    public function reduceStock(string $product): void
    {
        $productModel = Product::where('name', $product)->first();
        if ($productModel) {
            $productModel->reduceStock();
        }
    }

    public function getStock(): array
    {
        return Product::query()->pluck('stock', 'name')->toArray();
    }

    public function getStateName(): string
    {
        return $this->model->state;
    }

    public function setSelectedProduct(string $product): void
    {
        $this->selectedProduct = $product;
    }

    public function getSelectedProduct(): ?string
    {
        return $this->selectedProduct;
    }

    public function logTransaction(string $action, ?string $product = null): void
    {
        $productModel = $product ? Product::query()->where('name', $product)->first() : null;
        $this->model->transactions()->create([
            'action' => $action,
            'product_id' => $productModel?->id,
        ]);
    }
}

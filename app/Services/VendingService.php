<?php

namespace App\Services;

use App\Interfaces\IMachineState;
use App\Interfaces\IVendingMachine;
use App\Models\Machine;
use App\Models\Product;
use App\States\IdleState;

class VendingService implements IVendingMachine
{
    private IMachineState $state;

    private Machine $machine;

    private ?string $selectedProduct = null;

    /**
     * @throws \Throwable
     */
    public function __construct()
    {
        $this->machine = Machine::query()->createOrFirst([]);

        $this->state = new $this->model->state(($this));
    }

    public function setState(IMachineState $state): void
    {
        $this->state = $state;
        $this->machine->state = (new \ReflectionClass($state))->getShortName();
        $this->machine->save();
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
        $productModel = Product::query()->where('name', $product)->first();

        return $productModel && $productModel->stock > 0;
    }

    public function reduceStock(string $product): void
    {
        $productModel = Product::where('name', $product)->first();
        if ($productModel) {
            $productModel->reduceStock();
        }
    }

    public function getProducts(): array
    {
        return Product::query()->get()->toArray();
    }

    public function getStock(): array
    {
        return Product::query()->pluck('stock', 'name')->toArray();
    }

    public function getStateName(): string
    {
        return $this->machine->state::name();
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
        $this->machine->transactions()->create([
            'action' => $action,
            'product_id' => $productModel?->id,
        ]);
    }
}

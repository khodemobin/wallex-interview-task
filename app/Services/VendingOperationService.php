<?php

namespace App\Services;

use App\Interfaces\IVendingMachine;
use Illuminate\Support\Facades\Cache;

class VendingOperationService
{
    private IVendingMachine $vendingMachine;

    public function __construct(IVendingMachine $vendingMachine)
    {
        $this->vendingMachine = $vendingMachine;
    }

    public function getStatus(): array
    {
        return [
            'state' => $this->vendingMachine->getStateName(),
            'stock' => $this->vendingMachine->getStock(),
        ];
    }

    public function handleInsertCoin(): string
    {
        $result = $this->vendingMachine->insertCoin();
        $this->vendingMachine->logTransaction('coin_inserted');

        return $result;
    }

    /**
     * @throws \Exception
     */
    public function handleSelectProduct(string $product): string
    {
        $lock = Cache::lock("vending_machine_{$this->vendingMachine->getStateName()}_lock", 10);

        try {
            if (! $lock->get()) {
                throw new \RuntimeException('Machine is busy. Please try again shortly.', 429);
            }

            $selectionResult = $this->vendingMachine->selectProduct($product);
            $this->vendingMachine->logTransaction('product_selected', $product);

            if (str_starts_with($selectionResult, 'Dispensing')) {
                $dispenseResult = $this->vendingMachine->dispense();
                $this->vendingMachine->logTransaction('dispensed', $product);

                return "$selectionResult $dispenseResult";
            }

            return $selectionResult;
        } finally {
            $lock->release();
        }
    }
}

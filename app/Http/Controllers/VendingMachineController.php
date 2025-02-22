<?php

namespace App\Http\Controllers;

use App\Services\VendingMachineBusinessService;
use Illuminate\Http\JsonResponse;

class VendingMachineController extends Controller
{
    private VendingMachineBusinessService $vendingService;

    public function __construct(VendingMachineBusinessService $vendingService)
    {
        $this->vendingService = $vendingService;
    }

    public function status(): JsonResponse
    {
        return response()->json($this->vendingService->getStatus());
    }

    public function insertCoin(): JsonResponse
    {
        return response()->json(['message' => $this->vendingService->handleInsertCoin()]);
    }

    public function selectProduct(string $product): JsonResponse
    {
        try {
            return response()->json(['message' => $this->vendingService->handleSelectProduct($product)]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode() ?: 500);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Services\VendingOperationService;
use Illuminate\Http\JsonResponse;

class VendingController extends Controller
{
    private VendingOperationService $vendingService;

    public function __construct(VendingOperationService $vendingService)
    {
        $this->vendingService = $vendingService;
    }

    public function status(): JsonResponse
    {
        $result = $this->vendingService->getStatus();

        return response()->json($result);
    }

    public function insertCoin(): JsonResponse
    {
        $result = $this->vendingService->handleInsertCoin();

        return response()->json(['message' => $result]);
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

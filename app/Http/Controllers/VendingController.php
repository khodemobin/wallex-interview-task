<?php

namespace App\Http\Controllers;

use App\Http\Resources\MachineResource;
use App\Models\Machine;
use App\Models\Product;
use App\Services\VendingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class VendingController extends Controller
{
    public function machines(VendingService $service): AnonymousResourceCollection
    {
        $result = $service->machines();

        return MachineResource::collection($result);
    }

    public function insertCoin(Request $request, Machine $machine, VendingService $service): JsonResponse
    {
        $request->validate([
            'amount' => 'required|numeric',
        ]);

        try {
            $result = $service->handleInsertCoin($machine, $request->input('amount'));

            return response()->json(['message' => $result]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode() ?: 500);
        }
    }

    public function selectProduct(Machine $machine, Product $product, VendingService $service): JsonResponse
    {
        try {
            $result = $service->handleSelectProduct($machine, $product);

            return response()->json(['message' => $result]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode() ?: 500);
        }
    }

    public function dispense(Machine $machine, VendingService $service): JsonResponse
    {
        try {
            $result = $service->handleDispensing($machine);

            return response()->json(['message' => $result]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode() ?: 500);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function storeBatch(Request $request, Portfolio $portfolio)
    {
        $validated = $request->validate([
            'transactions' => 'required|array|min:1',
            'transactions.*.asset_id' => 'required|exists:assets,id',
            'transactions.*.type' => 'required|in:buy,sell',
            'transactions.*.quantity' => 'required|numeric|min:0.0001',
            'transactions.*.price' => 'required|numeric|min:0.0001',
            'transactions.*.date' => 'required|date',
            'transactions.*.notes' => 'nullable|string',
        ]);

        DB::transaction(function () use ($portfolio, $validated) {
            foreach ($validated['transactions'] as $tx) {
                Transaction::create([
                    'portfolio_id' => $portfolio->id,
                    'asset_id' => $tx['asset_id'],
                    'type' => $tx['type'],
                    'quantity' => $tx['quantity'],
                    'price' => $tx['price'],
                    'date' => $tx['date'],
                    'notes' => $tx['notes'] ?? null,
                ]);
            }
        });

        return response()->json([
            'message' => 'Transactions saved successfully.',
        ], 201);
    }
}

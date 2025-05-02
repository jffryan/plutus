<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Holding;

class HoldingController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'portfolio_id' => 'required|exists:portfolios,id',
            'asset_id' => 'required|exists:assets,id',
            'target_allocation' => 'required|numeric|min:0|max:1',
            'cost_basis' => 'required|numeric|min:0',
            'quantity' => 'required|numeric|min:0',
            'is_paper_trade' => 'boolean',
            'flag_close_this_year' => 'boolean',
            'notes' => 'nullable|string',
        ]);

        $holding = Holding::create([
            ...$validated,
            'is_paper_trade' => $validated['is_paper_trade'] ?? false,
            'flag_close_this_year' => $validated['flag_close_this_year'] ?? false,
        ]);

        return response()->json([
            'message' => 'Holding created successfully.',
            'holding' => $holding->load('asset'),
        ], 201);
    }
}

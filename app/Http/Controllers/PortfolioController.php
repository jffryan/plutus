<?php

namespace App\Http\Controllers;

use App\Http\Resources\PortfolioResource;
use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PortfolioController extends Controller
{

    public function index()
    {
        $portfolios = Auth::user()
            ->portfolios()
            ->with('holdings.asset')
            ->get();

        return PortfolioResource::collection($portfolios);
    }

    public function show(Portfolio $portfolio)
    {
        // Enforce ownership check
        if ($portfolio->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $portfolio->load('holdings.asset.tags');

        if ($portfolio->holdings->isEmpty()) {
            $latestSnapshot = $portfolio->snapshots()
                ->latest('snapshot_date')
                ->with('snapshotHoldings')
                ->first();

            if ($latestSnapshot) {
                foreach ($latestSnapshot->snapshotHoldings as $s) {
                    $portfolio->holdings()->create([
                        'asset_id' => $s->asset_id,
                        'quantity' => $s->quantity,
                        'cost_basis' => $s->cost_basis,
                        'value' => $s->value,
                        'target_allocation' => 0,
                        'is_paper_trade' => false,
                        'flag_close_this_year' => false,
                        'notes' => null,
                    ]);
                }

                $portfolio->load('holdings.asset.tags');
            }
        }

        return new PortfolioResource($portfolio);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:portfolios,name',
            'description' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        // Attach the portfolio to the logged-in user
        $portfolio = Auth::user()->portfolios()->create($validated);

        return response()->json([
            'message' => 'Portfolio created successfully.',
            'portfolio' => new PortfolioResource($portfolio),
        ], 201);
    }
}

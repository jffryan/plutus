<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Portfolio;
use App\Http\Resources\PortfolioResource;

class PortfolioController extends Controller
{

    public function index()
    {
        $portfolios = Portfolio::with('holdings.asset')->get();
    
        return PortfolioResource::collection($portfolios);
    }

    public function show(Portfolio $portfolio)
    {
        $portfolio->load('holdings.asset.tags');
    
        if ($portfolio->holdings->isEmpty()) {
            $latestSnapshot = $portfolio->snapshots()->latest('snapshot_date')->with('snapshotHoldings')->first();
    
            if ($latestSnapshot) {
                foreach ($latestSnapshot->snapshotHoldings as $s) {
                    $portfolio->holdings()->create([
                        'asset_id' => $s->asset_id,
                        'quantity' => $s->quantity,
                        'cost_basis' => $s->cost_basis,
                        'value' => $s->value,
                        'target_allocation' => 0, // user will update this
                        'is_paper_trade' => false,
                        'flag_close_this_year' => false,
                        'notes' => null,
                    ]);
                }
    
                // Reload after creation
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

        $portfolio = Portfolio::create($validated);

        return response()->json([
            'message' => 'Portfolio created successfully.',
            'portfolio' => $portfolio,
        ], 201);
    }
}

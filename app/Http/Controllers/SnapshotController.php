<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Portfolio;
use App\Models\Snapshot;
use App\Models\SnapshotHolding;
use App\Http\Resources\SnapshotIndexResource;
use App\Http\Resources\SnapshotDetailResource;
use Illuminate\Support\Facades\DB;

class SnapshotController extends Controller
{
    public function index(Portfolio $portfolio)
    {
        $snapshots = $portfolio->snapshots()->withCount('snapshotHoldings')->get();

        return SnapshotIndexResource::collection($snapshots);
    }

    public function show(Snapshot $snapshot)
    {
        $snapshot->load('snapshotHoldings.asset.tags');

        return new SnapshotDetailResource($snapshot);
    }


    public function store(Request $request, Portfolio $portfolio)
    {
        $validated = $request->validate([
            'snapshot_date' => 'required|date',
            'notes' => 'nullable|string',
            'holdings' => 'required|array|min:1',
            'holdings.*.asset_id' => 'required|exists:assets,id',
            'holdings.*.quantity' => 'required|numeric|min:0',
            'holdings.*.value' => 'required|numeric|min:0',
            'holdings.*.cost_basis' => 'required|numeric|min:0',
        ]);

        return DB::transaction(function () use ($portfolio, $validated) {
            $snapshot = $portfolio->snapshots()->create([
                'snapshot_date' => $validated['snapshot_date'],
                'notes' => $validated['notes'] ?? null,
            ]);

            foreach ($validated['holdings'] as $h) {
                $snapshot->snapshotHoldings()->create([
                    'asset_id' => $h['asset_id'],
                    'quantity' => $h['quantity'],
                    'value' => $h['value'],
                    'cost_basis' => $h['cost_basis'],
                ]);
            }

            return response()->json([
                'message' => 'Snapshot created successfully.',
                'snapshot_id' => $snapshot->id,
            ], 201);
        });
    }
}

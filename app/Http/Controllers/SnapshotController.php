<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Portfolio;
use App\Models\Snapshot;
use App\Http\Resources\SnapshotIndexResource;
use App\Http\Resources\SnapshotDetailResource;

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
}

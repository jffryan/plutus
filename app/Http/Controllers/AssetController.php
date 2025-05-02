<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asset;
use App\Http\Resources\AssetResource;

class AssetController extends Controller
{
    public function index()
    {
        return AssetResource::collection(Asset::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ticker' => 'nullable|string',
            'label' => 'required|string',
            'type' => 'required|in:stock,cash,crypto,etf,bond,other',
        ]);

        $asset = Asset::create($validated);

        return response()->json([
            'message' => 'Asset created successfully.',
            'asset' => $asset,
        ], 201);
    }
}

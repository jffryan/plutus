<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Budget;

class BudgetController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'month' => 'required|date_format:Y-m-d',
            'notes' => 'nullable|string',
        ]);

        $budget = Budget::create([
            'user_id' => auth()->id(),
            'name' => $validated['name'],
            'month' => $validated['month'],
            'status' => 'draft',
            'notes' => $validated['notes'] ?? null,
        ]);

        return response()->json(['budget' => $budget], 201);
    }

    public function storeEnvelopes(Request $request, Budget $budget)
    {
        $this->authorize('update', $budget);

        $validated = $request->validate([
            'envelopes' => 'required|array|min:1',
            'envelopes.*.envelope_category_id' => 'required|exists:envelope_categories,id',
            'envelopes.*.expected_amount' => 'required|numeric|min:0',
        ]);

        $existing = $budget->envelopes()->pluck('envelope_category_id')->toArray();

        foreach ($validated['envelopes'] as $env) {
            $budget->envelopes()->updateOrCreate(
                ['envelope_category_id' => $env['envelope_category_id']],
                ['expected_amount' => $env['expected_amount']]
            );
        }

        return response()->json(['message' => 'Envelopes saved']);
    }

    public function activate(Budget $budget)
    {
        $this->authorize('update', $budget);

        if ($budget->status !== 'draft') {
            return response()->json(['error' => 'Only draft budgets can be activated'], 422);
        }

        if ($budget->envelopes()->count() === 0) {
            return response()->json(['error' => 'Cannot activate budget without envelopes'], 422);
        }

        $budget->update([
            'status' => 'active',
            'closed_at' => null,
        ]);

        return response()->json(['message' => 'Budget activated']);
    }
}

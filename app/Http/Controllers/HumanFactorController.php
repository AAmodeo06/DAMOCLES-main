<?php
// Realizzato da: Andrea Amodeo

namespace App\Http\Controllers;

use App\Models\HumanFactor;
use Illuminate\Http\Request;

class HumanFactorController extends Controller
{
    public function index()
    {
        $humanFactors = HumanFactor::with('vulnerabilities')->paginate(15);
        return view('human_factors.index', compact('humanFactors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string'
        ]);

        HumanFactor::create($validated);

        return redirect()->route('human-factor.index')->with('success', 'Human Factor creato con successo');
    }

    public function update(Request $request, HumanFactor $humanFactor)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string'
        ]);

        $humanFactor->update($validated);

        return redirect()->route('human-factor.index')->with('success', 'Human Factor aggiornato');
    }

    public function destroy(HumanFactor $humanFactor)
    {
        $humanFactor->delete();
        return redirect()->route('human-factor.index')->with('success', 'Human Factor eliminato');
    }
}

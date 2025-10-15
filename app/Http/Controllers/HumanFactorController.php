<?php

//REALIZZATO DA: Andrea Amodeo

namespace App\Http\Controllers;

use App\Models\HumanFactor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Enums\DebtLevel;

class HumanFactorController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->string('q')->toString();
        $humanFactors = HumanFactor::when($q, fn($qq)=>$qq->where('name','like',"%$q%"))
            ->orderBy('name')->paginate(12);

        return view('evaluator.human_factors.index', [
            'humanFactors' => $humanFactors,
            'q' => $q,
        ]);
    }

    // Crea HF
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:120'],
            'description' => ['nullable','string'],
        ]);

        HumanFactor::create([
            'name' => $data['name'],
            'slug' => Str::slug($data['name']),
            'description' => $data['description'] ?? null,
        ]);

        return back()->with('success','Human Factor creato.');
    }

    // Update HF
    public function update(Request $request, HumanFactor $humanFactor)
    {
        $data = $request->validate([
            'name' => ['required','string','max:120'],
            'description' => ['nullable','string'],
        ]);

        $humanFactor->update([
            'name' => $data['name'],
            'slug' => Str::slug($data['name']),
            'description' => $data['description'] ?? null,
        ]);

        return back()->with('success','Human Factor aggiornato.');
    }

    // Delete HF
    public function destroy(HumanFactor $humanFactor)
    {
        $humanFactor->delete();
        return back()->with('success','Human Factor eliminato.');
    }

    // Form assegnazione HF a un utente
    public function assignForm(User $user)
    {
        return view('evaluator.human_factors.assign', [
            'user' => $user,
            'factors' => HumanFactor::orderBy('name')->get(),
            'debtLabels' => DebtLevel::labels(),
        ]);
    }

    // Salva assegnazioni (pivot sync)
    public function assignStore(Request $request, User $user)
    {
        $data = $request->validate([
            'factors' => ['array'],
            'factors.*.id' => ['required','exists:human_factors,id'],
            'factors.*.debt_level' => ['required','in:none,low,medium,high,max'],
        ]);

        $sync = [];
        foreach (($data['factors'] ?? []) as $row) {
            $sync[$row['id']] = ['debt_level' => $row['debt_level']];
        }
        $user->humanFactors()->sync($sync);

        return redirect()->route('human-factors.assign', $user)->with('success','Human Factors assegnati.');
    }
}

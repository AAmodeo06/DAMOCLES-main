<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LLM;

class LLMController extends Controller
{
    public function index()
    {
        $llms = LLM::all();
        return view('llm.llm', compact('llms'));
    }

    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'endpoint' => ['required', 'string'],
            'provider' => ['required', 'string'],
            'model' => ['required', 'string'],
        ]);

        LLM::create($validatedData);

        return redirect()->route('llms.index')->with('success', 'LLM added successfully!');
    }

    public function update(Request $request, LLM $llm)
    {
        $validatedData = $request->validate([
            'endpoint' => ['required', 'string'],
            'provider' => ['required', 'string'],
            'model' => ['required', 'string'],
        ]);

        $llm->update($validatedData);

        return redirect()->route('llms.index')->with('success', 'LLM updated successfully!');
    }

    public function destroy(LLM $llm)
    {
        $llm->delete();

        return redirect()->route('llms.index')->with('success', 'LLM deleted successfully!');
    }
}

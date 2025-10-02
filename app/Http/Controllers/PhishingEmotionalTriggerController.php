<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PhishingEmotionalTrigger;

class PhishingEmotionalTriggerController extends Controller
{
    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'description' => ['required', 'string', 'max:255'],
            'tooltip' => ['required', 'string', 'max:255'],
        ]);

        PhishingEmotionalTrigger::create($validatedData);

        return redirect()->route('phishing-campaign.option')->with('success', 'Added successfully!');
    }

    public function destroy(PhishingEmotionalTrigger $emotionalTrigger)
    {
        $emotionalTrigger->delete();

        return redirect()->route('phishing-campaign.option')->with('success', 'Deleted successfully!');
    }
}

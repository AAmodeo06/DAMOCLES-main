<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PhishingContext;

class PhishingContextController extends Controller
{
    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'description' => ['required', 'string', 'max:255'],
        ]);

        PhishingContext::create($validatedData);

        return redirect()->route('phishing-campaign.option')->with('success', 'Added successfully!');
    }

    public function destroy(PhishingContext $context)
    {
        $context->delete();

        return redirect()->route('phishing-campaign.option')->with('success', 'Deleted successfully!');
    }
}

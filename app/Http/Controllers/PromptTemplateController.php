<?php
// Realizzato da: Andrea Amodeo

namespace App\Http\Controllers;

use App\Models\PromptTemplate;
use App\Models\User;
use App\Services\LLMService;
use Illuminate\Http\Request;

class PromptTemplateController extends Controller
{
    protected $llmService;

    public function __construct(LLMService $llmService)
    {
        $this->llmService = $llmService;
    }

    public function index(Request $request)
    {
        $contentType = $request->get('content_type', 'all');

        $templates = PromptTemplate::when($contentType !== 'all', function($query) use ($contentType) {
            return $query->where('content_type', $contentType);
        })->get();

        return view('prompt_templates.index', compact('templates', 'contentType'));
    }

    public function show(PromptTemplate $template)
    {
        return view('prompt_templates.show', compact('template'));
    }

    public function simulate(Request $request)
    {
        $validated = $request->validate([
            'template_id' => 'required|exists:prompt_templates,id',
            'fake_users' => 'required|array|min:1',
            'fake_users.*' => 'exists:users,id',
            'custom_instructions' => 'nullable|string|max:1000',
            'vulnerability_id' => 'required|exists:vulnerabilities,id',
        ]);

        $template = PromptTemplate::findOrFail($validated['template_id']);
        $fakeUsers = User::whereIn('id', $validated['fake_users'])
            ->where('isFake', true)
            ->with('humanFactors')
            ->get();

        $simulations = [];
        foreach ($fakeUsers as $user) {
            $content = $this->llmService->generateTrainingContent(
                $template,
                $user,
                $validated['vulnerability_id'],
                $validated['custom_instructions'] ?? ''
            );

            $simulations[] = [
                'user' => $user,
                'content' => $content,
            ];
        }
        session()->put('simulation_results', $simulations);
        session()->put('template_settings', $validated);

        return view('prompt_templates.simulate', compact('simulations', 'template'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Template;

class TemplateController extends Controller
{
    public function index()
    {
        $templates = auth()->user()->templates()->get();
        return response()->json($templates);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'tasks' => 'required|array',
        ]);

        $template = auth()->user()->templates()->create($validated);
        return response()->json($template, 201);
    }

    public function update(Request $request, Template $template)
    {
        $this->authorize('update', $template);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'tasks' => 'required|array',
        ]);

        $template->update($validated);
        return response()->json($template);
    }

    public function destroy(Template $template)
    {
        $this->authorize('delete', $template);
        $template->delete();
        return response()->json(null, 204);
    }
}

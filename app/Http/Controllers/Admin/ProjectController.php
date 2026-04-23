<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class ProjectController extends Controller
{
    public function index(): Response
    {
        $projects = Auth::user()->projects()->ordered()->get();
        return Inertia::render('admin/Projects', ['projects' => $projects]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['user_id'] = Auth::id();

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('projects', 'public');
        }

        $data['sort_order'] = (int) (Auth::user()->projects()->max('sort_order') ?? 0) + 1;

        Project::create($data);

        return back()->with('toast', ['type' => 'success', 'message' => 'Projeto criado.']);
    }

    public function update(Request $request, Project $project): RedirectResponse
    {
        $this->authorizeOwner($project);
        $data = $this->validated($request);

        if ($request->hasFile('image')) {
            if ($project->image_path) Storage::disk('public')->delete($project->image_path);
            $data['image_path'] = $request->file('image')->store('projects', 'public');
        }

        $project->update($data);

        return back()->with('toast', ['type' => 'success', 'message' => 'Projeto atualizado.']);
    }

    public function destroy(Project $project): RedirectResponse
    {
        $this->authorizeOwner($project);
        if ($project->image_path) Storage::disk('public')->delete($project->image_path);
        $project->delete();

        return back()->with('toast', ['type' => 'success', 'message' => 'Projeto removido.']);
    }

    protected function validated(Request $r): array
    {
        return $r->validate([
            'title'            => 'required|string|max:150',
            'description'      => 'nullable|string|max:500',
            'long_description' => 'nullable|string',
            'technologies'     => 'nullable|array',
            'technologies.*'   => 'string|max:40',
            'project_url'      => 'nullable|url|max:500',
            'github_url'       => 'nullable|url|max:500',
            'demo_url'         => 'nullable|url|max:500',
            'featured'         => 'boolean',
            'published'        => 'boolean',
            'image'            => 'nullable|image|max:4096',
        ]);
    }

    protected function authorizeOwner(Project $p): void
    {
        abort_unless($p->user_id === Auth::id(), 403);
    }
}

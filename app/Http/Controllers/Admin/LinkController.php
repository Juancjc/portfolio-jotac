<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Link;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class LinkController extends Controller
{
    public function index(): Response
    {
        $links = Auth::user()->links()->ordered()->get();

        return Inertia::render('admin/Links', ['links' => $links]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['user_id'] = Auth::id();
        $data['sort_order'] = (int) (Auth::user()->links()->max('sort_order') ?? 0) + 1;

        Link::create($data);

        return back()->with('toast', ['type' => 'success', 'message' => 'Link criado com sucesso.']);
    }

    public function update(Request $request, Link $link): RedirectResponse
    {
        $this->authorizeOwner($link);

        $link->update($this->validated($request));

        return back()->with('toast', ['type' => 'success', 'message' => 'Link atualizado.']);
    }

    public function destroy(Link $link): RedirectResponse
    {
        $this->authorizeOwner($link);
        $link->delete();

        return back()->with('toast', ['type' => 'success', 'message' => 'Link removido.']);
    }

    /**
     * Recebe um array [{ id, sort_order }, ...] vindo do drag-drop.
     */
    public function reorder(Request $request): RedirectResponse
    {
        $items = $request->validate([
            'items'              => 'required|array',
            'items.*.id'         => 'required|integer',
            'items.*.sort_order' => 'required|integer',
        ])['items'];

        DB::transaction(function () use ($items) {
            foreach ($items as $it) {
                Link::where('id', $it['id'])
                    ->where('user_id', Auth::id())
                    ->update(['sort_order' => $it['sort_order']]);
            }
        });

        return back();
    }

    protected function validated(Request $r): array
    {
        return $r->validate([
            'title'       => 'required|string|max:120',
            'description' => 'nullable|string|max:250',
            'icon'        => 'nullable|string|max:80',
            'type'        => 'required|in:internal,external',
            'url'         => 'required|string|max:500',
            'featured'    => 'boolean',
            'active'      => 'boolean',
        ]);
    }

    protected function authorizeOwner(Link $link): void
    {
        abort_unless($link->user_id === Auth::id(), 403);
    }
}

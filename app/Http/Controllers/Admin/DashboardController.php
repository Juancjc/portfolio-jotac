<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Link;
use App\Models\LinkClick;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function __invoke(): Response
    {
        $user = Auth::user();

        $stats = [
            'links_total'     => $user->links()->count(),
            'links_active'    => $user->links()->where('active', true)->count(),
            'projects_total'  => $user->projects()->count(),
            'projects_featured' => $user->projects()->where('featured', true)->count(),
            'clicks_total'    => Link::where('user_id', $user->id)->sum('clicks'),
            'clicks_7d'       => LinkClick::whereHas('link', fn ($q) => $q->where('user_id', $user->id))
                                  ->where('clicked_at', '>=', now()->subDays(7))
                                  ->count(),
        ];

        $topLinks = $user->links()
            ->orderByDesc('clicks')
            ->take(5)
            ->get(['id', 'title', 'clicks', 'type', 'url', 'active']);

        $recentProjects = Project::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get(['id', 'title', 'featured', 'published', 'image_path', 'created_at']);

        return Inertia::render('admin/Dashboard', compact('stats', 'topLinks', 'recentProjects'));
    }
}

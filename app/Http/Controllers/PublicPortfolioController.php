<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\Profile;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;
use Inertia\Response;

/**
 * Controller público — monta todos os dados da landing page do portfólio.
 */
class PublicPortfolioController extends Controller
{
    public function home(): Response
    {
        // Primeiro usuário cadastrado é o "dono" do portfólio.
        $user = User::query()
            ->with(['profile', 'banner', 'links' => fn ($q) => $q->active()->ordered()])
            ->first();

        $profile = $user?->profile ?? new Profile([
            'display_name' => 'Juan CJC',
            'headline'     => 'Full-Stack Developer & University Professor',
            'subtitle'     => 'Construindo produtos digitais com código limpo, design premium e performance obsessiva.',
            'bio'          => 'Desenvolvedor apaixonado por transformar ideias em experiências digitais de alto nível. Foco em arquiteturas Laravel + Vue, UI/UX moderna e soluções escaláveis.',
            'github_username' => 'Juancjc',
            'github_url'      => 'https://github.com/Juancjc',
            'email_contact'   => 'juancjc@yahoo.com',
            'location'        => 'Brasil',
            'tech_stack'      => ['Laravel', 'Vue 3', 'PrimeVue', 'TypeScript', 'Tailwind CSS', 'PostgreSQL', 'Redis', 'Docker'],
        ]);

        $banner = $user?->banner;

        $links = $user
            ? $user->links->map(fn (Link $l) => [
                'id'          => $l->id,
                'title'       => $l->title,
                'description' => $l->description,
                'icon'        => $l->icon,
                'type'        => $l->type,
                'url'         => $l->resolveUrl(),
                'featured'    => $l->featured,
            ])
            : collect();

        $projects = Project::query()
            ->when($user, fn ($q) => $q->where('user_id', $user->id))
            ->published()
            ->ordered()
            ->take(12)
            ->get();

        $githubStats = $profile?->githubHandle()
            ? $this->githubStats($profile->githubHandle())
            : null;

        return Inertia::render('public/Home', [
            'profile'     => $profile,
            'banner'      => $banner,
            'links'       => $links,
            'projects'    => $projects,
            'githubStats' => $githubStats,
            'meta'        => [
                'title'       => $profile?->seo_title ?: ($profile?->display_name . ' — Portfólio'),
                'description' => $profile?->seo_description ?: $profile?->subtitle,
            ],
        ]);
    }

    /**
     * Página dedicada estilo Linktree — só links, sem as outras seções.
     */
    public function links(): Response
    {
        $user = User::query()
            ->with(['profile', 'links' => fn ($q) => $q->active()->ordered()])
            ->first();

        $profile = $user?->profile;
        $githubStats = $profile?->githubHandle()
            ? $this->githubStats($profile->githubHandle())
            : null;
        $links = $user
            ? $user->links->map(fn (Link $l) => [
                'id'          => $l->id,
                'title'       => $l->title,
                'description' => $l->description,
                'icon'        => $l->icon,
                'type'        => $l->type,
                'url'         => $l->resolveUrl(),
                'featured'    => $l->featured,
            ])
            : collect();

        return Inertia::render('public/Links', [
            'profile' => $profile,
            'links'   => $links,
            'stats' => $githubStats,
            'meta'    => [
                'title'       => ($profile?->display_name ?? 'Juan Carlos') . ' — Links',
                'description' => $profile?->subtitle ?? 'Todos os meus links em um só lugar.',
            ],
        ]);
    }

    /**
     * Redireciona e registra click no link.
     */
    public function trackLink(Request $request, Link $link): RedirectResponse
    {
        abort_unless($link->active, 404);

        $link->increment('clicks');
        $link->clicksLog()->create([
            'referrer'   => $request->headers->get('referer'),
            'ip'         => $request->ip(),
            'user_agent' => substr((string) $request->userAgent(), 0, 250),
        ]);

        return redirect()->away($link->resolveUrl());
    }

    /**
     * Estatísticas do GitHub (cached 30min).
     */
    protected function githubStats(string $username): array
    {
        return Cache::remember("github:$username", now()->addMinutes(30), function () use ($username) {
            try {
                $resp = Http::acceptJson()
                    ->timeout(5)
                    ->get("https://api.github.com/users/{$username}");

                if (! $resp->ok()) {
                    return $this->githubFallback($username);
                }
                $d = $resp->json();
                return [
                    'username'    => $d['login'] ?? $username,
                    'name'        => $d['name'] ?? null,
                    'avatar'      => $d['avatar_url'] ?? null,
                    'bio'         => $d['bio'] ?? null,
                    'repos'       => (int) ($d['public_repos'] ?? 0),
                    'followers'   => (int) ($d['followers'] ?? 0),
                    'following'   => (int) ($d['following'] ?? 0),
                    'gists'       => (int) ($d['public_gists'] ?? 0),
                    'url'         => $d['html_url'] ?? "https://github.com/{$username}",
                    'company'     => $d['company'] ?? null,
                    'location'    => $d['location'] ?? null,
                ];
            } catch (\Throwable) {
                return $this->githubFallback($username);
            }
        });
    }

    protected function githubFallback(string $u): array
    {
        return [
            'username'  => $u,
            'name'      => null,
            'avatar'    => null,
            'bio'       => null,
            'repos'     => 0,
            'followers' => 0,
            'following' => 0,
            'gists'     => 0,
            'url'       => "https://github.com/{$u}",
            'company'   => null,
            'location'  => null,
        ];
    }
}

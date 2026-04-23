<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    public function edit(): Response
    {
        $profile = Auth::user()->profile ?? new Profile(['user_id' => Auth::id()]);
        return Inertia::render('admin/Profile', ['profile' => $profile]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'display_name'     => 'required|string|max:120',
            'headline'         => 'nullable|string|max:150',
            'subtitle'         => 'nullable|string|max:250',
            'bio'              => 'nullable|string|max:2000',
            'github_username'  => 'nullable|string|max:60',
            'github_url'       => 'nullable|url|max:250',
            'linkedin_url'     => 'nullable|url|max:250',
            'instagram_url'    => 'nullable|url|max:250',
            'twitter_url'      => 'nullable|url|max:250',
            'email_contact'    => 'nullable|email|max:150',
            'location'         => 'nullable|string|max:150',
            'tech_stack'       => 'nullable|array',
            'tech_stack.*'     => 'string|max:40',
            'experiences'      => 'nullable|array',
            'experiences.*.role'    => 'required_with:experiences|string|max:150',
            'experiences.*.company' => 'nullable|string|max:150',
            'experiences.*.period'  => 'nullable|string|max:80',
            'experiences.*.desc'    => 'nullable|string|max:500',
            'seo_title'        => 'nullable|string|max:70',
            'seo_description'  => 'nullable|string|max:170',
            'avatar'           => 'nullable|image|max:4096',
            'theme_accent'     => 'nullable|string|max:16',
        ]);

        $profile = Auth::user()->profile ?? Profile::make(['user_id' => Auth::id()]);

        if ($request->hasFile('avatar')) {
            if ($profile->avatar_path) Storage::disk('public')->delete($profile->avatar_path);
            $data['avatar_path'] = $request->file('avatar')->store('avatars', 'public');
        }

        $profile->fill($data);
        $profile->user_id = Auth::id();
        $profile->save();

        return back()->with('toast', ['type' => 'success', 'message' => 'Perfil atualizado com sucesso.']);
    }
}

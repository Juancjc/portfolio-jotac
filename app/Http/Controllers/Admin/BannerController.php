<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class BannerController extends Controller
{
    public function edit(): Response
    {
        $banner = Auth::user()->banner()->first() ?? new Banner([
            'user_id' => Auth::id(),
            'active'  => true,
            'overlay_opacity' => 40,
            'overlay_color'   => '#000000',
        ]);

        return Inertia::render('admin/Banner', ['banner' => $banner]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title'           => 'nullable|string|max:150',
            'subtitle'        => 'nullable|string|max:250',
            'cta_label'       => 'nullable|string|max:80',
            'cta_url'         => 'nullable|url|max:500',
            'overlay_color'   => 'nullable|string|max:24',
            'overlay_opacity' => 'nullable|integer|min:0|max:100',
            'active'          => 'boolean',
            'image'           => 'nullable|image|max:8192',
        ]);

        $banner = Auth::user()->banner()->first() ?? Banner::make(['user_id' => Auth::id()]);

        if ($request->hasFile('image')) {
            if ($banner->image_path) Storage::disk('public')->delete($banner->image_path);
            $data['image_path'] = $request->file('image')->store('banners', 'public');
        }

        $banner->fill($data);
        $banner->user_id = Auth::id();
        $banner->save();

        return back()->with('toast', ['type' => 'success', 'message' => 'Banner atualizado.']);
    }

    public function destroy(): RedirectResponse
    {
        $banner = Auth::user()->banner()->first();
        if ($banner) {
            if ($banner->image_path) Storage::disk('public')->delete($banner->image_path);
            $banner->delete();
        }
        return back()->with('toast', ['type' => 'success', 'message' => 'Banner removido.']);
    }
}

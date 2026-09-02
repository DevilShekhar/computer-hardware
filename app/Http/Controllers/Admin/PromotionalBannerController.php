<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PromotionalBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PromotionalBannerController extends Controller
{
    public function index()
    {
        $promotionalBanners = PromotionalBanner::with(['createdBy', 'updatedBy'])->latest()->get();
        return view('admin.promotional-banners.index', compact('promotionalBanners'));
    }

    public function create()
    {
        return view('admin.promotional-banners.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'short_description' => ['nullable', 'string'],
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'button_text' => ['nullable', 'string', 'max:100'],
            'button_url' => ['nullable', 'string', 'max:500'],
        ], [
            'image.required' => 'Banner image is required.',
            'image.image' => 'The banner image must be an image.',
            'image.mimes' => 'Banner image must be JPG, JPEG, PNG or WEBP.',
            'image.max' => 'Banner image must not be larger than 2MB.',
        ]);
        $bannerImage = null;
        if ($request->hasFile('image')) {
            $bannerImage = $request->file('image')->store('promotional_banners', 'public');
        }
        PromotionalBanner::create([
            'title' => $request->title,
            'short_description' => $request->short_description,
            'image' => $bannerImage,
            'button_text' => $request->button_text,
            'button_url' => $request->button_url,
            'status' => 1,
            'created_by' => Auth::id(),
        ]);
        return redirect()->route('promotional-banners.index')->with('success', 'Promotional banner created successfully.');
    }

    public function show(PromotionalBanner $promotionalBanner)
    {
        $promotionalBanner->load(['createdBy', 'updatedBy']);
        return view('admin.promotional-banners.show',compact('promotionalBanner'));
    }

    public function edit(PromotionalBanner $promotionalBanner)
    {
        return view('admin.promotional-banners.edit',compact('promotionalBanner'));
    }

    public function update(Request $request, PromotionalBanner $promotionalBanner)
    {
        $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'short_description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'button_text' => ['nullable', 'string', 'max:100'],
            'button_url' => ['nullable', 'string', 'max:500'],
            'status' => ['required', 'boolean'],
        ], [
            'image.image' => 'The banner image must be an image.',
            'image.mimes' => 'Banner image must be JPG, JPEG, PNG or WEBP.',
            'image.max' => 'Banner image must not be larger than 2MB.',
            'status.required' => 'Status is required.',
        ]);
        $bannerImage = $promotionalBanner->image;
        if ($request->hasFile('image')) {
            if ($bannerImage && Storage::disk('public')->exists($bannerImage)) {
                Storage::disk('public')->delete($bannerImage);
            }
            $bannerImage = $request->file('image')->store('promotional_banners', 'public');
        }
        $promotionalBanner->update([
            'title' => $request->title,
            'short_description' => $request->short_description,
            'image' => $bannerImage,
            'button_text' => $request->button_text,
            'button_url' => $request->button_url,
            'status' => $request->boolean('status'),
            'updated_by' => Auth::id(),
        ]);
        return redirect()->route('promotional-banners.index')->with('success', 'Promotional banner updated successfully.');
    }

    public function destroy(PromotionalBanner $promotionalBanner)
    {
        $promotionalBanner->update([
            'status' => 0,
            'updated_by' => Auth::id(),
        ]);
        return redirect()->route('promotional-banners.index')->with('success', 'Promotional banner deactivated successfully.');
    }
    public function activate(PromotionalBanner $promotionalBanner)
    {
        $promotionalBanner->update([
            'status' => 1,
            'updated_by' => Auth::id(),
        ]);
        return redirect()->route('promotional-banners.index')->with('success', 'Promotional banner activated successfully.');
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BuilderType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BuilderTypeController extends Controller
{
    public function index(Request $request)
    {
        $query = BuilderType::query();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('slug', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $builderTypes = $query
            ->latest()
            ->paginate(20);

        return view('admin.builder-types.index', compact('builderTypes'));
    }

    public function create()
    {
        return view('admin.builder-types.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:builder_types,name',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'description' => 'nullable|string',
            'meta_title' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'meta_description' => 'nullable|string',
        ]);

        $image = null;

        if ($request->hasFile('image')) {
            $image = $request
                ->file('image')
                ->store('builder-types', 'public');
        }

        $slug = Str::slug($request->name);

        if (BuilderType::where('slug', $slug)->exists()) {
            $slug .= '-' . time();
        }

        BuilderType::create([
            'name' => $request->name,
            'slug' => $slug,
            'image' => $image,
            'description' => $request->description,
            'meta_title' => $request->meta_title,
            'meta_keywords' => $request->meta_keywords,
            'meta_description' => $request->meta_description,
            'status' => 1,
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
        ]);

        return redirect()
            ->route('builder-types.index')
            ->with('success', 'Builder type created successfully.');
    }

    public function show(BuilderType $builderType)
    {
        return view('admin.builder-types.show', compact('builderType'));
    }

    public function edit(BuilderType $builderType)
    {
        return view('admin.builder-types.edit', compact('builderType'));
    }

    public function update(Request $request, BuilderType $builderType)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:builder_types,name,' . $builderType->id,
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'description' => 'nullable|string',
            'meta_title' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'status' => 'required|boolean',
        ]);

        $data = [
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'meta_title' => $request->meta_title,
            'meta_keywords' => $request->meta_keywords,
            'meta_description' => $request->meta_description,
            'status' => $request->boolean('status'),
            'updated_by' => Auth::id(),
        ];

        $slugExists = BuilderType::where('slug', $data['slug'])
            ->where('id', '!=', $builderType->id)
            ->exists();

        if ($slugExists) {
            $data['slug'] .= '-' . time();
        }

        if ($request->hasFile('image')) {
            $data['image'] = $request
                ->file('image')
                ->store('builder-types', 'public');
        }

        $builderType->update($data);

        return redirect()
            ->route('builder-types.index')
            ->with('success', 'Builder type updated successfully.');
    }

    public function destroy(BuilderType $builderType)
    {
        $builderType->update([
            'status' => 0,
            'updated_by' => Auth::id(),
        ]);

        return redirect()
            ->route('builder-types.index')
            ->with('success', 'Builder type deactivated successfully.');
    }
}
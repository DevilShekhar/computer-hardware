<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\BuilderBrand;
use App\Models\BuilderType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class BuilderBrandController extends Controller
{
    /**
     * Display builder brands.
     */
    public function index()
    {
        $builderBrands = BuilderBrand::with('builderType')
            ->latest()
            ->get();

        return view(
            'admin.builder_brands.index',
            compact('builderBrands')
        );
    }

    /**
     * Show create form.
     */
    public function create()
    {
        $builderTypes = BuilderType::where('status', 1)
            ->orderBy('name')
            ->get();

        return view(
            'admin.builder_brands.create',
            compact('builderTypes')
        );
    }

    /**
     * Store builder brand.
     */
    public function store(Request $request)
    {
        $request->validate([
            'builder_type_id' => [
                'required',
                'exists:builder_types,id',
            ],

            'name' => [
                'required',
                'string',
                'max:255',

                // Brand name must be unique inside selected builder type
                Rule::unique('builder_brands', 'name')
                    ->where(function ($query) use ($request) {
                        return $query->where(
                            'builder_type_id',
                            $request->builder_type_id
                        );
                    }),
            ],

            'brand_image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'meta_title' => [
                'nullable',
                'string',
            ],

            'meta_keyword' => [
                'nullable',
                'string',
            ],

            'meta_description' => [
                'nullable',
                'string',
            ],
        ], [
            'builder_type_id.required' => 'Builder type is required.',
            'builder_type_id.exists' => 'Selected builder type is invalid.',

            'name.required' => 'Brand name is required.',
            'name.unique' => 'This brand already exists under the selected builder type.',

            'brand_image.image' => 'The brand image must be an image.',
            'brand_image.mimes' => 'Brand image must be JPG, JPEG, PNG or WEBP.',
            'brand_image.max' => 'Brand image must not be larger than 2MB.',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Upload Brand Image
        |--------------------------------------------------------------------------
        */

        $brandImage = null;

        if ($request->hasFile('brand_image')) {
            $brandImage = $request
                ->file('brand_image')
                ->store('builder_brands', 'public');
        }

        /*
        |--------------------------------------------------------------------------
        | Generate Slug
        |--------------------------------------------------------------------------
        */

        $slug = Str::slug($request->name);

        $slugExists = BuilderBrand::where('slug', $slug)
            ->where(
                'builder_type_id',
                $request->builder_type_id
            )
            ->exists();

        if ($slugExists) {
            $slug .= '-' . time();
        }

        /*
        |--------------------------------------------------------------------------
        | Create Builder Brand
        |--------------------------------------------------------------------------
        */

        BuilderBrand::create([
            'builder_type_id' => $request->builder_type_id,
            'name' => $request->name,
            'slug' => $slug,
            'brand_image' => $brandImage,
            'status' => 1,
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
            'meta_title' => $request->meta_title,
            'meta_keyword' => $request->meta_keyword,
            'meta_description' => $request->meta_description,
        ]);

        return redirect()
            ->route('builder-brands.index')
            ->with(
                'success',
                'PC Builder brand created successfully.'
            );
    }

    /**
     * Display builder brand.
     */
    public function show(BuilderBrand $builderBrand)
    {
        $builderBrand->load('builderType');

        return view(
            'admin.builder_brands.show',
            compact('builderBrand')
        );
    }

    /**
     * Show edit form.
     */
    public function edit(BuilderBrand $builderBrand)
    {
        $builderTypes = BuilderType::where('status', 1)
            ->orderBy('name')
            ->get();

        return view(
            'admin.builder_brands.edit',
            compact(
                'builderBrand',
                'builderTypes'
            )
        );
    }

    /**
     * Update builder brand.
     */
    public function update(
        Request $request,
        BuilderBrand $builderBrand
    ) {
        $request->validate([
            'builder_type_id' => [
                'required',
                'exists:builder_types,id',
            ],

            'name' => [
                'required',
                'string',
                'max:255',

                // Unique brand name within selected builder type
                Rule::unique('builder_brands', 'name')
                    ->where(function ($query) use ($request) {
                        return $query->where(
                            'builder_type_id',
                            $request->builder_type_id
                        );
                    })
                    ->ignore($builderBrand->id),
            ],

            'status' => [
                'required',
                'boolean',
            ],

            'brand_image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'meta_title' => [
                'nullable',
                'string',
            ],

            'meta_keyword' => [
                'nullable',
                'string',
            ],

            'meta_description' => [
                'nullable',
                'string',
            ],
        ], [
            'builder_type_id.required' => 'Builder type is required.',
            'builder_type_id.exists' => 'Selected builder type is invalid.',

            'name.required' => 'Brand name is required.',
            'name.unique' => 'This brand already exists under the selected builder type.',

            'status.required' => 'Status is required.',

            'brand_image.image' => 'The brand image must be an image.',
            'brand_image.mimes' => 'Brand image must be JPG, JPEG, PNG or WEBP.',
            'brand_image.max' => 'Brand image must not be larger than 2MB.',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Existing Brand Image
        |--------------------------------------------------------------------------
        */

        $brandImage = $builderBrand->brand_image;

        /*
        |--------------------------------------------------------------------------
        | Replace Brand Image
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('brand_image')) {
            if (
                $brandImage &&
                Storage::disk('public')->exists($brandImage)
            ) {
                Storage::disk('public')->delete($brandImage);
            }

            $brandImage = $request
                ->file('brand_image')
                ->store('builder_brands', 'public');
        }

        /*
        |--------------------------------------------------------------------------
        | Generate Slug
        |--------------------------------------------------------------------------
        */

        $slug = Str::slug($request->name);

        $slugExists = BuilderBrand::where('slug', $slug)
            ->where(
                'builder_type_id',
                $request->builder_type_id
            )
            ->where(
                'id',
                '!=',
                $builderBrand->id
            )
            ->exists();

        if ($slugExists) {
            $slug .= '-' . time();
        }

        /*
        |--------------------------------------------------------------------------
        | Update Builder Brand
        |--------------------------------------------------------------------------
        */

        $builderBrand->update([
            'builder_type_id' => $request->builder_type_id,
            'name' => $request->name,
            'slug' => $slug,
            'brand_image' => $brandImage,
            'status' => $request->boolean('status'),
            'updated_by' => Auth::id(),
            'meta_title' => $request->meta_title,
            'meta_keyword' => $request->meta_keyword,
            'meta_description' => $request->meta_description,
        ]);

        return redirect()
            ->route('builder-brands.index')
            ->with(
                'success',
                'PC Builder brand updated successfully.'
            );
    }

    /**
     * Deactivate builder brand.
     */
    public function destroy(BuilderBrand $builderBrand)
    {
        $builderBrand->update([
            'status' => 0,
            'updated_by' => Auth::id(),
        ]);

        return redirect()
            ->route('builder-brands.index')
            ->with(
                'success',
                'PC Builder brand deactivated successfully.'
            );
    }

    /**
     * Activate builder brand.
     */
    public function activate(BuilderBrand $builderBrand)
    {
        $builderBrand->update([
            'status' => 1,
            'updated_by' => Auth::id(),
        ]);

        return redirect()
            ->route('builder-brands.index')
            ->with(
                'success',
                'PC Builder brand activated successfully.'
            );
    }
}
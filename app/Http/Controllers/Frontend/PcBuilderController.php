<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\BuilderType;

class PcBuilderController extends Controller
{
    public function index()
    {
        $builderTypes = BuilderType::query()
            ->where('status', true)
            ->orderBy('name', 'asc')
            ->get();

        return view('frontend.pc-builder.index', compact('builderTypes'));
    }

    public function show($slug)
    {
        $builderType = BuilderType::query()
            ->where('slug', $slug)
            ->where('status', true)
            ->firstOrFail();

        return view('frontend.pc-builder.show', compact('builderType'));
    }
}
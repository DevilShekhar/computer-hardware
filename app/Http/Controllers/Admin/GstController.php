<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gst;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GstController extends Controller
{
    public function index()
    {
        $gst = Gst::latest()->first();
        return view('admin.gsts.index', compact('gst'));
    }

    public function create()
    {
        if (Gst::exists()) {
            return redirect()->route('gsts.index')
                ->with('error', 'GST record already exists. You can edit the existing GST.');
        }
        return view('admin.gsts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'gst_amount' => ['required', 'numeric', 'min:0', 'max:100'],
        ]);
        // Extra protection against duplicate records
        if (Gst::exists()) {
            return redirect()
                ->route('gsts.index')
                ->with('error', 'GST record already exists. Please edit the existing record.');
        }
        Gst::create([
            'gst_amount' => $request->gst_amount,
            'status' => 1,
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
        ]);
        return redirect()->route('gsts.index')
            ->with('success', 'GST created successfully.');
    }
    public function show(Gst $gst)
    {
        return view('admin.gsts.show', compact('gst'));
    }
    public function edit(Gst $gst)
    {
        return view('admin.gsts.edit', compact('gst'));
    }
    public function update(Request $request, Gst $gst)
    {
        $request->validate([
            'gst_amount' => ['required', 'numeric', 'min:0', 'max:100'],
            'status' => ['required', 'boolean'],
        ]);
        $gst->update([
            'gst_amount' => $request->gst_amount,
            'status' => $request->status,
            'updated_by' => Auth::id(),
        ]);
        return redirect()->route('gsts.index')->with('success', 'GST updated successfully.');
    }
}
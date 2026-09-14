<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PcBuilder;
use Illuminate\Http\Request;

class MyPcBuilderOrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = PcBuilder::where('user_id', $request->user()->id)
            ->latest('created_at')
            ->get();

        return view('admin.my-pc-builder-orders.index', compact('orders'));
    }

    public function show(Request $request, PcBuilder $pcBuilder)
    {
        abort_unless($pcBuilder->user_id === $request->user()->id, 403);
        $pcBuilder->load('statusHistories.updatedBy');
        return view('admin.my-pc-builder-orders.show', compact('pcBuilder'));
    }
}

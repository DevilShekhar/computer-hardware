@can('best-seller-items')
@extends('admin.layouts.app')
@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Best Selling Products</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-1">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Image</th>
                                        <th>Product Brand</th>
                                        <th>Category</th>
                                        <th>Sub Category</th>
                                        <th>Product Name</th>
                                        <th>SKU</th>
                                        <th>Price</th>
                                        <th>Total Sold</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($products as $product)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>

                                        <td>
                                            @if($product->images->first())
                                            <img src="{{ asset('storage/' . $product->images->first()->image) }}"
                                                alt="{{ $product->name }}"
                                                width="45"
                                                height="45"
                                                class="rounded"
                                                style="object-fit:cover;">
                                            @else
                                            <img src="{{ asset('assets/img/default.png') }}"
                                                alt="image"
                                                width="45"
                                                height="45"
                                                class="rounded"
                                                style="object-fit:cover;">
                                            @endif
                                        </td>

                                        <td>{{ $product->productBrand->name ?? '-' }}</td>

                                        <td>{{ $product->category->name ?? '-' }}</td>

                                        <td>{{ $product->subCategory->name ?? '-' }}</td>

                                        <td>
                                            <strong>{{ $product->name }}</strong>

                                            @if($loop->iteration <= 6 && $product->total_sold > 0)
                                            <p class="text-success mb-0">
                                                <small><strong>Best Seller</strong></small>
                                            </p>
                                            @endif
                                        </td>

                                        <td>{{ $product->sku }}</td>

                                        <td>
                                            @if($product->sale_price)
                                                <strong>
                                                    ₹{{ number_format($product->sale_price, 2) }}
                                                </strong>
                                                <br>
                                                <small class="text-muted">
                                                    <del>
                                                        ₹{{ number_format($product->price, 2) }}
                                                    </del>
                                                </small>

                                                @if($product->is_discounted)
                                                    <p class="text-success mb-0">
                                                        <small>On Discount</small>
                                                    </p>
                                                @endif
                                            @else
                                                <strong>
                                                    ₹{{ number_format($product->price, 2) }}
                                                </strong>
                                            @endif
                                        </td>

                                        <td>
                                            <strong>{{ $product->total_sold }}</strong>
                                        </td>

                                        <td>
                                            @if($product->status)
                                            <span class="badge badge-success badge-shadow">
                                                Active
                                            </span>
                                            @else
                                            <span class="badge badge-danger badge-shadow">
                                                Inactive
                                            </span>
                                            @endif
                                        </td>

                                        <td>
                                            {{ $product->created_at ? $product->created_at->format('d-m-Y') : '-' }}
                                        </td>
                                    </tr>

                                    @empty
                                    <tr>
                                        <td colspan="12" class="text-center">
                                            No products found.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
$(document).ready(function(){
    $('#table-1').DataTable({
        ordering:true,
        searching:true,
        paging:true,
        info:true,
        pageLength:10,
        lengthMenu:[[10,25,50,100,-1],[10,25,50,100,'All']],
        columnDefs:[{orderable:false,targets:[0,1]}]
    });
});
</script>
@endpush
@else
    @php
        abort(404);
    @endphp
@endcan

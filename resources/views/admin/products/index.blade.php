@extends('admin.layouts.app')
@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Product Listing</h4>
                        <div class="card-header-action">
                            <a href="{{ route('products.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Add Product
                            </a>
                        </div>
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
                                        <th>Stock</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($products as $product)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>
                                            @if($product->images->first())
                                            <img src="{{ asset('storage/' . $product->images->first()->image) }}" alt="{{ $product->name }}" width="45" height="45" class="rounded" style="object-fit:cover;">
                                            @else
                                            <img src="{{ asset('assets/img/default.png') }}" alt="image" width="45" height="45" class="rounded" style="object-fit:cover;">
                                            @endif
                                        </td>
                                        <td>{{ $product->productBrand->name ?? '-' }}</td>
                                        <td>{{ $product->category->name ?? '-' }}</td>
                                        <td>{{ $product->subCategory->name ?? '-' }}</td>
                                        <td><strong>{{ $product->name }}</strong></td>
                                        <td>{{ $product->sku }}</td>
                                        <td>
                                            ₹{{ number_format($product->price, 2) }}
                                            @if($product->sale_price)
                                            <br><small class="text-success">Sale: ₹{{ number_format($product->sale_price, 2) }}</small>
                                            @endif
                                        </td>
                                        <td>{{ $product->stock_quantity }}</td>
                                        <td>
                                            @if($product->status)
                                            <span class="badge badge-success badge-shadow">Active</span>
                                            @else
                                            <span class="badge badge-danger badge-shadow">Inactive</span>
                                            @endif
                                        </td>
                                        <td>{{ $product->created_at ? $product->created_at->format('d-m-Y') : '-' }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <a href="{{ route('products.show', $product->id) }}" class="btn btn-info btn-sm mr-1" title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary btn-sm mr-1" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                @if($product->status)
                                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="delete-product-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" title="Deactivate">
                                                        <i class="fas fa-ban"></i>
                                                    </button>
                                                </form>
                                                @else
                                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-success btn-sm" title="Activate">
                                                    <i class="fas fa-check"></i>
                                                </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="12" class="text-center">No products found.</td>
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
$(document).ready(function() {
    $('#table-1').DataTable({
        ordering:true,
        searching:true,
        paging:true,
        info:true,
        pageLength:10,
        lengthMenu:[[10,25,50,100,-1],[10,25,50,100,'All']],
        columnDefs:[{orderable:false,targets:[0,1,11]}]
    });
    $('.delete-product-form').on('submit',function(e){
        e.preventDefault();
        let form=this;
        Swal.fire({
            title:'Are you sure?',
            text:'This product will be deactivated.',
            icon:'warning',
            showCancelButton:true,
            confirmButtonColor:'#fc544b',
            cancelButtonColor:'#6777ef',
            confirmButtonText:'Yes, deactivate',
            cancelButtonText:'Cancel'
        }).then(function(result){
            if(result.isConfirmed){
                form.submit();
            }
        });
    });
});
</script>
@if(session('success'))
<script>
Swal.fire({
    title:'Success!',
    text:@json(session('success')),
    icon:'success',
    confirmButtonColor:'#6777ef',
    confirmButtonText:'OK'
});
</script>
@endif
@endpush
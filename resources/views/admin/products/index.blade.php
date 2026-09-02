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
                                            @if($product->stock_quantity > 10)
                                            <span class="badge badge-success badge-shadow">{{ $product->stock_quantity }}</span>
                                            @elseif($product->stock_quantity > 0)
                                            <span class="badge badge-warning badge-shadow">{{ $product->stock_quantity }}</span>
                                            @else
                                            <span class="badge badge-danger badge-shadow">Out of Stock</span>
                                            @endif
                                        </td>
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
                                                <button type="button" class="btn btn-success btn-sm mr-1 add-stock-btn" data-id="{{ $product->id }}" data-name="{{ $product->name }}" data-sku="{{ $product->sku }}" data-stock="{{ $product->stock_quantity }}" data-url="{{ route('products.add-stock', $product->id) }}" title="Add Stock">
                                                    <i class="fas fa-boxes"></i>
                                                </button>
                                                <a href="{{ route('products.inventory-history', ['product' => $product->id]) }}"
                                                    class="btn btn-warning btn-sm mr-1"
                                                    title="Inventory History">
                                                        <i class="fas fa-history"></i>
                                                </a>
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

<div class="modal fade" id="addStockModal" tabindex="-1" role="dialog" aria-labelledby="addStockModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addStockModalLabel">
                    <i class="fas fa-boxes"></i> Manage Product Stock
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addStockForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-light">
                        <div class="mb-1">
                            <strong>Product:</strong>
                            <span id="stockProductName"></span>
                        </div>
                        <div class="mb-1">
                            <strong>SKU:</strong>
                            <span id="stockProductSku"></span>
                        </div>
                        <div>
                            <strong>Current Stock:</strong>
                            <span id="currentStock" class="badge badge-info"></span>
                        </div>
                    </div>
                    <div class="form-group" style="display: none">
                        <label>Stock Action <span class="text-danger">*</span></label>
                        <select name="stock_action" id="stockAction" class="form-control" required>
                            <option value="add">Add Stock</option>
                            <option value="update">Update Stock</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Quantity <span class="text-danger">*</span></label>
                        <input type="number" name="quantity" id="stockQuantity" class="form-control" min="0" required placeholder="Enter quantity">
                    </div>
                    <div class="form-group">
                        <label>Reason</label>
                        <textarea name="reason" class="form-control" rows="3" placeholder="Enter stock update reason"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success" id="stockSubmitBtn">
                        <i class="fas fa-plus"></i> Add Stock
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
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
        columnDefs:[{orderable:false,targets:[0,1,11]}]
    });

    $('.add-stock-btn').on('click',function(){
        let productName=$(this).data('name');
        let productSku=$(this).data('sku');
        let currentStock=$(this).data('stock');
        let actionUrl=$(this).data('url');

        $('#addStockForm')[0].reset();
        $('#stockProductName').text(productName);
        $('#stockProductSku').text(productSku);
        $('#currentStock').text(currentStock);
        $('#addStockForm').attr('action',actionUrl);
        $('#stockAction').val('add');
        $('#stockSubmitBtn').html('<i class="fas fa-plus"></i> Add Stock');
        $('#addStockModal').modal('show');
    });

    $('#stockAction').on('change',function(){
        if($(this).val()==='add'){
            $('#stockSubmitBtn').html('<i class="fas fa-plus"></i> Add Stock');
        }else{
            $('#stockSubmitBtn').html('<i class="fas fa-save"></i> Update Stock');
        }
    });

   $('.inventory-history-btn').on('click', function () {

    let productId = $(this).data('product-id');
    let productName = $(this).data('product-name');
    let historyUrl = $(this).data('url');

    $('#historyProductName').text(productName);
    $('#historyProductSku').text('-');
    $('#historyCurrentStock').text('-');

    $('#stockHistoryBody').html(
        '<tr><td colspan="7" class="text-center">Loading...</td></tr>'
    );

    $('#stockHistoryModal').modal('show');

    $.ajax({
        url: historyUrl,
        type: 'GET',

        success: function (response) {

            $('#historyProductName').text(response.product);
            $('#historyProductSku').text(response.sku);
            $('#historyCurrentStock').text(response.current_stock);

            if (!response.history || response.history.length === 0) {
                $('#stockHistoryBody').html(
                    '<tr>' +
                    '<td colspan="7" class="text-center">' +
                    'No stock history found.' +
                    '</td>' +
                    '</tr>'
                );
                return;
            }

            let html = '';

            $.each(response.history, function (index, item) {

                let badgeClass = item.type === 'add'
                    ? 'badge-success'
                    : 'badge-warning';

                let quantityText = item.type === 'add'
                    ? '+' + item.quantity
                    : item.quantity;

                html += `
                    <tr>
                        <td>${index + 1}</td>

                        <td>${item.created_at ?? '-'}</td>

                        <td>
                            <span class="badge ${badgeClass}">
                                ${quantityText}
                            </span>
                        </td>

                        <td>${item.previous_stock ?? 0}</td>

                        <td>
                            <strong>${item.new_stock ?? 0}</strong>
                        </td>

                        <td>${item.reason ?? '-'}</td>

                        <td>${item.created_by ?? 'Admin'}</td>
                    </tr>
                `;
            });

            $('#stockHistoryBody').html(html);
        },

        error: function (xhr) {

            console.log(xhr.responseText);

            $('#stockHistoryBody').html(
                '<tr>' +
                '<td colspan="7" class="text-center text-danger">' +
                'Unable to load stock history.' +
                '</td>' +
                '</tr>'
            );
        }
    });
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

@if(session('success'))
Swal.fire({
    title:'Success!',
    text:@json(session('success')),
    icon:'success',
    confirmButtonColor:'#6777ef',
    confirmButtonText:'OK'
});
@endif
</script>
@endpush

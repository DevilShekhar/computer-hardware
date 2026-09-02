@extends('admin.layouts.app')
@section('title', 'Inventory History')


        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">

        <style>
            .select2-container {
                width: 100% !important
            }

            .select2-container .select2-selection--single {
                height: 42px;
                border: 1px solid #e4e6fc;
                border-radius: 4px
            }

            .select2-container--default .select2-selection--single .select2-selection__rendered {
                line-height: 40px;
                padding-left: 12px;
                color: #495057;
                font-size: 14px
            }

            .select2-container--default .select2-selection--single .select2-selection__arrow {
                height: 40px;
                right: 8px
            }

            .select2-container--default.select2-container--focus .select2-selection--single {
                border-color: #6777ef;
                box-shadow: 0 0 0 2px rgba(103, 119, 239, .1)
            }

            .select2-dropdown {
                border: 1px solid #e4e6fc;
                border-radius: 4px;
                box-shadow: 0 4px 15px rgba(0, 0, 0, .08)
            }

            .select2-container--default .select2-search--dropdown .select2-search__field {
                border: 1px solid #e4e6fc;
                border-radius: 4px;
                padding: 7px 10px
            }

            .select2-container--default .select2-results__option {
                padding: 8px 12px;
                font-size: 14px
            }

            .select2-container--default .select2-results__option--highlighted[aria-selected] {
                background: #6777ef
            }
        </style>

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Product Inventory History</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item">Inventory</div>
                <div class="breadcrumb-item active">History</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">

                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4><i class="fas fa-box mr-2"></i>Select Product</h4>
                        </div>

                        <div class="card-body">
                            <div class="form-group mb-0">
                                <label for="productSelect">Product</label>

                                <select id="productSelect" class="form-control">
                                    <option value="">All Products</option>

                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" {{ ($selectedProduct ?? '') == $product->id ? 'selected' : '' }}>
                                            {{ $product->name }} - SKU: {{ $product->sku ?? '-' }} - Stock:
                                            {{ $product->stock_quantity }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4><i class="fas fa-history mr-2"></i>Stock History</h4>
                        </div>

                        <div class="card-body p-0">
                            <div id="history-container">
                                <div class="text-center py-5">
                                    <div class="spinner-border text-primary mb-3" role="status"></div>
                                    <p class="text-muted mb-0">Loading inventory history...</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection

@push('scripts')

    {{-- Select2 JS --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function () {

            $('#productSelect').select2({
                placeholder: 'Search and select product',
                allowClear: true,
                width: '100%'
            });

            const productSelect = document.getElementById('productSelect');
            const historyContainer = document.getElementById('history-container');
            const selectedProduct = @json($selectedProduct ?? null);

            function loadHistory(productId = '') {

                historyContainer.innerHTML = `
        <div class="text-center py-5">
        <div class="spinner-border text-primary mb-3" role="status"></div>
        <p class="text-muted mb-0">Loading inventory history...</p>
        </div>`;

                let url = productId
                    ? `/products/inventory-history-data/${productId}`
                    : `/products/inventory-history-data`;

                fetch(url)
                    .then(response => {
                        if (!response.ok) throw new Error('Failed to load inventory history.');
                        return response.json();
                    })
                    .then(data => {

                        let html = '';

                        if (productId) {

                            html += `
        <div class="p-4 border-bottom">
        <div class="row align-items-center">
        <div class="col-md-8">
        <h5 class="mb-1">${escapeHtml(data.product ?? '-')}</h5>
        <p class="text-muted mb-0">SKU: ${escapeHtml(data.sku ?? '-')}</p>
        </div>

        <div class="col-md-4 text-md-right mt-3 mt-md-0">
        <small class="text-muted d-block">Current Stock</small>
        <h4 class="text-primary mb-0">${data.current_stock ?? 0}</h4>
        </div>

        </div>
        </div>`;
                        } else {

                            html += `
        <div class="p-4 border-bottom">
        <h5 class="mb-1">
        <i class="fas fa-boxes mr-2"></i>All Products
        </h5>
        <p class="text-muted mb-0">
        Showing inventory history for all products.
        </p>
        </div>`;
                        }

                        if (!data.history || data.history.length === 0) {

                            html += `
        <div class="text-center text-muted py-5">
        <i class="fas fa-history fa-3x mb-3"></i>
        <h6>No Inventory History</h6>
        <p class="mb-0">No stock movements have been recorded yet.</p>
        </div>`;

                        } else {

                            html += `
        <div class="table-responsive">
        <table class="table table-striped table-hover mb-0" id="table-1">
        <thead>
        <tr>
        <th>#</th>
        ${!productId ? '<th>Product</th>' : ''}
        <th>Date & Time</th>
        <th>Type</th>
        <th>Quantity</th>
        <th>Previous Stock</th>
        <th>New Stock</th>
        <th>Reason</th>
        <th>Created By</th>
        </tr>
        </thead>
        <tbody>`;

                            data.history.forEach((item, index) => {

                                const type = (item.type ?? '').toLowerCase();

                                let typeBadge = 'badge-secondary';
                                let quantityClass = 'font-weight-bold';
                                let quantity = item.quantity ?? 0;

                                if (['add', 'added', 'stock_in', 'in'].includes(type)) {
                                    typeBadge = 'badge-success';
                                    quantityClass = 'text-success font-weight-bold';
                                    quantity = '+' + quantity;
                                } else if (['remove', 'removed', 'stock_out', 'out'].includes(type)) {
                                    typeBadge = 'badge-danger';
                                    quantityClass = 'text-danger font-weight-bold';
                                    quantity = '-' + quantity;
                                } else if (['update', 'updated'].includes(type)) {
                                    typeBadge = 'badge-primary';
                                }

                                html += `
        <tr>
        <td>${index + 1}</td>`;

                                if (!productId) {
                                    html += `
        <td>
        <strong>${escapeHtml(item.product ?? '-')}</strong>
        <br>
        <small class="text-muted">
        SKU: ${escapeHtml(item.sku ?? '-')}
        </small>
        </td>`;
                                }

                                html += `
        <td>${escapeHtml(item.created_at ?? '-')}</td>
        <td>
        <span class="badge ${typeBadge}">
        ${escapeHtml(item.type ?? '-')}
        </span>
        </td>
        <td>
        <span class="${quantityClass}">
        ${quantity}
        </span>
        </td>
        <td>${item.previous_stock ?? '-'}</td>
        <td><strong>${item.new_stock ?? '-'}</strong></td>
        <td>${escapeHtml(item.reason ?? '-')}</td>
        <td>${escapeHtml(item.created_by ?? 'System')}</td>
        </tr>`;

                            });

                            html += `
        </tbody>
        </table>
        </div>`;
                        }

                        historyContainer.innerHTML = html;

                        if (data.history && data.history.length > 0) {

                            $('#table-1').DataTable({
                                ordering: true,
                                searching: true,
                                paging: true,
                                info: true,
                                pageLength: 10,
                                lengthMenu: [
                                    [10, 25, 50, 100, -1],
                                    [10, 25, 50, 100, 'All']
                                ],
                                columnDefs: [
                                    {
                                        orderable: false,
                                        targets: [0]
                                    }
                                ]
                            });

                        }

                    })
                    .catch(error => {

                        console.error(error);

                        historyContainer.innerHTML = `
        <div class="text-center text-danger py-5">
        <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
        <h6>Unable to Load History</h6>
        <p class="text-muted mb-0">
        Something went wrong while loading inventory history.
        </p>
        </div>`;

                    });
            }

            $('#productSelect').on('change', function () {
                loadHistory(this.value);
            });

            function escapeHtml(value) {
                const div = document.createElement('div');
                div.textContent = value;
                return div.innerHTML;
            }

            if (selectedProduct) {
                productSelect.value = selectedProduct;
                $('#productSelect').trigger('change');
            } else {
                loadHistory('');
            }

        });
    </script>

@endpush

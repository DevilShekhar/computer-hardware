@extends('admin.layouts.app')
@section('title', 'Inventory History')
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
                {{-- Product Dropdown --}}
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4><i class="fas fa-box mr-2"></i>Select Product</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-0">
                                <label for="productSelect">Product <span class="text-danger">*</span></label>
                                <select id="productSelect" class="form-control">
                                    <option value="">Select Product</option>
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

                {{-- Stock History --}}
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4><i class="fas fa-history mr-2"></i>Stock History</h4>
                        </div>
                        <div class="card-body p-0">
                            <div id="history-container">
                                <div class="text-center text-muted py-5">
                                    <i class="fas fa-history fa-3x mb-3"></i>
                                    <h6>Select a Product</h6>
                                    <p class="mb-0">Select a product above to view its inventory history.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const productSelect = document.getElementById('productSelect');
            const historyContainer = document.getElementById('history-container');
            const selectedProduct = @json($selectedProduct ?? null);

            function loadHistory(productId) {
                if (!productId) {
                    historyContainer.innerHTML = `
                    <div class="text-center text-muted py-5">
                        <i class="fas fa-history fa-3x mb-3"></i>
                        <h6>Select a Product</h6>
                        <p class="mb-0">Select a product above to view its inventory history.</p>
                    </div>`;
                    return;
                }

                historyContainer.innerHTML = `
                <div class="text-center py-5">
                    <div class="spinner-border text-primary mb-3" role="status"></div>
                    <p class="text-muted mb-0">Loading inventory history...</p>
                </div>`;

                fetch(`/products/${productId}/inventory-history-data`)
                    .then(response => {
                        if (!response.ok) throw new Error('Failed to load inventory history.');
                        return response.json();
                    })
                    .then(data => {
                        let html = `
                        <div class="p-4 border-bottom">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <h5 class="mb-1">${escapeHtml(data.product)}</h5>
                                    <p class="text-muted mb-0">SKU: ${escapeHtml(data.sku ?? '-')}</p>
                                </div>
                                <div class="col-md-4 text-md-right mt-3 mt-md-0">
                                    <small class="text-muted d-block">Current Stock</small>
                                    <h4 class="text-primary mb-0">${data.current_stock}</h4>
                                </div>
                            </div>
                        </div>`;

                        if (!data.history || data.history.length === 0) {
                            html += `
                            <div class="text-center text-muted py-5">
                                <i class="fas fa-history fa-3x mb-3"></i>
                                <h6>No Inventory History</h6>
                                <p class="mb-0">No stock movements have been recorded for this product yet.</p>
                            </div>`;
                        } else {
                            html += `
                            <div class="table-responsive">
                                <table class="table table-striped table-hover mb-0" id="table-1">
                                    <thead>
                                        <tr>
                                            <th>#</th>
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
                                let quantity = item.quantity;

                                if (['add', 'added', 'stock_in', 'in'].includes(type)) {
                                    typeBadge = 'badge-success';
                                    quantityClass = 'text-success font-weight-bold';
                                    quantity = '+' + item.quantity;
                                } else if (['remove', 'removed', 'stock_out', 'out'].includes(type)) {
                                    typeBadge = 'badge-danger';
                                    quantityClass = 'text-danger font-weight-bold';
                                    quantity = '-' + item.quantity;
                                } else if (['update', 'updated'].includes(type)) {
                                    typeBadge = 'badge-primary';
                                }

                                html += `
                                <tr>
                                    <td>${index + 1}</td>
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
                            <p class="text-muted mb-0">Something went wrong while loading inventory history.</p>
                        </div>`;
                    });
            }

            productSelect.addEventListener('change', function () {
                loadHistory(this.value);
            });

            function escapeHtml(value) {
                const div = document.createElement('div');
                div.textContent = value;
                return div.innerHTML;
            }

            if (selectedProduct) {
                productSelect.value = selectedProduct;
                loadHistory(selectedProduct);
            }
        });
    </script>
@endsection
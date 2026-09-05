@extends('frontend.layouts.app')

@section('content')

<style>
    .pc-builder-page {
        background: #f7f8fa;
        padding: 40px 0 70px;
    }

    .pc-builder-header {
        background: #ffffff;
        border: 1px solid #e8e8e8;
        border-radius: 14px;
        padding: 25px 30px;
        margin-bottom: 25px;
    }

    .pc-builder-header h1 {
        margin: 0 0 8px;
        font-size: 28px;
        font-weight: 700;
        color: #222;
    }

    .pc-builder-header p {
        margin: 0;
        color: #777;
        font-size: 14px;
    }

    .builder-layout {
        display: flex;
        gap: 25px;
        align-items: flex-start;
    }

    .builder-sidebar {
        width: 280px;
        flex: 0 0 280px;
    }

    .builder-content {
        flex: 1;
        min-width: 0;
    }

    .builder-card {
        background: #ffffff;
        border: 1px solid #e8e8e8;
        border-radius: 14px;
        overflow: hidden;
    }

    .builder-sidebar-title {
        padding: 18px 20px;
        border-bottom: 1px solid #eeeeee;
        font-size: 16px;
        font-weight: 700;
        color: #222;
    }

    .product-type-list {
        padding: 10px;
    }

    .product-type-button {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border: 0;
        background: transparent;
        text-align: left;
        padding: 12px 14px;
        margin-bottom: 4px;
        border-radius: 8px;
        color: #444;
        font-weight: 600;
        cursor: pointer;
        transition: 0.2s ease;
    }

    .product-type-button:hover,
    .product-type-button.active {
        background: #f0f3ff;
        color: #6777ef;
    }

    .product-type-button i {
        width: 22px;
    }

    .product-type-button .type-count {
        min-width: 25px;
        padding: 3px 7px;
        border-radius: 20px;
        background: #f1f1f1;
        color: #777;
        font-size: 11px;
        text-align: center;
    }

    .product-type-button.active .type-count {
        background: #6777ef;
        color: #ffffff;
    }

    .builder-main-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        padding: 20px 25px;
        border-bottom: 1px solid #eeeeee;
    }

    .builder-main-header h4 {
        margin: 0;
        font-size: 19px;
        font-weight: 700;
        color: #222;
    }

    .builder-main-header p {
        margin: 5px 0 0;
        color: #888;
        font-size: 13px;
    }

    .selected-count {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 7px 13px;
        border-radius: 30px;
        background: #6777ef;
        color: #ffffff;
        font-size: 13px;
        font-weight: 600;
        white-space: nowrap;
    }

    .builder-tree {
        padding: 20px;
    }

    .product-type-section {
        margin-bottom: 25px;
        border: 1px solid #eeeeee;
        border-radius: 12px;
        overflow: hidden;
    }

    .product-type-section:last-child {
        margin-bottom: 0;
    }

    .product-type-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        padding: 16px 18px;
        background: #fafafa;
        border-bottom: 1px solid #eeeeee;
    }

    .product-type-header-left {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .product-type-header-left i {
        color: #6777ef;
        font-size: 17px;
    }

    .product-type-header h5 {
        margin: 0;
        font-size: 16px;
        font-weight: 700;
        color: #222;
    }

    .product-type-count {
        padding: 4px 9px;
        border-radius: 20px;
        background: #ffffff;
        border: 1px solid #e4e4e4;
        color: #777;
        font-size: 11px;
        font-weight: 600;
    }

    .product-list {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 12px;
        padding: 18px;
    }

    .product-option {
        position: relative;
    }

    .product-checkbox {
        position: absolute;
        opacity: 0;
        pointer-events: none;
    }

    .product-label {
        position: relative;
        display: flex;
        align-items: center;
        gap: 12px;
        width: 100%;
        min-height: 100px;
        padding: 12px;
        border: 1px solid #e5e5e5;
        border-radius: 10px;
        background: #ffffff;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .product-label:hover {
        border-color: #6777ef;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.06);
        transform: translateY(-1px);
    }

    .product-checkbox:checked + .product-label {
        border-color: #6777ef;
        background: #f5f6ff;
        box-shadow: 0 4px 15px rgba(103, 119, 239, 0.12);
    }

    .product-check-icon {
        width: 22px;
        height: 22px;
        min-width: 22px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid #d5d5d5;
        border-radius: 5px;
        color: transparent;
        font-size: 11px;
        transition: 0.2s ease;
    }

    .product-checkbox:checked + .product-label .product-check-icon {
        background: #6777ef;
        border-color: #6777ef;
        color: #ffffff;
    }

    .product-image {
        width: 70px;
        height: 70px;
        min-width: 70px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        border-radius: 8px;
        background: #f6f6f6;
    }

    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .product-info {
        flex: 1;
        min-width: 0;
    }

    .product-name {
        display: block;
        margin-bottom: 4px;
        color: #333;
        font-size: 14px;
        font-weight: 600;
        line-height: 1.4;
    }

    .product-sku {
        display: block;
        margin-bottom: 5px;
        color: #999;
        font-size: 11px;
    }

    .product-price {
        display: flex;
        align-items: center;
        gap: 7px;
        flex-wrap: wrap;
    }

    .sale-price {
        color: #28a745;
        font-size: 14px;
        font-weight: 700;
    }

    .regular-price {
        color: #999;
        font-size: 12px;
    }

    .builder-summary {
        position: sticky;
        bottom: 15px;
        z-index: 10;
        margin-top: 25px;
        padding: 20px;
        background: #ffffff;
        border: 1px solid #e8e8e8;
        border-radius: 12px;
        box-shadow: 0 5px 25px rgba(0, 0, 0, 0.08);
    }

    .summary-inner {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
    }

    .summary-title {
        margin-bottom: 4px;
        color: #222;
        font-size: 16px;
        font-weight: 700;
    }

    .summary-text {
        color: #777;
        font-size: 13px;
    }

    .summary-total {
        color: #28a745;
        font-size: 20px;
        font-weight: 700;
    }

    .summary-actions {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .empty-builder {
        padding: 60px 25px;
        text-align: center;
    }

    .empty-builder i {
        display: block;
        margin-bottom: 15px;
        color: #ccc;
        font-size: 45px;
    }

    .empty-builder h4 {
        margin-bottom: 8px;
        font-weight: 700;
    }

    .empty-builder p {
        margin: 0;
        color: #888;
    }

    @media (max-width: 991px) {

        .builder-layout {
            display: block;
        }

        .builder-sidebar {
            width: 100%;
            margin-bottom: 20px;
        }

        .product-type-list {
            display: flex;
            gap: 8px;
            overflow-x: auto;
        }

        .product-type-button {
            width: auto;
            min-width: 150px;
            margin-bottom: 0;
            white-space: nowrap;
        }

        .product-list {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 575px) {

        .pc-builder-page {
            padding: 20px 0 50px;
        }

        .pc-builder-header {
            padding: 20px;
        }

        .pc-builder-header h1 {
            font-size: 22px;
        }

        .builder-main-header {
            padding: 15px;
        }

        .builder-tree {
            padding: 12px;
        }

        .product-list {
            padding: 12px;
        }

        .summary-inner {
            display: block;
        }

        .summary-actions {
            margin-top: 15px;
        }

        .summary-actions .btn {
            flex: 1;
        }
    }
</style>

@php
    $builderProductsCollection = collect($builderProducts ?? []);

    if ($builderProductsCollection->isEmpty() && isset($products)) {
        $builderProductsCollection = collect($products)->map(function ($product) {
            return (object) [
                'id' => $product->id,
                'product_type' => $product->product_type ?? 'Other',
                'product' => $product,
            ];
        });
    }

    $groupedProducts = $builderProductsCollection
        ->filter(function ($builderProduct) {
            return !empty($builderProduct->product);
        })
        ->groupBy(function ($builderProduct) {
            return $builderProduct->product_type ?: 'Other';
        });

    $productTypeOrder = [
        'Processor',
        'Motherboard',
        'RAM',
        'Graphics Card',
        'Storage',
        'Power Supply',
        'Cabinet',
        'CPU Cooler',
    ];

    $orderedProductTypes = collect($productTypeOrder)
        ->filter(function ($type) use ($groupedProducts) {
            return $groupedProducts->has($type);
        });

    $otherProductTypes = $groupedProducts->keys()
        ->filter(function ($type) use ($productTypeOrder) {
            return !in_array($type, $productTypeOrder);
        });

    $allProductTypes = $orderedProductTypes
        ->merge($otherProductTypes)
        ->values();

    $typeIcons = [
        'Processor' => 'fas fa-microchip',
        'Motherboard' => 'fas fa-server',
        'RAM' => 'fas fa-memory',
        'Graphics Card' => 'fas fa-tv',
        'Storage' => 'fas fa-hdd',
        'Power Supply' => 'fas fa-bolt',
        'Cabinet' => 'fas fa-desktop',
        'CPU Cooler' => 'fas fa-fan',
    ];
@endphp

<section class="pc-builder-page">

    <div class="container">

        <div class="pc-builder-header">

            <div class="d-flex align-items-center justify-content-between flex-wrap">

                <div>
                    <h1>
                        {{ $builderType->name }}
                    </h1>

                    <p>
                        Select the components you want to use in your PC build.
                    </p>
                </div>

                <div class="mt-2 mt-md-0">
                    <span class="selected-count">
                        <i class="fas fa-check-circle"></i>

                        <span id="selectedProductCount">
                            0
                        </span>

                        Selected
                    </span>
                </div>

            </div>

        </div>

        <div class="builder-layout">

            <aside class="builder-sidebar">

                <div class="builder-card">

                    <div class="builder-sidebar-title">
                        <i class="fas fa-layer-group mr-2"></i>
                        Product Types
                    </div>

                    <div class="product-type-list">

                        <button
                            type="button"
                            class="product-type-button active"
                            data-type="all"
                        >
                            <span>
                                <i class="fas fa-th-large"></i>
                                All Components
                            </span>

                            <span class="type-count">
                                {{ $builderProductsCollection->count() }}
                            </span>
                        </button>

                        @foreach($allProductTypes as $productType)

                            <button
                                type="button"
                                class="product-type-button"
                                data-type="{{ $productType }}"
                            >
                                <span>
                                    <i class="{{ $typeIcons[$productType] ?? 'fas fa-cube' }}"></i>
                                    {{ $productType }}
                                </span>

                                <span class="type-count">
                                    {{ $groupedProducts->get($productType)->count() }}
                                </span>
                            </button>

                        @endforeach

                    </div>

                </div>

            </aside>

            <main class="builder-content">

                <div class="builder-card">

                    <div class="builder-main-header">

                        <div>
                            <h4>
                                Available Components
                            </h4>

                            <p>
                                Select the products you want to include in your PC build.
                            </p>
                        </div>

                        <div>
                            <button
                                type="button"
                                class="btn btn-sm btn-light"
                                id="clearSelection"
                            >
                                <i class="fas fa-times"></i>
                                Clear
                            </button>
                        </div>

                    </div>

                    <div class="builder-tree">

                        @if($allProductTypes->count())

                            @foreach($allProductTypes as $productType)

                                @php
                                    $typeProducts = $groupedProducts->get($productType, collect());
                                    $typeIcon = $typeIcons[$productType] ?? 'fas fa-cube';
                                @endphp

                                <div
                                    class="product-type-section"
                                    data-product-type="{{ $productType }}"
                                >

                                    <div class="product-type-header">

                                        <div class="product-type-header-left">

                                            <i class="{{ $typeIcon }}"></i>

                                            <h5>
                                                {{ $productType }}
                                            </h5>

                                        </div>

                                        <span class="product-type-count">
                                            {{ $typeProducts->count() }}
                                            Products
                                        </span>

                                    </div>

                                    <div class="product-list">

                                        @foreach($typeProducts as $builderProduct)

                                            @php
                                                $product = $builderProduct->product;

                                                $primaryImage = $product->images
                                                    ->where('is_primary', true)
                                                    ->first()
                                                    ?? $product->images->first();

                                                $hasSalePrice =
                                                    !empty($product->sale_price)
                                                    && $product->sale_price < $product->price;

                                                $productPrice = $hasSalePrice
                                                    ? $product->sale_price
                                                    : $product->price;
                                            @endphp

                                            <div class="product-option">

                                                <input
                                                    type="checkbox"
                                                    class="product-checkbox builder-product-checkbox"
                                                    id="product_{{ $builderProduct->id }}"
                                                    value="{{ $product->id }}"
                                                    data-builder-product-id="{{ $builderProduct->id }}"
                                                    data-product-type="{{ $productType }}"
                                                    data-price="{{ $productPrice }}"
                                                    data-name="{{ $product->name }}"
                                                >

                                                <label
                                                    for="product_{{ $builderProduct->id }}"
                                                    class="product-label"
                                                >

                                                    <span class="product-check-icon">
                                                        <i class="fas fa-check"></i>
                                                    </span>

                                                    <span class="product-image">

                                                        @if($primaryImage && $primaryImage->image)

                                                            <img
                                                                src="{{ asset('storage/' . $primaryImage->image) }}"
                                                                alt="{{ $product->name }}"
                                                            >

                                                        @else

                                                            <img
                                                                src="{{ asset('assets/frontend/assets/images/product/large-size/1.jpg') }}"
                                                                alt="{{ $product->name }}"
                                                            >

                                                        @endif

                                                    </span>

                                                    <span class="product-info">

                                                        <span class="product-name">
                                                            {{ $product->name }}
                                                        </span>

                                                        @if($product->sku)

                                                            <span class="product-sku">
                                                                SKU: {{ $product->sku }}
                                                            </span>

                                                        @endif

                                                        <span class="product-price">

                                                            @if($hasSalePrice)

                                                                <span class="sale-price">
                                                                    ₹{{ number_format($product->sale_price, 2) }}
                                                                </span>

                                                                <span class="regular-price">
                                                                    <del>
                                                                        ₹{{ number_format($product->price, 2) }}
                                                                    </del>
                                                                </span>

                                                            @else

                                                                <span class="sale-price">
                                                                    ₹{{ number_format($product->price, 2) }}
                                                                </span>

                                                            @endif

                                                        </span>

                                                    </span>

                                                </label>

                                            </div>

                                        @endforeach

                                    </div>

                                </div>

                            @endforeach

                        @else

                            <div class="empty-builder">

                                <i class="fas fa-box-open"></i>

                                <h4>
                                    No Products Available
                                </h4>

                                <p>
                                    No products have been assigned to this PC Builder Type yet.
                                </p>

                            </div>

                        @endif

                    </div>

                </div>

                <div class="builder-summary">

                    <div class="summary-inner">

                        <div>

                            <div class="summary-title">
                                PC Build Selection
                            </div>

                            <div class="summary-text">

                                <span id="summaryCount">
                                    0
                                </span>

                                products selected

                            </div>

                        </div>

                        <div>

                            <div class="summary-total">
                                ₹<span id="summaryTotal">0.00</span>
                            </div>

                        </div>

                        <div class="summary-actions">

                            <button
                                type="button"
                                class="btn btn-light"
                                id="clearSelectionBottom"
                            >
                                Clear
                            </button>

                            <button
                                type="button"
                                class="btn btn-primary"
                                id="continueBuilder"
                            >
                                Continue
                                <i class="fas fa-arrow-right ml-1"></i>
                            </button>

                        </div>

                    </div>

                </div>

            </main>

        </div>

    </div>

</section>

@endsection

@push('scripts')

<script>
    $(document).ready(function () {

        function updateSelection() {

            let selectedProducts = $('.builder-product-checkbox:checked');

            let count = selectedProducts.length;

            let total = 0;

            selectedProducts.each(function () {

                let price = parseFloat(
                    $(this).data('price')
                ) || 0;

                total += price;
            });

            $('#selectedProductCount').text(count);

            $('#summaryCount').text(count);

            $('#summaryTotal').text(
                total.toLocaleString('en-IN', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                })
            );
        }

        $(document).on(
            'change',
            '.builder-product-checkbox',
            function () {
                updateSelection();
            }
        );

        $('.product-type-button').on('click', function () {

            let selectedType = $(this).data('type');

            $('.product-type-button').removeClass('active');

            $(this).addClass('active');

            if (selectedType === 'all') {

                $('.product-type-section').show();

            } else {

                $('.product-type-section').each(function () {

                    let sectionType = String(
                        $(this).data('product-type')
                    );

                    if (sectionType === String(selectedType)) {

                        $(this).show();

                    } else {

                        $(this).hide();

                    }

                });
            }
        });

        function clearSelection() {

            $('.builder-product-checkbox')
                .prop('checked', false);

            localStorage.removeItem(
                'pcBuilderProducts'
            );

            updateSelection();
        }

        $('#clearSelection').on(
            'click',
            function () {
                clearSelection();
            }
        );

        $('#clearSelectionBottom').on(
            'click',
            function () {
                clearSelection();
            }
        );

        $('#continueBuilder').on(
            'click',
            function () {

                let selectedIds = [];

                $('.builder-product-checkbox:checked')
                    .each(function () {

                        selectedIds.push(
                            $(this).val()
                        );

                    });

                if (!selectedIds.length) {

                    Swal.fire({
                        icon: 'warning',
                        title: 'No Products Selected',
                        text: 'Please select at least one product to continue.',
                        confirmButtonColor: '#6777ef'
                    });

                    return;
                }

                localStorage.setItem(
                    'pcBuilderProducts',
                    JSON.stringify(selectedIds)
                );

                Swal.fire({
                    icon: 'success',
                    title: 'Products Selected',
                    text:
                        selectedIds.length +
                        ' product(s) selected for your PC build.',
                    confirmButtonColor: '#6777ef'
                });
            }
        );

        let savedProducts = JSON.parse(
            localStorage.getItem(
                'pcBuilderProducts'
            ) || '[]'
        );

        if (Array.isArray(savedProducts)) {

            savedProducts.forEach(function (productId) {

                $('.builder-product-checkbox[value="' + productId + '"]')
                    .prop('checked', true);

            });

        }

        updateSelection();

    });
</script>

@endpush

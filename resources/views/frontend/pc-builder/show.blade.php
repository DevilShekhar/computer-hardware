@extends('frontend.layouts.app')

@section('content')

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

$builderProductsCollection = $builderProductsCollection->filter(function ($builderProduct) {
return !empty($builderProduct->product);
});

$groupedProducts = $builderProductsCollection->groupBy(function ($builderProduct) {
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

$orderedProductTypes = collect($productTypeOrder)->filter(function ($type) use ($groupedProducts) {
return $groupedProducts->has($type);
});

$otherProductTypes = $groupedProducts->keys()->filter(function ($type) use ($productTypeOrder) {
return !in_array($type, $productTypeOrder);
});

$allProductTypes = $orderedProductTypes->merge($otherProductTypes)->values();

$typeIcons = [
'Processor' => 'fa fa-cog',
'Motherboard' => 'fa fa-server',
'RAM' => 'fa fa-th-large',
'Graphics Card' => 'fa fa-desktop',
'Storage' => 'fa fa-hdd-o',
'Power Supply' => 'fa fa-bolt',
'Cabinet' => 'fa fa-archive',
'CPU Cooler' => 'fa fa-cog',
];
@endphp

<style>
.pc-builder-area {
    min-height: 100vh;
    padding: 40px 0 60px;
    background: #f7f8fb;
}

.pc-builder-card {
    overflow: hidden;
    border: 1px solid #e2e6ec;
    border-radius: 10px;
    background: #fff;
    box-shadow: 0 3px 15px rgba(0, 0, 0, .035);
}

.pc-builder-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;
    padding: 18px 20px;
    border-bottom: 1px solid #e8ebf0;
}

.pc-builder-header h3 {
    margin: 0;
    color: #172033;
    font-size: 18px;
    font-weight: 700;
}

.pc-builder-header p {
    margin: 4px 0 0;
    color: #8a929e;
    font-size: 10px;
}

.pc-builder-clear {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    border: 1px solid #dfe3e9;
    border-radius: 6px;
    background: #fff;
    color: #667085;
    padding: 7px 11px;
    font-size: 10px;
    cursor: pointer;
    transition: all .2s ease;
}

.pc-builder-clear:hover {
    border-color: #ef4444;
    background: #fff5f5;
    color: #ef4444;
}

.pc-builder-products {
    padding: 15px;
}

.frequently-accordion {
    width: 100%;
}

.frequently-accordion #accordion {
    width: 100%;
}

.frequently-accordion .card {
    overflow: hidden;
    margin-bottom: 9px;
    border: 1px solid #e0e4ea;
    border-radius: 8px;
    background: #fff;
}

.frequently-accordion .card:last-child {
    margin-bottom: 0;
}

.frequently-accordion .card-header {
    padding: 0;
    border: 0;
    background: #f8f9fc;
}

.frequently-accordion .card-header h5 {
    margin: 0;
}

.frequently-accordion .card-header a {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    padding: 13px 15px;
    color: #172033;
    font-weight: 700;
    text-decoration: none;
    cursor: pointer;
    transition: all .2s ease;
}

.frequently-accordion .card-header a:hover {
    background: #f3f6fb;
    color: #1769e8;
}

.faq-title-left {
    display: flex;
    align-items: center;
    gap: 10px;
    min-width: 0;
}

.faq-title-left i {
    width: 18px;
    color: #1769e8;
    font-size: 14px;
    text-align: center;
}

.faq-title-left span {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}


.frequently-accordion .card-body {
    padding: 9px;
    border-top: 1px solid #e5e8ed;
    background: #fff;
}

.product-row {
    margin-right: 0;
    margin-left: 0;
}

.product-column {
    padding-right: 0;
    padding-left: 0;
    margin-bottom: 7px;
}

.product-column:last-child {
    margin-bottom: 0;
}

.builder-product-item {
    position: relative;
    width: 100%;
}

.builder-product-radio {
    position: absolute;
    opacity: 0;
    pointer-events: none;
}

.builder-product-label {
    width: 100%;
    min-height: 55px;
    display: grid;
    grid-template-columns: 18px minmax(0, 1fr);
    align-items: center;
    gap: 10px;
    padding: 8px 11px;
    border: 1px solid #e0e4ea;
    border-radius: 7px;
    background: #fff;
    cursor: pointer;
    transition: all .2s ease;
}

.builder-product-label:hover {
    border-color: #1769e8;
    background: #fafcff;
}

.builder-product-radio:checked+.builder-product-label {
    border-color: #1769e8;
    background: #f4f8ff;
    box-shadow: 0 2px 9px rgba(23, 105, 232, .08);
}

.builder-radio {
    width: 18px;
    height: 18px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: 1.5px solid #c3c9d2;
    border-radius: 50%;
}

.builder-radio:after {
    content: "";
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: transparent;
    transition: all .2s ease;
}

.builder-product-radio:checked+.builder-product-label .builder-radio {
    border-color: #1769e8;
}

.builder-product-radio:checked+.builder-product-label .builder-radio:after {
    background: #1769e8;
}

.builder-product-details {
    width: 100%;
    display: grid;
    grid-template-columns: minmax(0, 1fr) 160px 140px;
    align-items: center;
    gap: 20px;
    min-width: 0;
}

.builder-product-name {
    overflow: hidden;
    color: #172033;
    font-size: 11px;
    font-weight: 700;
    line-height: 1.4;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.builder-product-sku {
    overflow: hidden;
    color: #89919d;
    font-size: 9px;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.builder-product-price {
    display: flex;
    align-items: center;
    gap: 6px;
    white-space: nowrap;
}

.builder-sale-price {
    color: #159447;
    font-size: 12px;
    font-weight: 700;
}

.builder-old-price {
    color: #dc3545;
    font-size: 9px;
}
.selected-product-details span {
    display: block;
    margin-bottom: 4px;
}
.selected-products-card {
    position: sticky;
    top: 20px;
}

.selected-products-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    padding: 18px 20px;
    border-bottom: 1px solid #e8ebf0;
}

.selected-products-title {
    display: flex;
    align-items: center;
    gap: 8px;
}

.selected-products-title i {
    color: #1769e8;
    font-size: 12px;
}

.selected-products-title h4 {
    margin: 0;
    color: #172033;
    font-size: 14px;
    font-weight: 700;
}

.selected-products-count {
    min-width: 25px;
    height: 22px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 2px 7px;
    border-radius: 20px;
    background: #1769e8;
    color: #fff;
    font-size: 9px;
    font-weight: 700;
}

.selected-products-body {
    padding: 12px;
}

.selected-product-item {
    position: relative;
    width: 100%;
    min-height: 58px;
    display: grid;
    grid-template-columns: minmax(0, 1fr) 24px;
    align-items: center;
    gap: 8px;
    margin-bottom: 7px;
    padding: 9px;
    border: 1px solid #e0e4ea;
    border-radius: 7px;
    background: #fff;
    animation: selectedProductFade .25s ease;
}

.selected-product-item:last-child {
    margin-bottom: 0;
}

@keyframes selectedProductFade {
    from {
        opacity: 0;
        transform: translateY(5px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}



.selected-product-type {
    display: block;
    margin-bottom: 2px;
    color: #1769e8;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
}

.selected-product-name {
    display: block;
    overflow: hidden;
    color: #172033;
    font-size: 12px;
    font-weight: 700;
    line-height: 1.35;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.selected-product-sku {
    overflow: hidden;
    color: #89919d;
    font-size: 10px;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.selected-product-price {
    color: #159447;
    font-size: 10px;
    font-weight: 700;
    white-space: nowrap;
}

.selected-product-remove {
    width: 24px;
    height: 24px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: 0;
    border-radius: 5px;
    background: #fff1f2;
    color: #ef4444;
    cursor: pointer;
    font-size: 14px;
    transition: all .2s ease;
}

.selected-product-remove:hover {
    background: #ef4444;
    color: #fff;
}

.selected-empty {
    padding: 55px 20px;
    text-align: center;
}

.selected-empty-icon {
    width: 55px;
    height: 55px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 12px;
    border-radius: 50%;
    background: #f5f7fa;
    color: #bdc4ce;
    font-size: 19px;
}

.selected-empty h5 {
    margin: 0 0 5px;
    color: #5d6673;
    font-size: 13px;
    font-weight: 700;
}

.selected-empty p {
    max-width: 230px;
    margin: 0 auto;
    color: #98a0ab;
    font-size: 10px;
    line-height: 1.5;
}

.selected-summary {
    margin-top: 10px;
    padding: 13px;
    border: 1px solid #dfe7f4;
    border-radius: 8px;
    background: #f4f8ff;
}

.summary-label {
    display: block;
    margin-bottom: 2px;
    color: #687386;
    font-size: 9px;
    font-weight: 600;
}

.summary-total {
    color: #159447;
    font-size: 18px;
    font-weight: 700;
}

.proceed-builder {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    margin-top: 10px;
    padding: 10px 12px;
    border: 0;
    border-radius: 6px;
    background: #1769e8;
    color: #fff;
    font-size: 10px;
    font-weight: 600;
    cursor: pointer;
    transition: all .2s ease;
}

.proceed-builder:hover {
    background: #0d5dcc;
}

.empty-products {
    padding: 45px 20px;
    text-align: center;
}

.empty-products i {
    display: block;
    margin-bottom: 10px;
    color: #cbd1da;
    font-size: 35px;
}

.empty-products h5 {
    margin: 0 0 4px;
    color: #667085;
    font-size: 13px;
}

.empty-products p {
    margin: 0;
    color: #98a0ac;
    font-size: 10px;
}

@media (max-width: 991px) {
    .selected-products-card {
        position: static;
        margin-top: 15px;
    }
}

@media (max-width: 767px) {
    .pc-builder-area {
        padding: 25px 0 40px;
    }

    .pc-builder-header {
        align-items: flex-start;
        flex-direction: column;
        padding: 17px;
    }

    .pc-builder-products {
        padding: 10px;
    }

    .builder-product-details {
        grid-template-columns: minmax(0, 1fr) 120px 100px;
        gap: 12px;
    }

    .selected-products-header {
        padding: 17px;
    }

    .selected-product-details {
        grid-template-columns: minmax(0, 1fr) 80px 75px;
        gap: 8px;
    }
}

@media (max-width: 575px) {
    .frequently-accordion .card-header a {
        padding: 11px;
    }

    .frequently-accordion .card-body {
        padding: 7px;
    }

    .builder-product-label {
        min-height: 52px;
        padding: 7px 8px;
    }

    .builder-product-details {
        grid-template-columns: minmax(0, 1fr) 85px;
        gap: 7px;
    }

    .builder-product-price {
        grid-column: 1 / -1;
    }

    .builder-product-name {
        font-size: 10px;
    }

    .builder-product-sku {
        font-size: 8px;
    }

    .builder-sale-price {
        font-size: 10px;
    }

    .selected-product-item {
        padding: 8px;
    }

    .selected-product-details {
        grid-template-columns: minmax(0, 1fr) 75px;
        gap: 6px;
    }

    .selected-product-price {
        grid-column: 1 / -1;
    }
}
</style>

<section class="pc-builder-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-12">
                <div class="pc-builder-card">
                    <div class="pc-builder-header">
                        <div>
                            <h3>Products</h3>
                            <p>Select one product from each category.</p>
                        </div>

                        <button type="button" class="pc-builder-clear" id="clearSelection">
                            <i class="fa fa-trash-o"></i>
                            Clear All
                        </button>
                    </div>

                    <div class="pc-builder-products">
                        @if($allProductTypes->count())
                        <div class="frequently-accordion">
                            <div id="accordion">
                                @foreach($allProductTypes as $index => $productType)
                                @php
                                $typeProducts = $groupedProducts->get($productType, collect());
                                $typeIcon = $typeIcons[$productType] ?? 'fa fa-cube';
                                $headingId = 'heading' . $index;
                                $collapseId = 'collapse' . $index;
                                @endphp

                                <div class="card">
                                    <div class="card-header" id="{{ $headingId }}">
                                        <h5>
                                            <a class="collapsed" data-toggle="collapse" data-target="#{{ $collapseId }}"
                                                aria-expanded="false" aria-controls="{{ $collapseId }}">
                                                <span class="faq-title-left">
                                                    <i class="{{ $typeIcon }}"></i>
                                                    <span>{{ $productType }}</span>
                                                </span>


                                            </a>
                                        </h5>
                                    </div>

                                    <div id="{{ $collapseId }}" class="collapse" aria-labelledby="{{ $headingId }}"
                                        data-parent="#accordion">
                                        <div class="card-body">
                                            <div class="row product-row">
                                                @foreach($typeProducts as $builderProduct)
                                                @php
                                                $product = $builderProduct->product;

                                                $hasSalePrice = !empty($product->sale_price) &&
                                                $product->sale_price < $product->price;

                                                    $displayPrice = $hasSalePrice
                                                    ? $product->sale_price
                                                    : $product->price;
                                                    @endphp

                                                    <div class="col-lg-12 col-md-12 col-sm-12 product-column">
                                                        <div class="builder-product-item">
                                                            <input type="radio" class="builder-product-radio"
                                                                id="builder_product_{{ $builderProduct->id }}"
                                                                name="builder_{{ Str::slug($productType) }}"
                                                                value="{{ $product->id }}"
                                                                data-product-type="{{ $productType }}"
                                                                data-product-name="{{ $product->name }}"
                                                                data-product-sku="{{ $product->sku ?? '-' }}"
                                                                data-product-price="{{ $displayPrice }}">

                                                            <label class="builder-product-label"
                                                                for="builder_product_{{ $builderProduct->id }}">
                                                                <span class="builder-radio"></span>

                                                                <span class="builder-product-details">
                                                                    <span class="builder-product-name">
                                                                        {{ $product->name }}
                                                                    </span>

                                                                    <span class="builder-product-sku">
                                                                        SKU: {{ $product->sku ?? '-' }}
                                                                    </span>

                                                                    <span class="builder-product-price">
                                                                        @if($hasSalePrice)
                                                                        <span class="builder-sale-price">
                                                                            ₹{{ number_format($product->sale_price, 2) }}
                                                                        </span>

                                                                        <span class="builder-old-price">
                                                                            <del>
                                                                                ₹{{ number_format($product->price, 2) }}
                                                                            </del>
                                                                        </span>
                                                                        @else
                                                                        <span class="builder-sale-price">
                                                                            ₹{{ number_format($product->price, 2) }}
                                                                        </span>
                                                                        @endif
                                                                    </span>
                                                                </span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @else
                        <div class="empty-products">
                            <i class="fa fa-cube"></i>
                            <h5>No Products Available</h5>
                            <p>No products have been assigned to this builder.</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-12">
                <div class="pc-builder-card selected-products-card">
                    <div class="selected-products-header">
                        <div class="selected-products-title">
                            <i class="fa fa-check-circle"></i>
                            <h4>Selected Products</h4>
                        </div>

                        <span class="selected-products-count">
                            <span id="selectedCount">0</span>
                        </span>
                    </div>

                    <div class="selected-products-body">
                        <div id="selectedProductsList"></div>

                        <div class="selected-empty" id="selectedEmpty">
                            <div class="selected-empty-icon">
                                <i class="fa fa-shopping-basket"></i>
                            </div>

                            <h5>No Products Selected</h5>

                            <p>
                                Select products from the left side
                                and they will appear here.
                            </p>
                        </div>

                        <div class="selected-summary" id="selectedSummary" style="display:none;">
                            <span class="summary-label">
                                Total Price
                            </span>

                            <div class="summary-total">
                                ₹<span id="summaryTotal">0.00</span>
                            </div>

                            <button type="button" class="proceed-builder" id="proceedBuilder">
                                Proceed to Build
                                <i class="fa fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
$(document).ready(function() {
    const storageKey = 'pcBuilderProducts';

    function formatPrice(value) {
        return Number(value || 0).toLocaleString('en-IN', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }

    function escapeHtml(value) {
        return $('<div>').text(value).html();
    }

    function getSavedProducts() {
        try {
            const saved = JSON.parse(
                localStorage.getItem(storageKey) || '{}'
            );

            if (
                saved &&
                typeof saved === 'object' &&
                !Array.isArray(saved)
            ) {
                return saved;
            }

            return {};
        } catch (error) {
            return {};
        }
    }

    function saveProducts() {
        const selected = {};

        $('.builder-product-radio:checked').each(function() {
            const product = $(this);

            selected[
                String(product.data('product-type'))
            ] = String(product.val());
        });

        localStorage.setItem(
            storageKey,
            JSON.stringify(selected)
        );
    }

    function updateSelectedProducts() {
        const selectedProducts =
            $('.builder-product-radio:checked');

        const container =
            $('#selectedProductsList');

        const emptyState =
            $('#selectedEmpty');

        const summary =
            $('#selectedSummary');

        let total = 0;

        container.empty();

        selectedProducts.each(function() {
            const product =
                $(this);

            const productId =
                String(product.val());

            const productType =
                product.data('product-type') || '';

            const productName =
                product.data('product-name') || '';

            const productSku =
                product.data('product-sku') || '-';

            const productPrice =
                parseFloat(
                    product.data('product-price')
                ) || 0;

            total += productPrice;

            const selectedItem = $(`
                    <div
                        class="selected-product-item"
                        data-product-id="${productId}"
                    >
                        <div class="selected-product-details">
                            <span>
                                <span class="selected-product-type">
                                    ${escapeHtml(productType)}
                                </span>

                                <span class="selected-product-name">
                                    ${escapeHtml(productName)}
                                </span>
                            </span>

                            <span class="selected-product-sku">
                                SKU: ${escapeHtml(productSku)}
                            </span>

                            <span class="selected-product-price">
                                ₹${formatPrice(productPrice)}
                            </span>
                        </div>

                        <button
                            type="button"
                            class="selected-product-remove"
                            data-product-id="${productId}"
                            data-product-type="${escapeHtml(productType)}"
                            title="Remove"
                        >
                            <i class="fa fa-trash-o"></i>
                        </button>
                    </div>
                `);

            container.append(selectedItem);
        });

        const count =
            selectedProducts.length;

        $('#selectedCount').text(count);

        $('#summaryTotal').text(
            formatPrice(total)
        );

        if (count > 0) {
            emptyState.hide();
            summary.show();
        } else {
            emptyState.show();
            summary.hide();
        }
    }

    function restoreProducts() {
        const savedProducts =
            getSavedProducts();

        $('.builder-product-radio').each(function() {
            const product =
                $(this);

            const productType =
                String(
                    product.data('product-type')
                );

            const productId =
                String(
                    product.val()
                );

            if (
                savedProducts[productType] &&
                String(
                    savedProducts[productType]
                ) === productId
            ) {
                product.prop(
                    'checked',
                    true
                );
            }
        });

        updateSelectedProducts();
    }

    $('.frequently-accordion .card-header a').on('click', function() {
        const link =
            $(this);

        const target =
            $(link.data('target'));

        $('.frequently-accordion .card-header a').not(link).each(function() {
            $(this)
                .find('.faq-toggle-icon i')
                .removeClass('fa-minus')
                .addClass('fa-plus');
        });

        setTimeout(function() {
            if (target.hasClass('show')) {
                link
                    .find('.faq-toggle-icon i')
                    .removeClass('fa-plus')
                    .addClass('fa-minus');
            } else {
                link
                    .find('.faq-toggle-icon i')
                    .removeClass('fa-minus')
                    .addClass('fa-plus');
            }
        }, 260);
    });

    $('.frequently-accordion .collapse').on('shown.bs.collapse', function() {
        const collapse =
            $(this);

        const header =
            collapse
            .closest('.card')
            .find('.card-header a');

        header
            .find('.faq-toggle-icon i')
            .removeClass('fa-plus')
            .addClass('fa-minus');
    });

    $('.frequently-accordion .collapse').on('hidden.bs.collapse', function() {
        const collapse =
            $(this);

        const header =
            collapse
            .closest('.card')
            .find('.card-header a');

        header
            .find('.faq-toggle-icon i')
            .removeClass('fa-minus')
            .addClass('fa-plus');
    });

    $('.builder-product-radio').on('change', function() {
        saveProducts();
        updateSelectedProducts();
    });

    $(document).on('click', '.selected-product-remove', function() {
        const productId =
            String(
                $(this).data('product-id')
            );

        const productType =
            String(
                $(this).data('product-type')
            );

        $('.builder-product-radio').each(function() {
            const product =
                $(this);

            if (
                String(product.val()) === productId &&
                String(product.data('product-type')) === productType
            ) {
                product.prop(
                    'checked',
                    false
                );
            }
        });

        saveProducts();
        updateSelectedProducts();
    });

    $('#clearSelection').on('click', function() {
        $('.builder-product-radio').prop(
            'checked',
            false
        );

        localStorage.removeItem(
            storageKey
        );

        updateSelectedProducts();
    });

    $('#proceedBuilder').on('click', function() {
        const selectedProducts = {};

        $('.builder-product-radio:checked').each(function() {
            const product =
                $(this);

            selectedProducts[
                String(
                    product.data('product-type')
                )
            ] = String(
                product.val()
            );
        });

        if (!Object.keys(selectedProducts).length) {
            alert(
                'Please select at least one product.'
            );

            return;
        }

        localStorage.setItem(
            storageKey,
            JSON.stringify(selectedProducts)
        );
    });

    restoreProducts();
});
</script>
@endpush

@endsection
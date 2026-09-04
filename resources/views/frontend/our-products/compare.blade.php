@extends('frontend.layouts.app')

@section('title', 'Compare Products')

@section('content')



<div class="compare-page">
    <div class="container">

        <div class="compare-header">
            <h2>Compare Products</h2>
            <p>Compare products, prices and specifications side by side.</p>
        </div>

        <div id="compareMessage" class="alert alert-info compare-message">
            Loading comparison...
        </div>

        <div id="compareLoading" class="compare-loading" style="display:none;">
            <i class="fa fa-spinner fa-spin fa-2x"></i>
            <p>Loading products...</p>
        </div>

        <div id="compareProductsArea" class="row" style="display:none;">

            <div class="col-lg-6 col-md-6 mb-30">
                <div class="compare-product-card">

                    <div id="image1" class="compare-product-image"></div>

                    <div id="brand1" class="compare-brand"></div>

                    <div id="productColumn1" class="compare-product-name"></div>

                    <div id="price1" class="compare-price"></div>

                    <div id="action1"></div>

                </div>
            </div>

            <div class="col-lg-6 col-md-6 mb-30">
                <div class="compare-product-card">

                    <div id="image2" class="compare-product-image"></div>

                    <div id="brand2" class="compare-brand"></div>

                    <div id="productColumn2" class="compare-product-name"></div>

                    <div id="price2" class="compare-price"></div>

                    <div id="action2"></div>

                </div>
            </div>

        </div>

        <div id="compareTableArea" class="compare-table-wrapper" style="display:none;">

            <div class="table-responsive">

                <table class="table compare-table">

                    <thead>
                        <tr>
                            <th>Product Information</th>
                            <th>Product 1</th>
                            <th>Product 2</th>
                        </tr>
                    </thead>

                    <tbody>

                        <tr>
                            <th>Product Name</th>
                            <td id="name1"></td>
                            <td id="name2"></td>
                        </tr>

                        <tr>
                            <th>Short Description</th>
                            <td id="shortDescription1" class="compare-short-description"></td>
                            <td id="shortDescription2" class="compare-short-description"></td>
                        </tr>

                        <tr>
                            <th>Brand</th>
                            <td id="brandTable1"></td>
                            <td id="brandTable2"></td>
                        </tr>

                        <tr>
                            <th>Category</th>
                            <td id="category1"></td>
                            <td id="category2"></td>
                        </tr>

                        <tr>
                            <th>Sub Category</th>
                            <td id="subCategory1"></td>
                            <td id="subCategory2"></td>
                        </tr>

                        <tr>
                            <th>Price</th>
                            <td id="priceTable1"></td>
                            <td id="priceTable2"></td>
                        </tr>

                    </tbody>

                    <tbody id="specificationRows"></tbody>

                    <tbody>

                        <tr>
                            <th>Action</th>
                            <td id="actionTable1"></td>
                            <td id="actionTable2"></td>
                        </tr>

                    </tbody>

                </table>

            </div>

        </div>

        <div id="clearCompareArea" class="compare-clear-wrapper" style="display:none;">

            <button type="button" id="clearCompare" class="compare-clear-btn">
                <i class="fa fa-trash"></i>
                Clear Comparison
            </button>

        </div>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    let compareIds = [];

    try {
        compareIds = JSON.parse(localStorage.getItem('compareProducts') || '[]');
    } catch (error) {
        compareIds = [];
    }

    compareIds = compareIds
        .map(Number)
        .filter(function (id) {
            return id > 0;
        })
        .filter(function (id, index, array) {
            return array.indexOf(id) === index;
        })
        .slice(0, 2);

    const message = document.getElementById('compareMessage');
    const loading = document.getElementById('compareLoading');
    const productsArea = document.getElementById('compareProductsArea');
    const tableArea = document.getElementById('compareTableArea');
    const clearArea = document.getElementById('clearCompareArea');

    if (compareIds.length < 2) {
        message.innerHTML = '<strong>Please select two products to compare.</strong>';
        return;
    }

    loadCompareProducts();

    function loadCompareProducts() {
        loading.style.display = 'block';
        message.style.display = 'none';

        const url = "{{ route('compare.products') }}" +
            "?ids[]=" + encodeURIComponent(compareIds[0]) +
            "&ids[]=" + encodeURIComponent(compareIds[1]);

        fetch(url, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(function (response) {
            if (!response.ok) {
                throw new Error('HTTP ' + response.status);
            }

            return response.json();
        })
        .then(function (response) {
            loading.style.display = 'none';

            if (!response.products || !Array.isArray(response.products) || response.products.length < 2) {
                message.style.display = 'block';
                message.className = 'alert alert-danger compare-message';
                message.innerHTML = 'Unable to load both products.';
                return;
            }

            const product1 = response.products[0];
            const product2 = response.products[1];

            productsArea.style.display = 'flex';
            tableArea.style.display = 'block';
            clearArea.style.display = 'block';

            renderProduct(product1, 1);
            renderProduct(product2, 2);
            renderSpecifications(product1, product2);
        })
        .catch(function () {
            loading.style.display = 'none';
            message.style.display = 'block';
            message.className = 'alert alert-danger compare-message';
            message.innerHTML = 'Something went wrong while loading comparison data.';
        });
    }

    function renderProduct(product, index) {
        const productName = product.name || '-';
        const shortDescription = product.short_description || '-';
        const brand = product.brand || '-';
        const category = product.category || '-';
        const subCategory = product.sub_category || '-';

        const imageElement = document.getElementById('image' + index);

        document.getElementById('productColumn' + index).innerHTML =
            '<a href="' + escapeAttribute(product.detail_url || '#') + '" title="View Product Details">' +
            escapeHtml(productName) +
            '</a>';

        document.getElementById('shortDescription' + index).textContent = shortDescription;
        document.getElementById('brand' + index).textContent = brand;
        document.getElementById('brandTable' + index).textContent = brand;
        document.getElementById('category' + index).textContent = category;
        document.getElementById('subCategory' + index).textContent = subCategory;

        if (product.image) {
            imageElement.innerHTML =
                '<a href="' + escapeAttribute(product.detail_url || '#') + '" title="View Product Details">' +
                '<img src="' + escapeAttribute(product.image) + '" alt="' + escapeAttribute(productName) + '">' +
                '</a>';
        } else {
            imageElement.innerHTML =
                '<span class="no-value">No image</span>';
        }

        const priceHtml = getPriceHtml(product);

        document.getElementById('price' + index).innerHTML = priceHtml;
        document.getElementById('priceTable' + index).innerHTML = priceHtml;

        document.getElementById('name' + index).innerHTML =
            '<a class="product-link" href="' +
            escapeAttribute(product.detail_url || '#') +
            '" title="View Product Details">' +
            escapeHtml(productName) +
            '</a>';

        const cartUrl = product.cart_url || ('/cart/add/' + product.id);

        const actionHtml =
            '<a href="' +
            escapeAttribute(cartUrl) +
            '" class="compare-cart-btn">' +
            '<i class="fa fa-shopping-cart"></i> Add to Cart' +
            '</a>';

        document.getElementById('action' + index).innerHTML = actionHtml;
        document.getElementById('actionTable' + index).innerHTML = actionHtml;
    }

    function getPriceHtml(product) {
        const regularPrice = parsePrice(product.price);
        const salePrice = parsePrice(product.sale_price);

        if (salePrice > 0 && regularPrice > salePrice) {
            return '<span class="sale-price">₹' +
                formatPrice(salePrice) +
                '</span>' +
                '<span class="regular-price">₹' +
                formatPrice(regularPrice) +
                '</span>';
        }

        if (regularPrice > 0) {
            return '<span class="sale-price">₹' +
                formatPrice(regularPrice) +
                '</span>';
        }

        if (salePrice > 0) {
            return '<span class="sale-price">₹' +
                formatPrice(salePrice) +
                '</span>';
        }

        return '<span class="no-value">Price unavailable</span>';
    }

    function parsePrice(value) {
        if (value === null || value === undefined || value === '') {
            return 0;
        }

        const cleaned = String(value)
            .replace(/,/g, '')
            .replace(/[^\d.-]/g, '');

        const number = Number(cleaned);

        return isNaN(number) ? 0 : number;
    }

    function renderSpecifications(product1, product2) {
        const container = document.getElementById('specificationRows');

        const specs1 = normalizeSpecifications(product1.specifications);
        const specs2 = normalizeSpecifications(product2.specifications);

        const names = {};

        specs1.forEach(function (spec) {
            if (spec.name) {
                names[normalizeValue(spec.name)] = spec.name;
            }
        });

        specs2.forEach(function (spec) {
            if (spec.name) {
                names[normalizeValue(spec.name)] = spec.name;
            }
        });

        const specificationNames = Object.values(names);

        if (!specificationNames.length) {
            container.innerHTML =
                '<tr>' +
                '<th class="specification-heading">' +
                '<i class="fa fa-list-alt"></i> Product Specifications' +
                '</th>' +
                '<td colspan="2" class="no-value">No specifications available for these products.</td>' +
                '</tr>';

            return;
        }

        let html =
            '<tr>' +
            '<th colspan="3" class="specification-heading">' +
            '<i class="fa fa-list-alt"></i> Product Specifications' +
            '</th>' +
            '</tr>';

        specificationNames.forEach(function (name) {
            const value1 = getSpecificationValue(specs1, name);
            const value2 = getSpecificationValue(specs2, name);
            const same = normalizeValue(value1) === normalizeValue(value2);

            html +=
                '<tr>' +
                '<th class="specification-name">' +
                '<i class="fa fa-angle-right"></i> ' +
                escapeHtml(name) +
                '</th>' +
                '<td class="spec-value ' +
                (same ? 'spec-same' : 'spec-different') +
                '">' +
                escapeHtml(value1 || '-') +
                '</td>' +
                '<td class="spec-value ' +
                (same ? 'spec-same' : 'spec-different') +
                '">' +
                escapeHtml(value2 || '-') +
                '</td>' +
                '</tr>';
        });

        container.innerHTML = html;
    }

    function normalizeSpecifications(specifications) {
        if (!Array.isArray(specifications)) {
            return [];
        }

        return specifications
            .map(function (spec) {
                return {
                    name: spec.name ?? spec.specification_name ?? '',
                    value: spec.value ?? spec.specification_value ?? ''
                };
            })
            .filter(function (spec) {
                return String(spec.name).trim() !== '';
            });
    }

    function getSpecificationValue(specifications, name) {
        const wanted = normalizeValue(name);

        const spec = specifications.find(function (item) {
            return normalizeValue(item.name) === wanted;
        });

        if (!spec) {
            return '-';
        }

        return spec.value !== null &&
            spec.value !== undefined &&
            String(spec.value).trim() !== ''
            ? String(spec.value)
            : '-';
    }

    function normalizeValue(value) {
        return String(value ?? '').trim().toLowerCase();
    }

    function formatPrice(value) {
        return Number(value || 0).toLocaleString('en-IN', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }

    function escapeHtml(value) {
        const div = document.createElement('div');
        div.textContent = value ?? '';
        return div.innerHTML;
    }

    function escapeAttribute(value) {
        return String(value ?? '')
            .replace(/&/g, '&amp;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;');
    }

    const clearButton = document.getElementById('clearCompare');

    if (clearButton) {
        clearButton.addEventListener('click', function () {
            localStorage.removeItem('compareProducts');
            window.location.href = "{{ route('our-products') }}";
        });
    }
});
</script>

@endsection
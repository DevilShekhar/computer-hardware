@extends('frontend.layouts.app')
@section('title', $meta_title)
@section('meta_keyword', $meta_keyword)
@section('meta_description', $meta_description)
@section('content')
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-content text-center">
                        <h2>Our Sub Categories</h2>
                        <ul>
                            <li>
                                <a href="{{ route('home') }}">Home</a>
                            </li>
                            <li class="active">
                                Our Sub Categories
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="team-area pt-60 pt-sm-44">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="li-section-title capitalize mb-25">
                        <h2>
                            <span>Our Sub Categories</span>
                        </h2>
                    </div>
                </div>
            </div>
            @if($subCategories->isNotEmpty())
                <div class="row" id="subCategoryGrid">
                    @foreach($subCategories as $subCategory)
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="team-member mb-60 mb-sm-30 mb-xs-30">
                                <div class="team-thumb">
                                    <a href="{{ route('our-sub-category.show', ['slug' => $subCategory->slug]) }}">
                                        <img src="{{ $subCategory->sub_cat_image ? asset('storage/' . $subCategory->sub_cat_image) : asset('images/no-image.png') }}"
                                             alt="{{ $subCategory->name }}"
                                             style="width: 100%; height: 220px; object-fit: contain;">
                                    </a>
                                </div>
                                <div class="team-content text-center">
                                    <h3>
                                        <a href="{{ route('our-sub-category.show', ['slug' => $subCategory->slug]) }}">
                                            {{ $subCategory->name }}
                                        </a>
                                    </h3>
                                    @if($subCategory->category)
                                        <p>
                                            {{ $subCategory->category->name }}
                                        </p>
                                    @endif
                                    <p>
                                        <a href="{{ route('our-sub-category.show', ['slug' => $subCategory->slug]) }}">
                                            View Products
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="paginatoin-area">
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <p id="subCategoryShowingText">
                                Showing
                                {{ $subCategories->firstItem() }}
                                -
                                {{ $subCategories->lastItem() }}
                                of
                                {{ $subCategories->total() }}
                                item(s)
                            </p>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <ul class="pagination-box" id="subCategoryPagination"></ul>
                        </div>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col-12">
                        <div class="text-center pt-40 pb-60">
                            <h3>No Sub Categories Available</h3>
                            <p>
                                There are currently no sub categories available.
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const grid       = document.getElementById('subCategoryGrid');
    const pagination = document.getElementById('subCategoryPagination');
    const showingTxt = document.getElementById('subCategoryShowingText');

    if (!grid || !pagination) return;

    let currentPage = {{ $subCategories->currentPage() }};
    const perPage   = {{ $subCategories->perPage() }};

    function escapeHtml(value) {
        const div = document.createElement('div');
        div.textContent = value ?? '';
        return div.innerHTML;
    }

    function cardHtml(item) {
        const fallback = "{{ asset('images/no-image.png') }}";
        const img      = item.image || fallback;

        let categoryLine = '';
        if (item.category) {
            categoryLine = '<p>' + escapeHtml(item.category) + '</p>';
        }

        return '<div class="col-lg-3 col-md-6 col-sm-6">' +
            '<div class="team-member mb-60 mb-sm-30 mb-xs-30">' +
                '<div class="team-thumb">' +
                    '<a href="' + item.detail_url + '">' +
                        '<img src="' + img + '" alt="' + escapeHtml(item.name) + '" style="width: 100%; height: 220px; object-fit: contain;">' +
                    '</a>' +
                '</div>' +
                '<div class="team-content text-center">' +
                    '<h3>' +
                        '<a href="' + item.detail_url + '">' + escapeHtml(item.name) + '</a>' +
                    '</h3>' +
                    categoryLine +
                    '<p>' +
                        '<a href="' + item.detail_url + '">View Products</a>' +
                    '</p>' +
                '</div>' +
            '</div>' +
        '</div>';
    }

    function renderPagination(meta) {
        const current = parseInt(meta.current_page, 10) || 1;
        const last    = parseInt(meta.last_page, 10) || 1;

        pagination.innerHTML = '';
        if (last <= 1) return;

        let html = '';

        if (current > 1) {
            html += '<li><a href="javascript:void(0)" class="Previous" data-page="' + (current - 1) + '">' +
                    '<i class="fa fa-chevron-left"></i> Previous</a></li>';
        } else {
            html += '<li><span class="Previous disabled">' +
                    '<i class="fa fa-chevron-left"></i> Previous</span></li>';
        }

        for (let p = 1; p <= last; p++) {
            if (p === current) {
                html += '<li class="active"><a href="javascript:void(0);">' + p + '</a></li>';
            } else {
                html += '<li><a href="javascript:void(0)" data-page="' + p + '">' + p + '</a></li>';
            }
        }

        if (current < last) {
            html += '<li><a href="javascript:void(0)" class="Next" data-page="' + (current + 1) + '">' +
                    'Next <i class="fa fa-chevron-right"></i></a></li>';
        } else {
            html += '<li><span class="Next disabled">' +
                    'Next <i class="fa fa-chevron-right"></i></span></li>';
        }

        pagination.innerHTML = html;

        pagination.querySelectorAll('a[data-page]').forEach(function (link) {
            link.addEventListener('click', function (e) {
                e.preventDefault();
                const page = parseInt(this.dataset.page, 10) || 1;
                if (page === currentPage) return;
                loadPage(page);
            });
        });
    }

    function updateShowingText(meta) {
        if (!showingTxt) return;

        const page   = parseInt(meta.current_page, 10) || 1;
        const totalN = parseInt(meta.total, 10) || 0;
        const countN = parseInt(meta.count, 10) || 0;

        if (totalN === 0) {
            showingTxt.textContent = 'Showing 0 item(s)';
            return;
        }

        const first = (page - 1) * perPage + 1;
        const lastI = first + countN - 1;

        showingTxt.textContent = 'Showing ' + first + ' - ' + lastI + ' of ' + totalN + ' item(s)';
    }

    function loadPage(page) {
        grid.style.opacity = '0.5';

        fetch("{{ route('our-sub-category') }}?page=" + page, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(function (r) { return r.json(); })
        .then(function (data) {
            currentPage = page;

            let html = '';
            if (data.sub_categories && data.sub_categories.length) {
                data.sub_categories.forEach(function (item) {
                    html += cardHtml(item);
                });
            } else {
                html = '<div class="col-12"><div class="text-center pt-40 pb-60">' +
                       '<h3>No Sub Categories Available</h3>' +
                       '<p>There are currently no sub categories available.</p></div></div>';
            }

            grid.innerHTML = html;
            grid.style.opacity = '1';

            renderPagination({
                current_page: data.current_page,
                last_page:    data.last_page
            });

            updateShowingText({
                current_page: data.current_page,
                last_page:    data.last_page,
                count:        data.count,
                total:        data.total
            });

            const y = grid.getBoundingClientRect().top + window.pageYOffset - 120;
            window.scrollTo({ top: y, behavior: 'smooth' });
        })
        .catch(function (err) {
            console.error('Sub-category pagination error:', err);
            grid.style.opacity = '1';
        });
    }

    renderPagination({
        current_page: {{ $subCategories->currentPage() }},
        last_page:    {{ $subCategories->lastPage() }}
    });

    updateShowingText({
        current_page: {{ $subCategories->currentPage() }},
        last_page:    {{ $subCategories->lastPage() }},
        count:        {{ $subCategories->count() }},
        total:        {{ $subCategories->total() }}
    });
});
</script>
@endsection

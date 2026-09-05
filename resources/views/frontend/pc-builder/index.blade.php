@extends('frontend.layouts.app')
@section('content')
<div class="content-wraper pt-60 pb-60">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="pc-builder-toolbar">
                    <div class="row align-items-center">
                        <div class="col-lg-6 col-md-6">
                            <div class="pc-builder-count">
                                Showing 1 to {{ $builderTypes->count() }}
                                of {{ $builderTypes->count() }}
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="pc-builder-sort">
                                <label for="builderSort">
                                    Sort By:
                                </label>
                                <select id="builderSort" onchange="sortBuilderTypes(this.value)">
                                    <option value="name-asc">
                                        Name (A - Z)
                                    </option>
                                    <option value="name-desc">
                                        Name (Z - A)
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pc-builder-list" id="builderTypeList">
                    @forelse($builderTypes as $builderType)
                        <div class="row pc-builder-card" data-name="{{ strtolower($builderType->name) }}">
                            <div class="col-lg-12">
                                <div class="row align-items-center">
                                    <div class="col-lg-8 col-md-8">
                                        <div class="row align-items-center">
                                            <div class="col-lg-5 col-md-5">
                                                <div class="pc-builder-image-wrapper">
                                                    <a href="{{ route('pc-builder.show', $builderType->slug) }}">
                                                        @if($builderType->image)
                                                            <img src="{{ asset('storage/' . $builderType->image) }}" alt="{{ $builderType->name }}" class="pc-builder-image">
                                                        @else
                                                            <img src="{{ asset('assets/frontend/assets/images/product/large-size/1.jpg') }}" alt="{{ $builderType->name }}" class="pc-builder-image">
                                                        @endif
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-lg-7 col-md-7">
                                                <div class="pc-builder-details">
                                                    <div class="pc-builder-label">
                                                        PC BUILDER
                                                    </div>
                                                    <h2 class="pc-builder-name">
                                                        <a href="{{ route('pc-builder.show', $builderType->slug) }}">
                                                            {{ $builderType->name }}
                                                        </a>
                                                    </h2>
                                                    <div class="pc-builder-line"></div>
                                                    <h3>
                                                        Build Your PC
                                                    </h3>
                                                    <p>
                                                       {{ $builderType->description }}
                                                    </p>
                                                    <div class="pc-builder-features">
                                                        <div class="pc-builder-feature">
                                                            <span class="feature-icon">
                                                                <i class="fa fa-cogs"></i>
                                                            </span>
                                                            <span>
                                                                Choose Components
                                                            </span>
                                                        </div>
                                                        <div class="feature-divider"></div>
                                                        <div class="pc-builder-feature">
                                                            <span class="feature-icon">
                                                                <i class="fa fa-desktop"></i>
                                                            </span>
                                                            <span>
                                                                Easy Customization
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <div class="pc-builder-action">
                                            <a href="{{ route('pc-builder.show', $builderType->slug) }}" class="pc-builder-start-button">
                                                <span class="pc-builder-button-icon">
                                                    <i class="fa fa-wrench"></i>
                                                </span>
                                                <span class="pc-builder-button-text">
                                                    START BUILDING
                                                </span>
                                                <span class="pc-builder-arrow">
                                                    <i class="fa fa-angle-right"></i>
                                                </span>
                                            </a>
                                            <div class="pc-builder-check-list">
                                                <div class="pc-builder-check-item">
                                                    <span class="check-icon">
                                                       <i class="fa fa-check"></i>
                                                    </span>
                                                    <span>
                                                        Choose Components
                                                    </span>
                                                </div>
                                                <div class="pc-builder-check-item">
                                                    <span class="check-icon">
                                                        <i class="fa fa-check"></i>
                                                    </span>
                                                    <span>
                                                        Compare Easily
                                                    </span>
                                                </div>
                                                <div class="pc-builder-check-item">
                                                    <span class="check-icon">
                                                       <i class="fa fa-check"></i>
                                                    </span>
                                                    <span>
                                                        Build Your Dream PC
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="pc-builder-empty">
                                    <div class="pc-builder-empty-icon">
                                        <i class="fa fa-desktop"></i>
                                    </div>
                                    <h3>
                                        No PC Builder Types Available
                                    </h3>
                                    <p>
                                        Please check back later for available
                                        PC Builder options.
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforelse
                </div>
                @if($builderTypes->count())
                    <div class="pc-builder-footer">
                        <div class="row align-items-center">
                            <div class="col-lg-6 col-md-6">
                                <div class="pc-builder-footer-count">
                                    Showing 1-{{ $builderTypes->count() }}
                                    of {{ $builderTypes->count() }}
                                    PC Builder Type(s)
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="pc-builder-pagination">
                                    <span class="active">
                                       1
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
@push('styles')
<style>
    .pc-builder-page {
        width: 100%;
        padding: 40px 0 70px;
        background: #ffffff;
    }

    .pc-builder-toolbar {
        width: 100%;
        margin-bottom: 30px;
        padding: 18px 25px;
        border: 1px solid #e5e8ed;
        border-radius: 6px;
        background: #ffffff;
        box-shadow: 0 3px 15px rgba(18, 38, 63, 0.04);
    }

    .pc-builder-count {
        color: #17233c;
        font-size: 15px;
        font-weight: 500;
    }

    .pc-builder-sort {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 12px;
    }

    .pc-builder-sort label {
        margin: 0;
        color: #687386;
        font-size: 14px;
        font-weight: 500;
    }

    .pc-builder-sort select {
        width: 220px;
        height: 45px;
        padding: 0 15px;
        border: 1px solid #dfe4eb;
        border-radius: 5px;
        outline: none;
        background: #ffffff;
        color: #17233c;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
    }

    .pc-builder-list {
        width: 100%;
    }

    .pc-builder-card {
        margin: 0 0 20px;
        padding: 20px 0;
        border: 1px solid #e5e8ed;
        border-radius: 8px;
        background: #ffffff;
        box-shadow: 0 4px 20px rgba(18, 38, 63, 0.04);
        transition: all 0.3s ease;
    }

    .pc-builder-card:hover {
        border-color: #d7dee8;
        box-shadow: 0 8px 30px rgba(18, 38, 63, 0.08);
        transform: translateY(-2px);
    }

    .pc-builder-image-wrapper {
        width: 100%;
        height: 250px;
        overflow: hidden;
        border-radius: 7px;
        background: #f5f7fa;
    }

    .pc-builder-image-wrapper a {
        width: 100%;
        height: 100%;
        display: block;
    }

    .pc-builder-image {
        width: 100%;
        height: 100%;
        display: block;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .pc-builder-card:hover .pc-builder-image {
        transform: scale(1.03);
    }

    .pc-builder-details {
        padding: 10px 20px;
    }

    .pc-builder-label {
        margin-bottom: 7px;
        color: #7b8798;
        font-size: 13px;
        font-weight: 500;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }

    .pc-builder-name {
        margin: 0;
        font-size: 28px;
        line-height: 1.3;
        font-weight: 700;
    }

    .pc-builder-name a {
        color: #10203d;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .pc-builder-name a:hover {
        color: #1976ed;
    }

    .pc-builder-line {
        width: 62px;
        height: 4px;
        margin: 13px 0 21px;
        border-radius: 10px;
        background: #1976ed;
    }

    .pc-builder-details h3 {
        margin: 0 0 7px;
        color: #17233c;
        font-size: 18px;
        line-height: 1.4;
        font-weight: 700;
    }

    .pc-builder-details p {
        max-width: 550px;
        margin: 0;
        color: #687386;
        font-size: 14px;
        line-height: 1.7;
    }

    .pc-builder-features {
        margin-top: 22px;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .pc-builder-feature {
        display: flex;
        align-items: center;
        gap: 7px;
        color: #263653;
        font-size: 13px;
        font-weight: 500;
        white-space: nowrap;
    }

    .feature-icon {
        color: #1976ed;
        font-size: 17px;
    }

    .feature-divider {
        width: 1px;
        height: 25px;
        background: #dfe4eb;
    }

    .pc-builder-action {
        min-height: 250px;
        margin-right: 20px;
        padding: 25px;
        border-left: 1px solid #dfe4eb;
        border-radius: 0 7px 7px 0;
        background: linear-gradient(
            135deg,
            #f8fbff 0%,
            #eef6ff 100%
        );
    }

    .pc-builder-start-button {
        width: 100%;
        min-height: 65px;
        padding: 0 20px;
        display: flex;
        align-items: center;
        gap: 14px;
        border-radius: 7px;
        background: #1976ed;
        color: #ffffff;
        text-decoration: none;
        font-size: 16px;
        font-weight: 700;
        letter-spacing: 0.2px;
        box-shadow: 0 5px 14px rgba(25, 118, 237, 0.22);
        transition: all 0.3s ease;
    }

    .pc-builder-start-button:hover {
        background: #1265d1;
        color: #ffffff;
        text-decoration: none;
        box-shadow: 0 8px 20px rgba(25, 118, 237, 0.3);
        transform: translateY(-1px);
    }

    .pc-builder-button-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 23px;
    }

    .pc-builder-button-text {
        display: inline-block;
    }

    .pc-builder-arrow {
        margin-left: auto;
        display: inline-flex;
        align-items: center;
        font-size: 28px;
        line-height: 1;
    }

    .pc-builder-check-list {
        margin-top: 22px;
        display: flex;
        flex-direction: column;
        gap: 13px;
    }

    .pc-builder-check-item {
        display: flex;
        align-items: center;
        gap: 12px;
        color: #41516c;
        font-size: 14px;
        font-weight: 500;
    }

    .check-icon {
        width: 27px;
        height: 27px;
        flex: 0 0 27px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: #1976ed;
        color: #ffffff;
        font-size: 12px;
    }

    .pc-builder-empty {
        padding: 70px 20px;
        text-align: center;
        border: 1px solid #e5e8ed;
        border-radius: 8px;
        background: #ffffff;
    }

    .pc-builder-empty-icon {
        width: 70px;
        height: 70px;
        margin: 0 auto 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: #eef6ff;
        color: #1976ed;
        font-size: 28px;
    }

    .pc-builder-empty h3 {
        margin: 0 0 8px;
        color: #17233c;
        font-size: 22px;
        font-weight: 700;
    }

    .pc-builder-empty p {
        margin: 0;
        color: #7b8798;
        font-size: 14px;
    }

    .pc-builder-footer {
        margin-top: 30px;
        padding-top: 25px;
        border-top: 1px solid #e5e8ed;
    }

    .pc-builder-footer-count {
        color: #687386;
        font-size: 14px;
    }

    .pc-builder-pagination {
        display: flex;
        justify-content: flex-end;
    }

    .pc-builder-pagination span {
        width: 38px;
        height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #1976ed;
        border-radius: 4px;
        background: #1976ed;
        color: #ffffff;
        font-size: 14px;
        font-weight: 600;
    }

    @media (max-width: 1199px) {
        .pc-builder-image-wrapper {
            height: 220px;
        }

        .pc-builder-action {
            min-height: 220px;
        }

        .pc-builder-name {
            font-size: 25px;
        }

        .pc-builder-features {
            flex-wrap: wrap;
        }
    }

    @media (max-width: 991px) {
        .pc-builder-toolbar {
            padding: 18px 20px;
        }

        .pc-builder-sort {
            margin-top: 15px;
            justify-content: flex-start;
        }

        .pc-builder-card {
            padding: 15px 0;
        }

        .pc-builder-details {
            padding: 25px 15px;
        }

        .pc-builder-action {
            min-height: auto;
            margin: 20px 15px 0;
            padding: 20px;
            border-top: 1px solid #dfe4eb;
            border-left: 0;
            border-radius: 0 0 7px 7px;
        }

        .pc-builder-check-list {
            flex-direction: row;
            flex-wrap: wrap;
            gap: 15px 30px;
        }
    }

    @media (max-width: 767px) {
        .content-wraper {
            padding-top: 30px !important;
            padding-bottom: 40px !important;
        }

        .pc-builder-sort {
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
        }

        .pc-builder-sort select {
            width: 100%;
        }

        .pc-builder-image-wrapper {
            height: 230px;
        }

        .pc-builder-details {
            padding: 20px 10px;
        }

        .pc-builder-name {
            font-size: 24px;
        }

        .pc-builder-features {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }

        .feature-divider {
            display: none;
        }

        .pc-builder-action {
            margin: 10px 10px 0;
            padding: 18px;
        }

        .pc-builder-start-button {
            min-height: 60px;
            font-size: 14px;
        }

        .pc-builder-pagination {
            margin-top: 15px;
            justify-content: flex-start;
        }
    }

    @media (max-width: 575px) {
        .pc-builder-toolbar {
            padding: 15px;
        }

        .pc-builder-image-wrapper {
            height: 200px;
        }

        .pc-builder-label {
            font-size: 12px;
        }

        .pc-builder-name {
            font-size: 22px;
        }

        .pc-builder-details h3 {
            font-size: 17px;
        }

        .pc-builder-details p {
            font-size: 13px;
        }

        .pc-builder-check-item {
            font-size: 13px;
        }

        .pc-builder-button-icon {
            font-size: 20px;
        }

        .pc-builder-arrow {
            font-size: 24px;
        }
    }
</style>

@endpush

@push('scripts')

<script>
    function sortBuilderTypes(value) {
        const container = document.getElementById('builderTypeList');

        if (!container) {
            return;
        }

        const items = Array.from(
            container.querySelectorAll('.pc-builder-card')
        );

        items.sort(function (a, b) {
            const nameA = a.getAttribute('data-name') || '';
            const nameB = b.getAttribute('data-name') || '';

            if (value === 'name-desc') {
                return nameB.localeCompare(nameA);
            }

            return nameA.localeCompare(nameB);
        });

        items.forEach(function (item) {
            container.appendChild(item);
        });
    }
</script>

@endpush
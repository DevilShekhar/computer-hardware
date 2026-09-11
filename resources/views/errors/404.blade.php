@extends('admin.layouts.app')

@section('content')

    <section class="section">
        <div class="section-body">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body text-center py-5">

                            <div class="mb-4">
                                <h1 style="font-size: 100px; font-weight: 700;">
                                    404
                                </h1>
                            </div>

                            <h3>Access Denied</h3>

                            <p class="text-muted">
                                You do not have permission to access this page.
                            </p>

                            <p class="text-muted">
                                Please contact the administrator if you believe
                                you should have access to this page.
                            </p>

                            <a href="{{ route('dashboard') }}"
                               class="btn btn-primary">
                                <i class="fas fa-home"></i>
                                Back to Dashboard
                            </a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
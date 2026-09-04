@extends('admin.layouts.app')
@section('content')

<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Product Review Listing</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-1">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Product Image</th>
                                        <th>Product</th>
                                        <th>Customer</th>
                                        <th>Rating</th>
                                        <th>Review</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($reviews as $review)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>
                                            @php
                                                $primaryImage = $review->product?->images?->where('is_primary', true)->first();
                                                if (!$primaryImage) {
                                                    $primaryImage = $review->product?->images?->first();
                                                }
                                            @endphp
                                            @if($primaryImage && $primaryImage->image)
                                            <img src="{{ asset('storage/' . $primaryImage->image) }}"
                                                alt="{{ $review->product->name ?? 'Product' }}"
                                                width="50"
                                                height="50"
                                                class="rounded"
                                                style="object-fit: cover;">
                                            @else
                                            <img src="{{ asset('assets/img/default.png') }}"
                                                alt="Product Image"
                                                width="50"
                                                height="50"
                                                class="rounded"
                                                style="object-fit: cover;">
                                            @endif
                                        </td>
                                        <td>
                                            <strong>{{ $review->product->name ?? '-' }}</strong>
                                        </td>
                                        <td>
                                            <strong>{{ $review->user->name ?? '-' }}</strong>
                                            @if($review->user && $review->user->email)
                                            <small class="d-block text-muted">
                                                {{ $review->user->email }}
                                            </small>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="text-warning">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= $review->rating)
                                                    <i class="fas fa-star"></i>
                                                    @else
                                                    <i class="far fa-star"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                            <small class="d-block text-muted">
                                                {{ $review->rating }}/5
                                            </small>
                                        </td>
                                        <td>
                                            <span title="{{ $review->comment }}">
                                                {{ \Illuminate\Support\Str::limit($review->comment, 60) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($review->status == 1)
                                            <div class="badge badge-success badge-shadow">
                                                Approved
                                            </div>
                                            @else
                                            <div class="badge badge-warning badge-shadow">
                                                Pending
                                            </div>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $review->created_at ? $review->created_at->format('d-m-Y') : '-' }}
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($review->status == 0)
                                                <form action="{{ route('product-review.approve', $review->id) }}"
                                                    method="POST"
                                                    class="approve-review-form mr-1">
                                                    @csrf
                                                    <button type="submit"
                                                        class="btn btn-success btn-sm"
                                                        title="Approve">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>
                                                @else
                                                <form action="{{ route('product-review.reject', $review->id) }}"
                                                    method="POST"
                                                    class="reject-review-form">
                                                    @csrf
                                                    <button type="submit"
                                                        class="btn btn-danger btn-sm"
                                                        title="Reject">
                                                        <i class="fas fa-ban"></i>
                                                    </button>
                                                </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="9" class="text-center">
                                            No product reviews found.
                                        </td>
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
                    targets: [0, 1, 8]
                }
            ]
        });

        $('.approve-review-form').on('submit', function(e) {
            e.preventDefault();

            let form = this;

            Swal.fire({
                title: 'Approve Review?',
                text: 'This review will be published on the website.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#47c363',
                cancelButtonColor: '#6777ef',
                confirmButtonText: 'Yes, approve',
                cancelButtonText: 'Cancel'
            }).then(function(result) {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });

        $('.reject-review-form').on('submit', function(e) {
            e.preventDefault();

            let form = this;

            Swal.fire({
                title: 'Reject Review?',
                text: 'This review will no longer be visible on the website.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#fc544b',
                cancelButtonColor: '#6777ef',
                confirmButtonText: 'Yes, reject',
                cancelButtonText: 'Cancel'
            }).then(function(result) {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>

@if(session('success'))

<script>
    Swal.fire({
        title: 'Success!',
        text: @json(session('success')),
        icon: 'success',
        confirmButtonColor: '#6777ef',
        confirmButtonText: 'OK'
    });
</script>

@endif
@endpush

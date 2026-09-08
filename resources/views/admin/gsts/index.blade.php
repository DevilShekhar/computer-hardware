@extends('admin.layouts.app')
@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>GST</h4>
                        <div class="card-header-action">
                            @if(!$gst)
                                <a href="{{ route('gsts.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Add GST
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-1">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>GST (%)</th>
                                        <th>Status</th>
                                        <th>Created By</th>
                                        <th>Updated By</th>
                                        <th>Created At</th>
                                        <th>Updated At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($gst)
                                    <tr>
                                        <td class="text-center"> 1</td>
                                        <td>
                                            <strong>
                                                {{ number_format($gst->gst_amount, 2) }}%
                                            </strong>
                                        </td>
                                        <td>
                                            @if($gst->status)
                                                <div class="badge badge-success badge-shadow">
                                                    Active
                                                </div>
                                            @else
                                                <div class="badge badge-danger badge-shadow">
                                                    Inactive
                                                </div>
                                            @endif
                                        </td>
                                        <td> {{ $gst->createdBy->name ?? '-' }}</td>
                                        <td> {{ $gst->updatedBy->name ?? '-' }} </td>
                                        <td> {{ $gst->created_at ? $gst->created_at->format('d-m-Y') : '-' }}</td>
                                        <td> {{ $gst->updated_at ? $gst->updated_at->format('d-m-Y') : '-' }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <a href="{{ route('gsts.show', $gst->id) }}" class="btn btn-info btn-sm mr-1" title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('gsts.edit', $gst->id) }}" class="btn btn-primary btn-sm"  title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @else
                                    <tr>
                                        <td colspan="8" class="text-center">
                                            No GST record found.
                                        </td>
                                    </tr>
                                    @endif
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
            paging: false,
            info: false,
            columnDefs: [
                {
                    orderable: false,
                    targets: [0, 7]
                }
            ]
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
@if(session('error'))
<script>
    Swal.fire({
        title: 'Error!',
        text: @json(session('error')),
        icon: 'error',
        confirmButtonColor: '#fc544b',
        confirmButtonText: 'OK'
    });
</script>
@endif
@endpush
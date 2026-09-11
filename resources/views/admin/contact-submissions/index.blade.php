@can('contact-index')
@extends('admin.layouts.app')
@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Contact Submissions</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="table-1">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Subject</th>
                                    <th>Message</th>
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($contacts as $contact)
                                <tr>
                                    <td class="text-center">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>
                                        <strong>
                                            {{ $contact->name }}
                                        </strong>
                                    </td>
                                    <td>
                                        <a href="mailto:{{ $contact->email }}">
                                            {{ $contact->email }}
                                        </a>
                                    </td>
                                    <td>
                                        {{ $contact->subject ?? '-' }}
                                    </td>
                                    <td style="max-width: 400px;">
                                        <div style=" max-width: 400px; white-space: nowrap;overflow: hidden; text-overflow: ellipsis;" title="{{ $contact->message }}">
                                            {{ $contact->message }}
                                        </div>
                                    </td>
                                    <td>
                                        {{ $contact->created_at ? $contact->created_at->format('d-m-Y H:i') : '-' }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">
                                        No contact submissions found.
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
                    targets: [0, 4]
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
@endpush
@else
    @php
        abort(404);
    @endphp
@endcan
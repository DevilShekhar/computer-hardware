@extends('admin.layouts.app')

@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Promotional Banners</h4>
                        <div class="card-header-action">
                            <a href="{{ route('promotional-banners.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Add Promotional Banner
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-1">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Image</th>
                                        <th>Title</th>
                                        <th>Button Text</th>
                                        <th>Button URL</th>
                                        <th>Status</th>
                                        <th>Created By</th>
                                        <th>Updated By</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($promotionalBanners as $banner)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>
                                            @if($banner->image)
                                                <img src="{{ asset('storage/' . $banner->image) }}" alt="{{ $banner->title ?? 'Banner' }}" width="100" height="50" class="rounded" style="object-fit:cover;">
                                            @else
                                                <span class="text-muted">No Image</span>
                                            @endif
                                        </td>
                                        <td>
                                            <strong>{{ $banner->title ?? '-' }}</strong>
                                        </td>
                                        <td>
                                            {{ $banner->button_text ?? '-' }}
                                        </td>
                                        <td>
                                            {{ $banner->button_url ?? '-' }}
                                        </td>
                                        <td>
                                            @if($banner->status)
                                                <span class="badge badge-success badge-shadow">Active</span>
                                            @else
                                                <span class="badge badge-danger badge-shadow">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $banner->createdBy->name ?? '-' }}
                                        </td>
                                        <td>
                                            {{ $banner->updatedBy->name ?? '-' }}
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <a href="{{ route('promotional-banners.show', $banner->id) }}" class="btn btn-info btn-sm mr-1" title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('promotional-banners.edit', $banner->id) }}" class="btn btn-primary btn-sm mr-1" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>

                                                @if($banner->status)
                                                    <form action="{{ route('promotional-banners.destroy', $banner->id) }}" method="POST" class="delete-banner-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" title="Deactivate">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('promotional-banners.activate', $banner->id) }}" method="POST" class="activate-banner-form">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-success btn-sm" title="Activate">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="10" class="text-center">No promotional banners found.</td>
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
$(document).ready(function(){
    $('#table-1').DataTable({
        ordering:true,
        searching:true,
        paging:true,
        info:true,
        pageLength:10,
        lengthMenu:[[10,25,50,100,-1],[10,25,50,100,'All']],
        columnDefs:[
            {
                orderable:false,
                targets:[0,1,9]
            }
        ]
    });

    $('.delete-banner-form').on('submit',function(e){
        e.preventDefault();

        let form=this;

        Swal.fire({
            title:'Are you sure?',
            text:'Do you want to deactivate this promotional banner?',
            icon:'warning',
            showCancelButton:true,
            confirmButtonColor:'#fc544b',
            cancelButtonColor:'#6777ef',
            confirmButtonText:'Yes, deactivate',
            cancelButtonText:'Cancel'
        }).then(function(result){
            if(result.isConfirmed){
                form.submit();
            }
        });
    });

    $('.activate-banner-form').on('submit',function(e){
        e.preventDefault();

        let form=this;

        Swal.fire({
            title:'Are you sure?',
            text:'Do you want to activate this promotional banner?',
            icon:'question',
            showCancelButton:true,
            confirmButtonColor:'#28a745',
            cancelButtonColor:'#6777ef',
            confirmButtonText:'Yes, activate',
            cancelButtonText:'Cancel'
        }).then(function(result){
            if(result.isConfirmed){
                form.submit();
            }
        });
    });
});

@if(session('success'))
Swal.fire({
    title:'Success!',
    text:@json(session('success')),
    icon:'success',
    confirmButtonColor:'#6777ef',
    confirmButtonText:'OK'
});
@endif
</script>
@endpush
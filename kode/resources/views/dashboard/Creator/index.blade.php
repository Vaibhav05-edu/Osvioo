@extends('dashboard.layout.main')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold">Instagram Creators</h2>
            <p class="text-muted small">Manage the list of creators shown in the 'Creators Trust' section.</p>
        </div>
        <a href="{{ route('osivoo-admin.creator.create') }}" class="btn btn-dark px-4">
            <i class="fas fa-plus me-2"></i> Add New Creator
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm p-4" style="border-radius: 15px;">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="80">Order</th>
                        <th width="100">Profile</th>
                        <th>Username</th>
                        <th>Followers</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($creators as $creator)
                    <tr>
                        <td class="fw-bold">#{{ $creator->order }}</td>
                        <td>
                            <img src="{{ asset('storage/' . $creator->profile_pic) }}" 
                                 class="rounded-circle border" 
                                 width="50" height="50" 
                                 style="object-fit: cover;">
                        </td>
                        <td>
                            <div class="fw-bold">{{ $creator->username }}</div>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border">{{ $creator->followers }}</span>
                        </td>
                        <td>
                            @if($creator->status)
                                <span class="badge bg-success-subtle text-success px-3">Active</span>
                            @else
                                <span class="badge bg-danger-subtle text-danger px-3">Inactive</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('osivoo-admin.creator.edit', $creator->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('osivoo-admin.creator.destroy', $creator->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this creator?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="fas fa-users fa-3x mb-3"></i>
                            <p>No creators added yet. Start by adding your first Instagram ID.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $creators->links() }}
        </div>
    </div>
</div>
@endsection
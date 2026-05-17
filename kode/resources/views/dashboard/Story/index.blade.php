@extends('dashboard.layout.main')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Story Statistics Cards</h2>
        <a href="{{ route('osivoo-admin.story.create') }}" class="btn btn-dark px-4">
            <i class="fas fa-plus me-2"></i> Add New Story
        </a>
    </div>

    <div class="card border-0 shadow-sm p-4" style="border-radius: 12px;">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Order</th>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($stories as $story)
                    <tr>
                        <td>#{{ $story->order }}</td>
                        <td>
                            @if($story->image)
                                <img src="{{ asset('storage/' . $story->image) }}" width="60" class="rounded border">
                            @else
                                <span class="text-muted">No Image</span>
                            @endif
                        </td>
                        <td class="fw-bold">{{ $story->title }}</td>
                        <td><small class="text-muted">{{ Str::limit($story->description, 50) }}</small></td>
                        <td>
                            <span class="badge {{ $story->status ? 'bg-success' : 'bg-secondary' }}">
                                {{ $story->status ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="text-end">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('osivoo-admin.story.edit', $story->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('osivoo-admin.story.destroy', $story->id) }}" method="POST" onsubmit="return confirm('Delete this story?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center py-4">No stories found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
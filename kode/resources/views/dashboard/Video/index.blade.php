@extends('dashboard.layout.main')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Video Gallery</h2>
        <a href="{{ route('osivoo-admin.video.create') }}" class="btn btn-dark px-4">Add New Video</a>
    </div>

    <div class="row">
        @forelse($videos as $video)
        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow-sm h-100 rounded-4 overflow-hidden">
                <div class="position-relative">
                    <img src="{{ asset('storage/' . $video->thumbnail) }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                    <span class="position-absolute top-0 end-0 m-2 badge {{ $video->status ? 'bg-success' : 'bg-danger' }}">
                        {{ $video->status ? 'Active' : 'Inactive' }}
                    </span>
                </div>
                <div class="card-body">
                    <h6 class="fw-bold mb-1">{{ $video->title ?? 'Untitled Video' }}</h6>
                    <p class="text-muted small text-truncate">{{ $video->video_url }}</p>
                    <div class="d-flex gap-2">
                        <a href="{{ route('videos.edit', $video->id) }}" class="btn btn-sm btn-outline-primary w-100">Edit</a>
                        <form action="{{ route('videos.destroy', $video->id) }}" method="POST" class="w-100" onsubmit="return confirm('Delete this video?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger w-100">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">No videos found.</div>
        @endforelse
    </div>
    
    <div class="mt-4">
        {{ $videos->links() }}
    </div>
</div>
@endsection
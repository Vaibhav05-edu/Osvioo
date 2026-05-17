@extends('dashboard.layout.main')

@section('content')
<div class="container-fluid py-4">
    <div class="card border-0 shadow-sm p-4 mx-auto" style="max-width: 700px; border-radius: 15px;">
        <h4 class="fw-bold mb-4">Upload New Video Link</h4>
        
        <form action="{{ route('osivoo-admin.video.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-bold">Overlay Title (e.g. GENIUS)</label>
                <input type="text" name="title" class="form-control" placeholder="Enter text to show on video">
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Video URL</label>
                <input type="url" name="video_url" class="form-control" placeholder="https://youtube.com/watch?v=..." required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Video Thumbnail (Cover Image)</label>
                <input type="file" name="thumbnail" class="form-control" required>
                <div class="form-text">As per image_9c6a9c.jpg, use vertical (9:16) images.</div>
            </div>

            <div class="row mb-4">
                <div class="col-6">
                    <label class="form-label fw-bold">Order</label>
                    <input type="number" name="order" class="form-control" value="0">
                </div>
                <div class="col-6 d-flex align-items-end">
                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" name="status" value="1" checked id="vs">
                        <label class="form-check-label fw-bold" for="vs">Active</label>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-dark w-100 py-2 fw-bold">Save Video</button>
        </form>
    </div>
</div>
@endsection
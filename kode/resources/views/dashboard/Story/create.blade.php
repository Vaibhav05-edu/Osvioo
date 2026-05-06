@extends('dashboard.layout.main')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm p-4" style="border-radius: 12px;">
                <h4 class="fw-bold mb-4">Create New Story Card</h4>
                
                <form action="{{ route('socialyt-admin.story.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-bold">Title</label>
                        <input type="text" name="title" class="form-control" placeholder="e.g. 25M+ AutoDM" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Description</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Enter card description..." required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Card Image</label>
                        <input type="file" name="image" class="form-control" required>
                        <div class="form-text text-muted">Use high-quality images like image_aa8d3a.png.</div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Display Order</label>
                            <input type="number" name="order" class="form-control" value="0">
                        </div>
                        <div class="col-md-6 mb-3 d-flex align-items-end">
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" name="status" value="1" checked id="st">
                                <label class="form-check-label fw-bold" for="st">Active Status</label>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                        <a href="{{ route('socialyt-admin.story.index') }}" class="btn btn-light">Cancel</a>
                        <button type="submit" class="btn btn-dark px-4">Create Story</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
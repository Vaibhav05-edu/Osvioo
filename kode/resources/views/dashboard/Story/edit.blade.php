@extends('dashboard.layout.main')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm p-4" style="border-radius: 12px;">
                <h4 class="fw-bold mb-4">Edit Story Card</h4>
                
                <form action="{{ route('osivoo-admin.story.update', $story->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Title</label>
                        <input type="text" name="title" class="form-control" value="{{ $story->title }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Description</label>
                        <textarea name="description" class="form-control" rows="3" required>{{ $story->description }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold d-block">Current Image</label>
                        @if($story->image)
                            <img src="{{ asset('storage/' . $story->image) }}" width="150" class="rounded mb-2 border">
                        @endif
                        <input type="file" name="image" class="form-control">
                        <small class="text-muted">Leave blank if you don't want to change the image.</small>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Display Order</label>
                            <input type="number" name="order" class="form-control" value="{{ $story->order }}">
                        </div>
                        <div class="col-md-6 mb-3 d-flex align-items-end">
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" name="status" value="1" {{ $story->status ? 'checked' : '' }} id="st">
                                <label class="form-check-label fw-bold" for="st">Active Status</label>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                        <a href="{{ route('osivoo-admin.story.index') }}" class="btn btn-light">Cancel</a>
                        <button type="submit" class="btn btn-primary px-4">Update Story</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@extends('dashboard.layout.main')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card border-0 shadow-sm p-4" style="border-radius: 15px;">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="fw-bold mb-0">Edit Feature Stat</h4>
                    <a href="{{ route('osivoo-admin.stats.index') }}" class="btn btn-light btn-sm text-muted">
                        <i class="fas fa-arrow-left me-1"></i> Back to List
                    </a>
                </div>

                <form action="{{ route('osivoo-admin.stats.update', $stat->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <!-- Left Column: Title & Description -->
                        <div class="col-md-7">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Feature Title</label>
                                <input type="text" name="title" class="form-control form-control-lg" 
                                       value="{{ old('title', $stat->title) }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Long Description</label>
                                <textarea name="description" class="form-control" rows="8" 
                                          placeholder="Describe this automation feature in detail..." required>{{ old('description', $stat->description) }}</textarea>
                                <div class="form-text">Bada description likhein jo customers ko feature detail mein samjhaye.</div>
                            </div>
                        </div>

                        <!-- Right Column: Image & Settings -->
                        <div class="col-md-5">
                            <div class="mb-4">
                                <label class="form-label fw-bold d-block">Feature Image Preview</label>
                                <div class="mb-3 p-2 border rounded text-center bg-light">
                                    @if($stat->image)
                                        <img src="{{ asset('storage/' . $stat->image) }}" 
                                             class="img-fluid rounded shadow-sm" style="max-height: 250px;" id="preview">
                                    @else
                                        <div class="py-5 text-muted">No Image Uploaded</div>
                                    @endif
                                </div>
                                <input type="file" name="image" class="form-control" id="imageInput">
                                <small class="text-muted">Nayi image select karein agar purani badalni hai.</small>
                            </div>

                            <div class="row">
                                <div class="col-6 mb-3">
                                    <label class="form-label fw-bold">Display Order</label>
                                    <input type="number" name="order" class="form-control" value="{{ $stat->order }}">
                                </div>
                                <div class="col-6 d-flex align-items-end">
                                    <div class="form-check form-switch mb-2">
                                        <input class="form-check-input" type="checkbox" name="status" value="1" 
                                               id="statusSwitch" {{ $stat->status ? 'checked' : '' }}>
                                        <label class="form-check-label fw-bold" for="statusSwitch">Show on Web</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                        <button type="reset" class="btn btn-outline-secondary px-4">Discard Changes</button>
                        <button type="submit" class="btn btn-primary px-5 fw-bold">Update Stat</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Image Preview logic
    document.getElementById('imageInput').onchange = evt => {
        const [file] = document.getElementById('imageInput').files
        if (file) {
            document.getElementById('preview').src = URL.createObjectURL(file)
        }
    }
</script>
@endpush
@endsection
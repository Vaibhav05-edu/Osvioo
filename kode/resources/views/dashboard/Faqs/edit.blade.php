@extends('dashboard.layout.main')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-header bg-white py-3 border-0">
                    <h4 class="fw-bold mb-0">Edit FAQ</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('osivoo-admin.faq.update', $faq->id) }}" method="POST">
                        @csrf
                        @method('PUT') <!-- Laravel mein update ke liye PUT method zaroori hai -->

                        <!-- Basic Info -->
                        <div class="row mb-4">
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold">Question</label>
                                <input type="text" name="question" class="form-control" value="{{ $faq->question }}" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold">Answer</label>
                                <textarea name="answer" class="form-control" rows="4" required>{{ $faq->answer }}</textarea>
                            </div>
                        </div>

                        <!-- Social Links -->
                        <h6 class="text-uppercase text-muted fw-bold small mb-3">Social Links & Resources</h6>
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label"><i class="fab fa-facebook me-2"></i> Facebook URL</label>
                                <input type="url" name="fb_link" class="form-control" value="{{ $faq->fb_link }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label"><i class="fa-brands fa-x-twitter me-2"></i> X (Twitter) URL</label>
                                <input type="url" name="x_link" class="form-control" value="{{ $faq->x_link }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label"><i class="fab fa-linkedin me-2"></i> LinkedIn URL</label>
                                <input type="url" name="linkedin_link" class="form-control" value="{{ $faq->linkedin_link }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label"><i class="fas fa-link me-2"></i> Website/Custom Link</label>
                                <input type="url" name="website_link" class="form-control" value="{{ $faq->website_link }}">
                            </div>
                        </div>

                        <!-- Settings -->
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Display Order</label>
                                <input type="number" name="order" class="form-control" value="{{ $faq->order }}">
                            </div>
                            <div class="col-md-6 mb-3 d-flex align-items-end">
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input" type="checkbox" name="is_active" id="isActive" value="1" {{ $faq->is_active ? 'checked' : '' }}>
                                    <label class="form-check-label fw-bold" for="isActive">Set as Active</label>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('osivoo-admin.faq.index') }}" class="btn btn-light px-4">Cancel</a>
                            <button type="submit" class="btn btn-primary px-4">Update FAQ</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
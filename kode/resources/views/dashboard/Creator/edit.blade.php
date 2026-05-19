@extends('dashboard.layout.main')
@section('content')
<div class="container-fluid py-4">
    <div class="card border-0 shadow-sm p-4 mx-auto" style="max-width: 600px; border-radius: 15px;">
        <h4 class="fw-bold mb-4">Edit Creator</h4>
        <form action="{{ route('osvioo-admin.creator.update', $creator->id) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            
            <div class="text-center mb-4">
                <img src="{{ asset('storage/' . $creator->profile_pic) }}" class="rounded-circle border" width="100" height="100" style="object-fit: cover;">
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Username</label>
                <input type="text" name="username" class="form-control" value="{{ $creator->username }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Followers</label>
                <input type="text" name="followers" class="form-control" value="{{ $creator->followers }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Update Profile Picture</label>
                <input type="file" name="profile_pic" class="form-control">
                <small class="text-muted">Leave empty to keep current picture</small>
            </div>
            <div class="row mb-4">
                <div class="col-6">
                    <label class="form-label fw-bold">Order</label>
                    <input type="number" name="order" class="form-control" value="{{ $creator->order }}">
                </div>
                <div class="col-6 d-flex align-items-end">
                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" name="status" value="1" {{ $creator->status ? 'checked' : '' }} id="sw">
                        <label class="form-check-label fw-bold" for="sw">Active</label>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">Update Creator</button>
        </form>
    </div>
</div>
@endsection
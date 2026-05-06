@extends('dashboard.layout.main')
@section('content')
<div class="container-fluid py-4">
    <div class="card border-0 shadow-sm p-4 mx-auto" style="max-width: 600px; border-radius: 15px;">
        <h4 class="fw-bold mb-4">Add Instagram Creator</h4>
        <form action="{{ route('socialyt-admin.creator.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-bold">Instagram Username</label>
                <input type="text" name="username" class="form-control" placeholder="@dobbytrader" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Followers Count</label>
                <input type="text" name="followers" class="form-control" placeholder="62.9K" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Profile Picture</label>
                <input type="file" name="profile_pic" class="form-control" required>
            </div>
            <div class="row mb-4">
                <div class="col-6">
                    <label class="form-label fw-bold">Order</label>
                    <input type="number" name="order" class="form-control" value="0">
                </div>
                <div class="col-6 d-flex align-items-end">
                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" name="status" value="1" checked id="sw">
                        <label class="form-check-label fw-bold" for="sw">Active</label>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-dark w-100 py-2 fw-bold">Save Creator</button>
        </form>
    </div>
</div>
@endsection
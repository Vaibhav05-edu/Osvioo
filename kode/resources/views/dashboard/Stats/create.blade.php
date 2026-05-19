@extends('dashboard.layout.main')
@section('content')
<div class="container-fluid py-4">
    <div class="card border-0 shadow-sm p-4 mx-auto" style="max-width: 800px;">
        <h4 class="fw-bold mb-4">Add New Feature Stat</h4>
        <form action="{{ route('osvioo-admin.stats.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" name="title" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Description (Long Text)</label>
                <textarea name="description" class="form-control" rows="6" required></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Image</label>
                <input type="file" name="image" class="form-control" required>
            </div>
            <div class="row">
                <div class="col-6 mb-3">
                    <label class="form-label">Order</label>
                    <input type="number" name="order" class="form-control" value="0">
                </div>
                <div class="col-6 d-flex align-items-end">
                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" name="status" value="1" checked>
                        <label class="form-check-label">Active</label>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-dark w-100 py-2">Save Stat</button>
        </form>
    </div>
</div>
@endsection
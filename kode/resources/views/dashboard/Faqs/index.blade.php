@extends('dashboard.layout.main')

@push('styles')
<style>
    .table-container {
        background: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    .social-icon-preview i {
        font-size: 1.1rem;
        margin-right: 8px;
        color: #333;
    }
    .btn-add {
        background-color: #000;
        color: #fff;
        border-radius: 5px;
        padding: 8px 20px;
        text-decoration: none;
    }
    .btn-add:hover {
        background-color: #333;
        color: #fff;
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Frequently Asked Questions</h2>
        <!-- Add FAQ Button -->
        <a href="{{ route('osvioo-admin.faq.create') }}" class="btn-add">
            <i class="fas fa-plus me-2"></i> Add New FAQ
        </a>
    </div>

    <div class="table-container">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px;">Order</th>
                        <th>Question & Answer</th>
                        <th>Social Links</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($faqs as $faq)
                    <tr>
                        <td class="fw-bold text-muted">#{{ $faq->order }}</td>
                        <td>
                            <div class="fw-bold text-dark">{{ $faq->question }}</div>
                            <small class="text-muted text-truncate d-inline-block" style="max-width: 300px;">
                                {{ $faq->answer }}
                            </small>
                        </td>
                        <td>
                            <div class="social-icon-preview">
                                @if($faq->fb_link) <i class="fab fa-facebook" title="Facebook"></i> @endif
                                @if($faq->x_link) <i class="fa-brands fa-x-twitter" title="X (Twitter)"></i> @endif
                                @if($faq->linkedin_link) <i class="fab fa-linkedin" title="LinkedIn"></i> @endif
                                @if($faq->website_link) <i class="fas fa-link" title="Website"></i> @endif
                            </div>
                        </td>
                        <td>
                            @if($faq->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <div class="d-flex justify-content-end gap-2">
                                <!-- Edit Button -->
                                <a href="{{ route('osvioo-admin.faq.edit', $faq->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                
                                <!-- Delete Button (with Form for Security) -->
                                <form action="{{ route('osvioo-admin.faq.destroy', $faq->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">No FAQs found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Links -->
        <div class="mt-4">
            {{ $faqs->links() }}
        </div>
    </div>
</div>
@endsection
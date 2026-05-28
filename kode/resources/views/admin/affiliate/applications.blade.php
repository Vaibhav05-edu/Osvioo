@extends('admin.layouts.master')
@section('content')

<div class="d-flex align-items-center justify-content-between mb-4">
    <h4 class="fw-bold mb-0">{{ translate('Affiliate Applications') }}</h4>
    <div class="d-flex gap-2">
        <a href="?status=1" class="btn btn-sm {{ $status == 1 ? 'btn-warning' : 'btn-outline-warning' }}">
            <i class="las la-clock me-1"></i>{{ translate('Pending') }}
        </a>
        <a href="?status=2" class="btn btn-sm {{ $status == 2 ? 'btn-success' : 'btn-outline-success' }}">
            <i class="las la-check me-1"></i>{{ translate('Approved') }}
        </a>
        <a href="?status=3" class="btn btn-sm {{ $status == 3 ? 'btn-danger' : 'btn-outline-danger' }}">
            <i class="las la-times me-1"></i>{{ translate('Rejected') }}
        </a>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>{{ translate('User') }}</th>
                        <th>{{ translate('Email') }}</th>
                        <th>{{ translate('How to Promote') }}</th>
                        <th>{{ translate('Website') }}</th>
                        <th>{{ translate('Applied At') }}</th>
                        <th>{{ translate('Status') }}</th>
                        @if($status == 1)
                        <th>{{ translate('Action') }}</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $i => $user)
                    @php $appData = json_decode($user->affiliate_application, true); @endphp
                    <tr>
                        <td>{{ $users->firstItem() + $i }}</td>
                        <td>
                            <a href="{{ route('admin.user.show', $user->id) }}" class="fw-semibold text-decoration-none">
                                {{ $user->name }}
                            </a>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td style="max-width: 250px;">
                            <span class="text-truncate d-block" style="max-width:240px;" title="{{ $appData['how_to_promote'] ?? '-' }}">
                                {{ $appData['how_to_promote'] ?? '-' }}
                            </span>
                        </td>
                        <td>
                            @if(!empty($appData['website_url']))
                                <a href="{{ $appData['website_url'] }}" target="_blank">{{ $appData['website_url'] }}</a>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>{{ $user->updated_at->format('d M Y') }}</td>
                        <td>
                            @if($user->affiliate_status == 1)
                                <span class="badge bg-warning text-dark">{{ translate('Pending') }}</span>
                            @elseif($user->affiliate_status == 2)
                                <span class="badge bg-success">{{ translate('Approved') }}</span>
                            @elseif($user->affiliate_status == 3)
                                <span class="badge bg-danger">{{ translate('Rejected') }}</span>
                            @endif
                        </td>
                        @if($status == 1)
                        <td>
                            <form action="{{ route('admin.affiliate.approve', $user->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button class="btn btn-sm btn-success py-0 px-2" type="submit">
                                    <i class="las la-check"></i> {{ translate('Approve') }}
                                </button>
                            </form>
                            <form action="{{ route('admin.affiliate.reject', $user->id) }}" method="POST" class="d-inline ms-1">
                                @csrf
                                <button class="btn btn-sm btn-danger py-0 px-2" type="submit">
                                    <i class="las la-times"></i> {{ translate('Reject') }}
                                </button>
                            </form>
                        </td>
                        @endif
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted">
                            {{ translate('No affiliate applications found.') }}
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-3">
    {{ $users->links() }}
</div>

@endsection

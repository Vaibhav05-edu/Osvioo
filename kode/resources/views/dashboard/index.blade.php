@extends('dashboard.layout.main')

@push('styles')
<style>
    /* ─── Stats Grid ─────────────────────────────────────── */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 24px;
    }
    @media (max-width: 1100px) { .stats-grid { grid-template-columns: repeat(2,1fr); } }
    @media (max-width: 600px)  { .stats-grid { grid-template-columns: 1fr; } }

    .stat-card {
        background: #fff;
        border: 1px solid var(--border, #e3e8f0);
        border-radius: 14px;
        padding: 20px;
        display: flex;
        align-items: flex-start;
        gap: 14px;
        transition: box-shadow .2s, transform .2s;
    }
    .stat-card:hover {
        box-shadow: 0 6px 24px rgba(0,0,0,.08);
        transform: translateY(-2px);
    }
    .stat-icon {
        width: 46px; height: 46px;
        border-radius: 12px;
        display: grid; place-items: center;
        font-size: 18px;
        flex-shrink: 0;
    }
    .stat-body { display: flex; flex-direction: column; gap: 3px; }
    .stat-label { font-size: 12.5px; color: var(--muted); font-weight: 500; }
    .stat-value { font-size: 26px; font-weight: 700; color: var(--text); letter-spacing: -.5px; line-height: 1; }
    .stat-change {
        font-size: 11.5px; font-weight: 600;
        display: flex; align-items: center; gap: 4px;
    }
    .stat-change.up  { color: #10b981; }
    .stat-change.down{ color: #ef4444; }

    .dash-grid {
        display: grid;
        grid-template-columns: 1fr 380px;
        gap: 20px;
        align-items: start;
    }
    @media (max-width: 1024px) { .dash-grid { grid-template-columns: 1fr; } }

    .data-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }
    .data-table th {
        text-align: left;
        padding: 12px 10px;
        font-size: 11.5px;
        font-weight: 600;
        color: var(--muted);
        letter-spacing: .5px;
        text-transform: uppercase;
        border-bottom: 1.5px solid var(--border, #e3e8f0);
    }
    .data-table td {
        padding: 12px 10px;
        color: var(--text);
        border-bottom: 1px solid var(--border, #e3e8f0);
        vertical-align: middle;
    }
    .data-table tr:last-child td { border-bottom: none; }
    .data-table tr:hover td { background: #f8faff; }

    .case-title { font-weight: 600; color: #1e293b; }
    .tag {
        font-size: 11px;
        font-weight: 600;
        padding: 3px 9px;
        border-radius: 20px;
        background: #f1f5f9;
        color: #475569;
    }

    .activity-list { display: flex; flex-direction: column; gap: 12px; }
    .activity-item {
        display: flex;
        gap: 12px;
        padding: 12px;
        background: #fff;
        border: 1px solid #e3e8f0;
        border-radius: 10px;
    }
    .activity-icon {
        width: 36px; height: 36px;
        border-radius: 8px;
        background: #f1f5f9;
        display: grid; place-items: center;
        flex-shrink: 0;
        color: #64748b;
    }
    .activity-info { flex: 1; }
    .activity-title { font-size: 13px; font-weight: 600; color: #1e293b; margin-bottom: 2px; }
    .activity-meta { font-size: 11.5px; color: #94a3b8; }
</style>
@endpush

@section('content')

{{-- ── DYNAMIC STAT CARDS ── --}}
<div class="stats-grid">
    @foreach($stats as $s)
    <div class="stat-card shadow-sm">
        <div class="stat-icon" style="background: {{ $s['color'] }}18; color: {{ $s['color'] }};">
            <i class="fa-solid {{ $s['icon'] }}"></i>
        </div>
        <div class="stat-body">
            <span class="stat-label">{{ $s['label'] }}</span>
            <span class="stat-value">{{ number_format($s['value']) }}</span>
            <span class="stat-change {{ $s['up'] ? 'up' : 'down' }}">
                <i class="fa-solid fa-arrow-{{ $s['up'] ? 'up' : 'down' }}"></i>
                {{ $s['change'] }} <small class="text-muted fw-normal" style="font-size: 9px;">vs last week</small>
            </span>
        </div>
    </div>
    @endforeach
</div>

<div class="dash-grid">

    {{-- Recent Creators (Replacing Recent Cases) --}}
    <div class="card p-3 border-0 shadow-sm rounded-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h5 class="fw-bold mb-0">Recent Creators</h5>
                <p class="text-muted small mb-0">Latest onboarded influencers</p>
            </div>
            <a href="{{ route('osivoo-admin.creator.index') }}" class="btn btn-light btn-sm fw-bold">View All</a>
        </div>

        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Creator</th>
                        <th>Followers</th>
                        <th>Platform</th>
                        <th>Joined Date</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($latestCreators as $creator)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="{{ asset('storage/' . $creator->profile_pic) }}"
                                    class="rounded-circle me-2"
                                    width="30" height="30"
                                    style="object-fit: cover">
                                <span class="case-title">{{ $creator->username }}</span>
                            </div>
                        </td>
                        <td><span class="fw-bold">{{ $creator->followers }}</span></td>
                        <td><span class="tag">Instagram</span></td>
                        <td class="text-muted">{{ $creator->created_at->format('d M Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">
                            No Creators Added Yet 🚫
                        </td>
                    </tr>
                @endforelse
            </tbody>
            </table>
        </div>
    </div>

    {{-- Latest Stories & FAQs Sidebar --}}
    <div style="display:flex; flex-direction:column; gap:20px;">

        {{-- Recent Stories Activity --}}
        <div class="card p-3 border-0 shadow-sm rounded-4">
            <h6 class="fw-bold mb-3">Latest Stories</h6>
            <div class="activity-list">
            @forelse($latestStories as $story)
                <div class="activity-item">
                    <div class="activity-icon">
                        <i class="fa-solid fa-bolt"></i>
                    </div>
                    <div class="activity-info">
                        <div class="activity-title">{{ Str::limit($story->title, 25) }}</div>
                        <div class="activity-meta">
                            <i class="fa-regular fa-clock me-1"></i> {{ $story->created_at->diffForHumans() }}
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-4 text-muted">
                    <i class="fa-solid fa-clock-rotate-left fa-2x mb-2"></i>
                    <p class="mb-0">No recent activity</p>
                    <small>Stories will appear here once added</small>
                </div>
            @endforelse
            </div>
        </div>

        {{-- Recent FAQs --}}
        <div class="card p-3 border-0 shadow-sm rounded-4">
            <h6 class="fw-bold mb-3">Recent FAQs Added</h6>
            <div class="activity-list">
            @forelse($latestFaqs as $faq)
                <div class="activity-item" style="border-left: 3px solid #8b5cf6;">
                    <div class="activity-info">
                        <div class="activity-title" style="font-size: 12px;">
                            {{ Str::limit($faq->question, 40) }}
                        </div>
                        <div class="activity-meta">Category: General</div>
                    </div>
                </div>
            @empty
                <div class="text-center py-4 text-muted">
                    <i class="fa-solid fa-circle-question fa-2x mb-2"></i>
                    <p class="mb-0">No FAQs available</p>
                    <small>Add FAQs to display here</small>
                </div>
            @endforelse
            </div>
        </div>

    </div>
</div>

@endsection
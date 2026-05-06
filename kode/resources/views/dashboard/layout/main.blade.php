@include('dashboard.layout.header')

    {{-- ── Main Wrapper starts after Header ── --}}
    <main class="p-4">

        {{-- 1. Flash Messages (Success/Error) --}}
        <div class="alerts-container mb-3">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            {{-- Add other alerts (error/warning) here --}}
        </div>

        {{-- 2. Page Header Bar --}}
        <div class="page-header d-flex justify-content-between align-items-center mb-4">
            <div class="page-header-left">
                <h1 class="h3 fw-bold m-0">@yield('page-title', 'Dashboard')</h1>
                @hasSection('page-subtitle')
                    <p class="text-muted small mb-0">@yield('page-subtitle')</p>
                @endif
            </div>
            <div class="page-header-right">
                @yield('page-actions')
            </div>
        </div>

        {{-- 3. MAIN CONTENT (Yahan index ka content fit hoga) --}}
        <div class="content-body">
            @yield('content')
        </div>

    </main>

@include('dashboard.layout.footer')
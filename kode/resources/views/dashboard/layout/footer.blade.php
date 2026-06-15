<footer class="app-footer">
            <div class="footer-left">
                <span>&copy; {{ date('Y') }} {{ config('app.name', 'LegalSuite') }}. All rights reserved.</span>
                <span class="footer-sep">•</span>
                <span class="footer-version">v1.0.0</span>
            </div>
            <div class="footer-right">
                <a href="{{ route('page', 'privacy-policy') }}">Privacy Policy</a>
                <a href="{{ route('page', 'terms-and-conditions') }}">Terms</a>
                <a href="{{ route('home') }}">Help</a>
            </div>
        </footer>

    </div><!-- /.main-wrapper -->

</div><!-- /.app-shell -->


{{-- ══════════════ SCRIPTS ══════════════ --}}
<script>
    const sidebar     = document.getElementById('sidebar');
    const toggleBtn   = document.getElementById('toggleBtn');
    const toggleIcon  = document.getElementById('toggleIcon');

    function setSidebarState(collapsed) {
        if (collapsed) {
            sidebar.classList.add('collapsed');
            toggleIcon.classList.replace('fa-chevron-left', 'fa-chevron-right');
        } else {
            sidebar.classList.remove('collapsed');
            toggleIcon.classList.replace('fa-chevron-right', 'fa-chevron-left');
        }
        localStorage.setItem('sidebar_collapsed', collapsed ? '1' : '0');
    }

    // Restore saved state
    if (localStorage.getItem('sidebar_collapsed') === '1') setSidebarState(true);

    document.getElementById('sidebarToggle').addEventListener('click', () => {
        setSidebarState(!sidebar.classList.contains('collapsed'));
    });

    // ── Mobile sidebar ────────────────────────────────────────
    function openSidebar()  { sidebar.classList.add('open'); }
    function closeSidebar() { sidebar.classList.remove('open'); }

    // Show mobile toggle on small screens
    if (window.innerWidth < 768) {
        document.getElementById('mobileToggle').style.display = 'grid';
    }
    window.addEventListener('resize', () => {
        document.getElementById('mobileToggle').style.display =
            window.innerWidth < 768 ? 'grid' : 'none';
    });

    // ── Active nav highlight (fallback via JS) ────────────────
    document.querySelectorAll('.nav-item').forEach(link => {
        if (link.href && window.location.pathname.startsWith(new URL(link.href).pathname) && link.href !== window.location.origin + '/') {
            link.classList.add('active');
        }
    });

    // ── Flash message auto-dismiss ────────────────────────────
    setTimeout(() => {
        document.querySelectorAll('.alert-dismissible').forEach(el => el.remove());
    }, 5000);
</script>

{{-- Page-specific scripts --}}
@stack('scripts')

</body>
</html>
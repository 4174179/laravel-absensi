<aside class="sidebar">
    <div class="sidebar-brand">
        <i class="fas fa-fingerprint"></i>
        <span>ABSENSI SISWA</span>
    </div>

    <div class="sidebar-user">
        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random" alt="User">
        <div class="user-info">
            <span class="user-name">{{ auth()->user()->nama_lengkap }}</span>
            <span class="user-role">{{ ucfirst(auth()->user()->role) }}</span>
        </div>
    </div>

    <nav class="sidebar-nav">
        @if(Auth::user()->role == 'admin')
        <a href="{{ route('dashboard') }}" class="{{ request()->Is('admin/dashboard*') ? 'active' : '' }}">
            <i class="fas fa-th-large"></i> <span>Dashboard</span>
        </a>
        <p class="nav-label">MASTER DATA</p>
        <a href="{{ route('admin.periode.index') }}"
            class="{{ request()->is('admin/ganti-periode*') ? 'active' : '' }}">
            <i class="fas fa-calendar-alt"></i> <span>Tahun Ajaran</span>
        </a>
        <a href="{{ route('guru_manage') }}" class="{{ request()->is('admin/guru*') ? 'active' : '' }}">
            <i class="fas fa-user-tie"></i> <span>Data Guru</span>
        </a>
        <a href="{{ route('kelas_manage') }}" class="{{ request()->is('admin/kelas*') ? 'active' : '' }}">
            <i class="fas fa-chalkboard"></i> <span>Data Kelas</span>
        </a>
        <a href="{{ route('siswa_manage') }}" class="{{ request()->is('admin/siswa*') ? 'active' : '' }}">
            <i class="fas fa-users"></i> <span>Data Siswa</span>
        </a>
        <a href="{{ route('admin.libur.index') }}" class="{{ request()->is('admin/hari-libur*') ? 'active' : '' }}">
            <i class="fas fa-calendar-times"></i> <span>Hari Libur Sekolah</span>
        </a>
        <a href="{{ route('admin_sesi') }}" class="{{ request()->is('admin/sesi*') ? 'active' : '' }}">
            <i class="fas fa-clock"></i> <span>Sesi Absensi</span>
        </a>

        <p class="nav-label">LAPORAN</p>
        <a href="{{ route('admin.rekap') }}" class="{{ request()->is('admin/rekap*') ? 'active' : '' }}">
            <i class="fas fa-file-invoice"></i> <span>Rekap Absensi</span>
        </a>

        @endif

        <p class="nav-label">SISTEM</p>

        <form method="POST" action="{{ route('logout') }}" id="logout-form" style="display: none;">
            @csrf
        </form>

        <!-- Cari bagian ini di sidepanel lo -->
        <a href="#" onclick="event.preventDefault(); confirmLogout();" class="btn-logout menu-link logout-link">
            <i class="fas fa-sign-out-alt"></i>
            <span>Logout</span>
        </a>
    </nav>
</aside>
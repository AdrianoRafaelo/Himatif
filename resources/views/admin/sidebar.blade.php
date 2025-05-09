<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/admin') }}">
        <div class="sidebar-brand-icon">
            <i class="fas fa-graduation-cap"></i>
        </div>
        <div class="sidebar-brand-text mx-3">HIMATIF</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ url('/admin') }}">
            <i class="fas fa-fw fa-home"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Admin and Bendahara Features -->
    <!-- Manajemen Section (Admin, Bendahara, Kaprodi) -->
@if(session('user')['role'] === 'admin' || session('user')['role'] === 'bendahara' || session('user')['role'] === 'kaprodi')
<!-- Heading -->
<div class="sidebar-heading text-uppercase">
    <span class="small font-weight-bold">Manajemen</span>
</div>

<!-- Role Management (Admin Only) -->
@if(session('user')['role'] === 'admin')
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.role.index') }}">
            <i class="fas fa-fw fa-user-tag"></i>
            <span>Role Management</span>
        </a>
    </li>
@endif

<!-- Program Kerja (Admin: View/Create, Bendahara/Kaprodi: View) -->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseProker"
        aria-expanded="true" aria-controls="collapseProker">
        <i class="fas fa-fw fa-project-diagram"></i>
        <span>Program Kerja</span>
    </a>
    <div id="collapseProker" class="collapse" aria-labelledby="headingProker" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded shadow-sm">
            <a class="collapse-item" href="{{ route('proker.index') }}">
                <i class="fas fa-clipboard-list fa-sm mr-2 text-primary"></i>Daftar Program
            </a>
            @if(session('user')['role'] === 'admin')
                <a class="collapse-item" href="{{ route('proker.create') }}">
                    <i class="fas fa-plus-circle fa-sm mr-2 text-primary"></i>Tambah Program
                </a>
            @endif
        </div>
    </div>
</li>

<!-- Struktur Organisasi BPH (Admin Only) -->
@if(session('user')['role'] === 'admin')
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.bph.index') }}">
            <i class="fas fa-fw fa-sitemap"></i>
            <span>Struktur Organisasi BPH</span>
        </a>
    </li>
@endif

<!-- Uang Kas (Bendahara Only) -->
@if(session('user')['role'] === 'bendahara')
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.kas.index') }}">
            <i class="fas fa-fw fa-money-bill-wave"></i>
            <span>Uang Kas</span>
        </a>
    </li>
@endif

<!-- Laporan Keuangan (Admin and Bendahara) -->
@if(session('user')['role'] === 'admin' || session('user')['role'] === 'bendahara')
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.keuangan.index') }}">
            <i class="fas fa-fw fa-file-invoice-dollar"></i>
            <span>Laporan Keuangan</span>
        </a>
    </li>
@endif
@endif
    <!-- Proposal Menu (Admin, Kaprodi, Bendahara) -->
    @if(session('user')['role'] === 'admin' || session('user')['role'] === 'kaprodi' || session('user')['role'] === 'bendahara')
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseProposal"
                aria-expanded="true" aria-controls="collapseProposal">
                <i class="fas fa-fw fa-file-alt"></i>
                <span>Proposal</span>
            </a>
            <div id="collapseProposal" class="collapse" aria-labelledby="headingProposal" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded shadow-sm">
                    @if(session('user')['role'] === 'admin')
                        <a class="collapse-item" href="{{ route('admin.proposals.create') }}">
                            <i class="fas fa-paper-plane fa-sm mr-2 text-primary"></i>Kirim Proposal
                        </a>
                        <a class="collapse-item" href="{{ route('admin.proposals.index') }}">
                            <i class="fas fa-list fa-sm mr-2 text-primary"></i>Daftar Proposal
                        </a>
                    @elseif(session('user')['role'] === 'kaprodi' || session('user')['role'] === 'bendahara')
                        <a class="collapse-item" href="{{ route('admin.kaprodi.proposals.index') }}">
                            <i class="fas fa-list fa-sm mr-2 text-primary"></i>Daftar Proposal
                        </a>
                    @endif
                </div>
            </div>
        </li>
    @endif

<!-- Admin-Only Features (News, Galeri, Visi Misi) -->
@if(session('user')['role'] === 'admin')
<!-- News -->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseNews"
        aria-expanded="true" aria-controls="collapseNews">
        <i class="fas fa-fw fa-newspaper"></i>
        <span>News</span>
    </a>
    <div id="collapseNews" class="collapse" aria-labelledby="headingNews" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded shadow-sm">
            <a class="collapse-item" href="{{ route('admin.news.index') }}">
                <i class="fas fa-eye fa-sm mr-2 text-primary"></i>Lihat Berita
            </a>
            <a class="collapse-item" href="{{ route('news.create') }}">
                <i class="fas fa-plus-circle fa-sm mr-2 text-primary"></i>Tambah Berita
            </a>
        </div>
    </div>
</li>


<!-- Galeri -->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseGaleri"
        aria-expanded="true" aria-controls="collapseGaleri">
        <i class="fas fa-fw fa-images"></i>
        <span>Galeri</span>
    </a>
    <div id="collapseGaleri" class="collapse" aria-labelledby="headingGaleri" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded shadow-sm">
            <a class="collapse-item" href="{{ route('admin.galeri.index') }}">
                <i class="fas fa-eye fa-sm mr-2 text-primary"></i>Lihat Galeri
            </a>
            <a class="collapse-item" href="{{ route('admin.galeri.create') }}">
                <i class="fas fa-plus-circle fa-sm mr-2 text-primary"></i>Buat Galeri
            </a>
        </div>
    </div>
</li>

<!-- Visi Misi -->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseVisiMisi"
        aria-expanded="true" aria-controls="collapseVisiMisi">
        <i class="fas fa-fw fa-bullseye"></i>
        <span>Visi Misi</span>
    </a>
    <div id="collapseVisiMisi" class="collapse" aria-labelledby="headingVisiMisi" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded shadow-sm">
            <a class="collapse-item" href="{{ route('admin.tentang.index') }}">
                <i class="fas fa-eye fa-sm mr-2 text-primary"></i>Lihat Visi & Misi
            </a>
            <a class="collapse-item" href="{{ route('admin.tentang.create') }}">
                <i class="fas fa-plus-circle fa-sm mr-2 text-primary"></i>Buat Visi & Misi
            </a>
        </div>
    </div>
</li>
@endif


    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler -->
    <div class="text-center d-none d-md-inline mt-3">
        <button class="rounded-circle border-0 bg-light" id="sidebarToggle">
            <i class="fas fa-angle-left text-primary"></i>
        </button>
    </div>

</ul>
<!-- End of Sidebar -->
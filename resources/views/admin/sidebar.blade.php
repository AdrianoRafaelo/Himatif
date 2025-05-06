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

    

    @if(session('user')['role'] === 'admin' || session('user')['role'] === 'bendahara')
        <!-- Heading -->
        <div class="sidebar-heading text-uppercase">
            <span class="small font-weight-bold">Manajemen</span>
        </div>

       

        <!-- Nav Item - Role -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.role.index') }}">
                <i class="fas fa-fw fa-user-tag"></i>
                <span>Role Management</span>
            </a>
        </li>

        <!-- Nav Item - Program Kerja Menu -->
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
                    <a class="collapse-item" href="{{ route('proker.create') }}">
                        <i class="fas fa-plus-circle fa-sm mr-2 text-primary"></i>Tambah Program
                    </a>
                </div>
            </div>
        </li>

        <!-- Nav Item - Struktur Organisasi BPH -->
        @if(session('user')['role'] === 'admin')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.bph.index') }}">
                    <i class="fas fa-fw fa-sitemap"></i>
                    <span>Struktur Organisasi BPH</span>
                </a>
            </li>
        @endif

        <!-- Nav Item - Kas -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.kas.index') }}">
                <i class="fas fa-fw fa-money-bill-wave"></i>
                <span>Keuangan</span>
            </a>
        </li>
    @endif
    
   

    @if(session('user')['role'] === 'admin' || session('user')['role'] === 'kaprodi')
    <!-- Nav Item - Proposal Menu -->
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
                @elseif(session('user')['role'] === 'kaprodi')
                    <a class="collapse-item" href="{{ route('admin.kaprodi.proposals.index') }}">
                        <i class="fas fa-list fa-sm mr-2 text-primary"></i>Daftar Proposal
                    </a>
                @endif

            </div>
        </div>
    
           </a>
    </li>
    @if(session('user')['role'] === 'admin')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.news.index') }}">
                    <i class="fas fa-fw fa-sitemap"></i>
                    <span>News</span>
                </a>
            </li>
        @endif

        @if(session('user')['role'] === 'admin')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.tentang.index') }}">
                    <i class="fas fa-fw fa-sitemap"></i>
                    <span>Visi Misi</span>
                </a>
            </li>
        @endif


        @endif


    @if(session('user')['role'] === 'kaprodi')
        <!-- Nav Item - Program Kerja Menu for Kaprodi -->
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
                    <a class="collapse-item" href="{{ route('proker.create') }}">
                        <i class="fas fa-plus-circle fa-sm mr-2 text-primary"></i>Tambah Program
                    </a>
                </div>
            </div>
        </li>

        

        <!-- Nav Item - Kas for Kaprodi -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.kas.index') }}">
                <i class="fas fa-fw fa-money-bill-wave"></i>
                <span>Keuangan</span>
            </a>
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
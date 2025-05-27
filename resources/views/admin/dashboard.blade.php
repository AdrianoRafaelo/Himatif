<style>
    .gradient-primary {
        background: linear-gradient(135deg, #007bff 0%, #00c6ff 100%);
        transition: all 0.3s ease;
    }
    .gradient-success {
        background: linear-gradient(135deg, #28a745 0%, #34d058 100%);
        transition: all 0.3s ease;
    }
    .gradient-info {
        background: linear-gradient(135deg, #17a2b8 0%, #1fc8db 100%);
        transition: all 0.3s ease;
    }
    .gradient-warning {
        background: linear-gradient(135deg, #ffca2c 0%, #f7e200 100%);
        transition: all 0.3s ease;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
    }
    .fade-in {
        animation: fadeIn 1s ease-in-out;
    }
    @keyframes fadeIn {
        0% { opacity: 0; }
        100% { opacity: 1; }
    }
    .news-thumbnail {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 5px;
    }
</style>

@extends('admin.layouts')

@section('title', 'Dashboard HIMATIF')

@section('content')
    <!-- Notifikasi sukses -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mx-4 mt-4" role="alert">
            <strong>Sukses!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4 px-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard HIMATIF</h1>
    </div>

    <!-- Cards -->
    <div class="row px-4 fade-in">
        <!-- Total Events -->
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="{{ route('admin.event.index') }}" class="text-decoration-none">
                <div class="card gradient-primary text-white shadow h-100 py-2">
                    <div class="card-body d-flex align-items-center">
                        <div class="me-3">
                            <i class="fas fa-calendar fa-2x"></i>
                        </div>
                        <div>
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Total Events</div>
                            <div class="h5 mb-0 font-weight-bold">{{ \App\Models\Event::count() }}</div>
                            <small class="text-light">Terakhir diperbarui: {{ now()->format('d M Y') }}</small>
                        </div>
                    </div>
                </div>
            </a>
        </div>
<!-- Approved Proposals -->
<div class="col-xl-3 col-md-6 mb-4">
    @if(session('user')['role'] === 'kaprodi')
        <div class="card gradient-success text-white shadow h-100 py-2">
            <div class="card-body d-flex align-items-center">
                <div class="me-3">
                    <i class="fas fa-check-circle fa-2x"></i>
                </div>
                <div>
                    <div class="text-xs font-weight-bold text-uppercase mb-1">Approved Proposals</div>
                    <div class="h5 mb-0 font-weight-bold">{{ \App\Models\Proposal::where('status', 'approved')->count() }}</div>
                    <small class="text-light">Terakhir diperbarui: {{ now()->format('d M Y') }}</small>
                </div>
            </div>
        </div>
    @else
        <a href="{{ route('admin.proposals.index') }}" class="text-decoration-none">
            <div class="card gradient-success text-white shadow h-100 py-2">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3">
                        <i class="fas fa-check-circle fa-2x"></i>
                    </div>
                    <div>
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Approved Proposals</div>
                        <div class="h5 mb-0 font-weight-bold">{{ \App\Models\Proposal::where('status', 'approved')->count() }}</div>
                        <small class="text-light">Terakhir diperbarui: {{ now()->format('d M Y') }}</small>
                    </div>
                </div>
            </div>
        </a>
    @endif
</div>

<!-- Pending Proposals -->
<div class="col-xl-3 col-md-6 mb-4">
    @if(session('user')['role'] === 'kaprodi')
        <div class="card gradient-info text-white shadow h-100 py-2">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <i class="fas fa-hourglass-half fa-2x"></i>
                    </div>
                    <div>
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Pending Proposals</div>
                        <div class="d-flex align-items-center">
                            <div class="h5 mb-0 me-3 font-weight-bold">{{ \App\Models\Proposal::where('status', 'pending')->count() }}</div>
                            <div class="progress progress-sm w-100">
                                <div class="progress-bar bg-light" role="progressbar" style="width: {{ (\App\Models\Proposal::count() > 0 ? (\App\Models\Proposal::where('status', 'pending')->count() / \App\Models\Proposal::count() * 100) : 0) }}%"
                                    aria-valuenow="{{ \App\Models\Proposal::where('status', 'pending')->count() }}"
                                    aria-valuemin="0"
                                    aria-valuemax="{{ \App\Models\Proposal::count() }}"></div>
                            </div>
                        </div>
                        <small class="text-light">Dari total {{ \App\Models\Proposal::count() }} proposal</small>
                    </div>
                </div>
            </div>
        </div>
    @else
        <a href="{{ route('admin.proposals.index') }}" class="text-decoration-none">
            <div class="card gradient-info text-white shadow h-100 py-2">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <i class="fas fa-hourglass-half fa-2x"></i>
                        </div>
                        <div>
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Pending Proposals</div>
                            <div class="d-flex align-items-center">
                                <div class="h5 mb-0 me-3 font-weight-bold">{{ \App\Models\Proposal::where('status', 'pending')->count() }}</div>
                                <div class="progress progress-sm w-100">
                                    <div class="progress-bar bg-light" role="progressbar" style="width: {{ (\App\Models\Proposal::count() > 0 ? (\App\Models\Proposal::where('status', 'pending')->count() / \App\Models\Proposal::count() * 100) : 0) }}%"
                                        aria-valuenow="{{ \App\Models\Proposal::where('status', 'pending')->count() }}"
                                        aria-valuemin="0"
                                        aria-valuemax="{{ \App\Models\Proposal::count() }}"></div>
                                </div>
                            </div>
                            <small class="text-light">Dari total {{ \App\Models\Proposal::count() }} proposal</small>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    @endif
</div>        <!-- Total Program Kerja (untuk kaprodi) / News Articles (untuk lainnya) -->
        @if(session('user')['role'] !== 'kaprodi')
            <div class="col-xl-3 col-md-6 mb-4">
                <a href="{{ route('admin.news.index') }}" class="text-decoration-none">
                    <div class="card gradient-warning text-white shadow h-100 py-2">
                        <div class="card-body d-flex align-items-center">
                            <div class="me-3">
                                <i class="fas fa-newspaper fa-2x"></i>
                            </div>
                            <div>
                                <div class="text-xs font-weight-bold text-uppercase mb-1">News Articles</div>
                                <div class="h5 mb-0 font-weight-bold">{{ \App\Models\News::count() }}</div>
                                <small class="text-light">Terakhir diperbarui: {{ now()->format('d M Y') }}</small>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @else
            <div class="col-xl-3 col-md-6 mb-4">
                <a href="{{ route('proker.index') }}" class="text-decoration-none">
                    <div class="card gradient-warning text-white shadow h-100 py-2">
                        <div class="card-body d-flex align-items-center">
                            <div class="me-3">
                                <i class="fas fa-tasks fa-2x"></i>
                            </div>
                            <div>
                                <div class="text-xs font-weight-bold text-uppercase mb-1">Total Program Kerja</div>
                                <div class="h5 mb-0 font-weight-bold">{{ \App\Models\Proker::count() }}</div>
                                <small class="text-light">Terakhir diperbarui: {{ now()->format('d M Y') }}</small>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @endif
    </div>

    <!-- Content Section -->
    <div class="row px-4 fade-in">
        <!-- Events Overview -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Events Overview</h6>
                    <a href="{{ route('admin.event.index') }}" class="btn btn-sm btn-primary">Lihat Semua</a>
                </div>
                <div class="card-body">
                    @if($events->isEmpty())
                        <p class="text-muted">Belum ada event yang tersedia.</p>
                    @else
                        <ul class="list-group list-group-flush">
                            @foreach($events as $event)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ $event->name }}</strong><br>
                                        <small>{{ $event->start_date->format('d M Y') }} - {{ $event->location }}</small>
                                    </div>
                                    <span class="badge bg-{{ $event->status == 'completed' ? 'success' : ($event->status == 'scheduled' ? 'primary' : 'warning') }}">
                                        {{ ucfirst($event->status) }}
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>

        <!-- Approved Proposals -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Approved Proposals</h6>
                    <a href="{{ route('admin.kaprodi.proposals.index') }}" class="btn btn-sm btn-primary">Lihat Semua</a>
                </div>
                <div class="card-body">
                    @if($approvedProposals->isEmpty())
                        <p class="text-muted">Belum ada proposal yang disetujui.</p>
                    @else
                        <ul class="list-group list-group-flush">
                            @foreach($approvedProposals as $proposal)
                                <li class="list-group-item">
                                    <strong>{{ $proposal->title }}</strong><br>
                                    <small>Proker: {{ $proposal->proker->name ?? 'N/A' }}</small><br>
                                    <small>Disetujui pada: {{ $proposal->reviewed_at->format('d M Y') }}</small>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>

        <!-- Program Kerja Terbaru (untuk kaprodi) / News Updates (untuk lainnya) -->
        @if(session('user')['role'] !== 'kaprodi')
            <div class="col-xl-4 col-lg-5">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">News Updates</h6>
                        <a href="{{ route('admin.news.index') }}" class="btn btn-sm btn-primary">Lihat Semua</a>
                    </div>
                    <div class="card-body">
                        @if($news->isEmpty())
                            <p class="text-muted">Belum ada berita yang tersedia.</p>
                        @else
                            <ul class="list-group list-group-flush">
                                @foreach($news as $article)
                                    <li class="list-group-item d-flex align-items-center">
                                        @if($article->image)
                                            <img src="{{ Storage::url($article->image) }}" alt="{{ $article->title }}" class="news-thumbnail me-3">
                                        @else
                                            <i class="fas fa-newspaper fa-2x me-3 text-muted"></i>
                                        @endif
                                        <div>
                                            <strong>{{ Str::limit($article->title, 30) }}</strong><br>
                                            <small>{{ Str::limit($article->content, 50) }}</small>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        @else
            <div class="col-xl-4 col-lg-5">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Program Kerja Terbaru</h6>
                        <a href="{{ route('proker.index') }}" class="btn btn-sm btn-primary">Lihat Semua</a>
                    </div>
                    <div class="card-body">
                        @if($prokers->isEmpty())
                            <p class="text-muted">Belum ada program kerja yang tersedia.</p>
                        @else
                            <ul class="list-group list-group-flush">
                                @foreach($prokers as $proker)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong>{{ Str::limit($proker->subject, 30) }}</strong><br>
                                            <small>Periode: {{ $proker->period }}</small>
                                        </div>
                                        <span class="badge bg-{{ $proker->status == 'Selesai' ? 'success' : ($proker->status == 'Pelaksanaan' ? 'primary' : 'warning') }}">
                                            {{ $proker->status }}
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>
    <!-- Dropdown Filter Periode Grafik Keuangan -->
<form method="GET" class="mb-3 px-4">
    <label for="periode" class="me-2 fw-bold">Periode Grafik:</label>
    <select name="periode" id="periode" onchange="this.form.submit()" class="form-select w-auto d-inline">
        <option value="3" {{ request('periode', '3') == '3' ? 'selected' : '' }}>3 Bulan Terakhir</option>
        <option value="6" {{ request('periode') == '6' ? 'selected' : '' }}>6 Bulan Terakhir</option>
        <option value="12" {{ request('periode') == '12' ? 'selected' : '' }}>12 Bulan (Setahun)</option>
    </select>
</form>
    <!-- Grafik Keuangan -->
<div class="row px-4 fade-in">
    <div class="col-md-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Grafik Keuangan Tahun {{ date('Y') }}</h6>
            </div>
            <div class="card-body">
                <canvas id="keuanganChart" height="100"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('keuanganChart').getContext('2d');
    const keuanganChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($bulanLabels),
            datasets: [
                {
                    label: 'Pemasukan',
                    data: @json($pemasukanData),
                    backgroundColor: 'rgba(54, 162, 235, 0.7)'
                },
                {
                    label: 'Pengeluaran',
                    data: @json($pengeluaranData),
                    backgroundColor: 'rgba(255, 99, 132, 0.7)'
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'top' },
                title: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                }
            }
        }
    });
</script>
@endsection
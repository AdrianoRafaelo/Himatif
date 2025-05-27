@extends('admin.layouts')

@section('title', 'Edit Proker')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/proker-form.css') }}">
<!-- Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
<style>
    .input-icon-container {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .input-icon {
        font-size: 16px;
        color: #6c757d;
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="proker-form-container">
        <h1>Edit Proker</h1>
        
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('proker.update', $proker->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="form-group mb-3">
                <div class="input-icon-container">
                    <label for="subject">Perihal <span class="text-danger">*</span></label>
                    <i class="fas fa-file-alt input-icon"></i>
                </div>
                <input type="text" class="form-control" id="subject" name="subject" value="{{ old('subject', $proker->subject) }}" placeholder="Masukkan perihal proker" required>
                @error('subject')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            
            <div class="form-group mb-3">
                <div class="input-icon-container">
                    <label for="description">Deskripsi</label>
                    <i class="fas fa-align-left input-icon"></i>
                </div>
                <textarea class="form-control" id="description" name="description" rows="3" placeholder="Deskripsi detail program kerja">{{ old('description', $proker->description) }}</textarea>
                <small class="form-text">Jelaskan secara detail mengenai program kerja yang akan dilaksanakan</small>
                @error('description')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            
            <div class="form-section">
                <span>Detail Proker</span>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <div class="input-icon-container">
                            <label for="objective">Tujuan</label>
                            <i class="fas fa-bullseye input-icon"></i>
                        </div>
                        <textarea class="form-control" id="objective" name="objective" rows="3" placeholder="Tujuan proker">{{ old('objective', $proker->objective) }}</textarea>
                        @error('objective')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <div class="input-icon-container">
                            <label for="location">Lokasi</label>
                            <i class="fas fa-map-marker-alt input-icon"></i>
                        </div>
                        <input type="text" class="form-control" id="location" name="location" value="{{ old('location', $proker->location) }}" placeholder="Lokasi pelaksanaan">
                        @error('location')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <div class="input-icon-container">
                            <label for="planned_date">Rencana Tanggal</label>
                            <i class="far fa-calendar input-icon"></i>
                        </div>
                        <input type="month" class="form-control" id="planned_date" name="planned_date" value="{{ old('planned_date', $proker->planned_date ? \Carbon\Carbon::parse($proker->planned_date)->format('Y-m') : '') }}">
                        @error('planned_date')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <div class="input-icon-container">
                            <label for="actual_date">Realisasi Tanggal</label>
                            <i class="far fa-calendar-check input-icon"></i>
                        </div>
                        <input type="date" class="form-control" id="actual_date" name="actual_date" value="{{ old('actual_date', $proker->actual_date) }}">
                        @error('actual_date')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="form-section">
                <span>Informasi Anggaran</span>
            </div>
            
            <div class="form-group mb-3">
                <label for="funding_source_select">Sumber Dana</label>
                <div class="input-icon-container">
                    <i class="fas fa-money-bill-wave input-icon"></i>
                    <select class="form-control" id="funding_source_select" onchange="handleFundingSourceChange()">
                        <option value="">-- Pilih Sumber Dana --</option>
                        <option value="HIMATIF" {{ old('funding_source', $proker->funding_source) == 'HIMATIF' ? 'selected' : '' }}>HIMATIF</option>
                        <option value="Other" {{ old('funding_source', $proker->funding_source) && old('funding_source', $proker->funding_source) != 'HIMATIF' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>
                <div id="other_funding_container" style="display: {{ old('funding_source', $proker->funding_source) && old('funding_source', $proker->funding_source) != 'HIMATIF' ? 'block' : 'none' }};">
                    <input type="text" class="form-control mt-2" id="other_funding_input" oninput="syncOtherFunding()" value="{{ old('funding_source', $proker->funding_source) && old('funding_source', $proker->funding_source) != 'HIMATIF' ? old('funding_source', $proker->funding_source) : '' }}" placeholder="Masukkan sumber dana lain">
                </div>
                <input type="hidden" id="funding_source" name="funding_source" value="{{ old('funding_source', $proker->funding_source) }}">
                @error('funding_source')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="budget-card">
                        <div class="form-group mb-3">
                            <div class="input-icon-container">
                                <label for="planned_budget">Rencana Anggaran</label>
                                <i class="fas fa-hand-holding-usd input-icon"></i>
                            </div>
                            <input type="number" class="form-control" id="planned_budget" name="planned_budget" value="{{ old('planned_budget', $proker->planned_budget) }}" placeholder="0">
                            @error('planned_budget')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="budget-card">
                        <div class="form-group mb-3">
                            <div class="input-icon-container">
                                <label for="actual_budget">Realisasi Anggaran</label>
                                <i class="fas fa-coins input-icon"></i>
                            </div>
                            <input type="number" class="form-control" id="actual_budget" name="actual_budget" value="{{ old('actual_budget', $proker->actual_budget) }}" placeholder="0">
                            @error('actual_budget')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <div class="input-icon-container">
                            <label for="status">Status</label>
                            <i class="fas fa-info-circle input-icon"></i>
                        </div>
                        <select class="form-control" id="status" name="status">
                            <option value="">-- Pilih Status --</option>
                            <option value="Perencanaan" {{ old('status', $proker->status) == 'Perencanaan' ? 'selected' : '' }}>Perencanaan</option>
                            <option value="Persiapan" {{ old('status', $proker->status) == 'Persiapan' ? 'selected' : '' }}>Persiapan</option>
                            <option value="Pelaksanaan" {{ old('status', $proker->status) == 'Pelaksanaan' ? 'selected' : '' }}>Pelaksanaan</option>
                             @if(auth()->user() && auth()->user()->role == 'kaprodi')
                            <option value="Selesai" {{ old('status', $proker->status) == 'Selesai' ? 'selected' : '' }} {{ $proker->approval_status == 'approved' ? 'disabled' : '' }}>Selesai</option>
                            @endif
                        </select>
                        @error('status')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        @if($proker->approval_status == 'approved')
                            <small class="form-text text-muted">Status tidak dapat diubah karena berita acara telah disetujui.</small>
                        @endif
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <div class="input-icon-container">
                            <label for="period">Periode <span class="text-danger">*</span></label>
                            <i class="fas fa-calendar-day input-icon"></i>
                        </div>
                        <select class="form-control" id="period" name="period" required @if(empty($periods)) disabled @endif>
                            <option value="">-- Pilih Periode --</option>
                            @foreach($periods as $p)
                                <option value="{{ $p }}" {{ old('period', $proker->period) == $p ? 'selected' : '' }}>{{ $p }}</option>
                            @endforeach
                        </select>
                        @error('period')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        @if(empty($periods))
                            <small class="text-danger">Tidak ada periode BPH tersedia. Tambahkan anggota BPH terlebih dahulu.</small>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Tambahkan field upload berita acara -->
            @if($proker->status == 'Pelaksanaan' || $proker->status == 'Selesai')
            <div class="form-group mb-3">
                <div class="input-icon-container">
                    <label for="report_file">Berita Acara</label>
                    <i class="fas fa-file-upload input-icon"></i>
                </div>
                <input type="file" class="form-control" id="report_file" name="report_file" accept=".pdf" {{ $proker->approval_status == 'approved' || $proker->approval_status == 'rejected' ? 'disabled' : '' }}>
                @if($proker->report_file)
                    <small class="form-text">File saat ini: <a href="{{ Storage::url($proker->report_file) }}" target="_blank">Lihat Berita Acara</a></small>
                @endif
                <small class="form-text">Unggah berita acara dalam format PDF (maks. 5MB).</small>
                @error('report_file')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            @if($proker->approval_status)
                <div class="form-group mb-3">
                    <label>Status Persetujuan</label>
                    <p>{{ ucfirst($proker->approval_status) }}</p>
                </div>
            @endif
            @endif

            <div class="form-buttons">
                <a href="{{ route('proker.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left mr-2"></i> Batal
                </a>
                <button type="submit" class="btn btn-primary" @if(empty($periods)) disabled @endif>
                    <i class="fas fa-save mr-2"></i> Update Proker
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function handleFundingSourceChange() {
        const select = document.getElementById('funding_source_select');
        const otherContainer = document.getElementById('other_funding_container');
        const otherInput = document.getElementById('other_funding_input');
        const hiddenInput = document.getElementById('funding_source');

        if (select.value === 'Other') {
            otherContainer.style.display = 'block';
            hiddenInput.value = otherInput.value || '';
        } else {
            otherContainer.style.display = 'none';
            hiddenInput.value = select.value;
        }
    }

    function syncOtherFunding() {
        const otherInput = document.getElementById('other_funding_input').value;
        document.getElementById('funding_source').value = otherInput;
    }

    document.addEventListener('DOMContentLoaded', function () {
        // Atur tampilan awal jika old value bukan HIMATIF
        const oldValue = "{{ old('funding_source', $proker->funding_source) }}";
        const select = document.getElementById('funding_source_select');
        const otherInput = document.getElementById('other_funding_input');
        const hiddenInput = document.getElementById('funding_source');

        if (oldValue && oldValue !== 'HIMATIF') {
            select.value = 'Other';
            otherInput.value = oldValue;
            hiddenInput.value = oldValue;
            document.getElementById('other_funding_container').style.display = 'block';
        } else {
            select.value = oldValue;
            document.getElementById('other_funding_container').style.display = 'none';
        }

        // Tambahkan animasi saat form dimuat
        const formContainer = document.querySelector('.proker-form-container');
        if (formContainer) {
            formContainer.classList.add('fade-in');
        }

        // Highlight saat focus input
        const formControls = document.querySelectorAll('.form-control');
        formControls.forEach(element => {
            element.addEventListener('focus', function () {
                this.parentElement.classList.add('input-focused');
            });
            element.addEventListener('blur', function () {
                this.parentElement.classList.remove('input-focused');
            });
        });

        // Validasi wajib isi realisasi anggaran & tanggal jika upload berita acara
        const form = document.querySelector('form');
        form.addEventListener('submit', function(e) {
            const reportFile = document.getElementById('report_file');
            const actualBudget = document.getElementById('actual_budget');
            const actualDate = document.getElementById('actual_date');

            // Cek jika upload berita acara atau sudah ada file berita acara
            if ((reportFile && reportFile.value) || "{{ $proker->report_file }}") {
                if (!actualBudget.value || actualBudget.value <= 0) {
                    alert('Realisasi Anggaran wajib diisi dan lebih dari 0 jika mengupload berita acara!');
                    actualBudget.focus();
                    e.preventDefault();
                    return false;
                }
                if (!actualDate.value) {
                    alert('Realisasi Tanggal wajib diisi jika mengupload berita acara!');
                    actualDate.focus();
                    e.preventDefault();
                    return false;
                }
            }
        });
    });
</script>
@endsection
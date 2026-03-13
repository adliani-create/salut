@extends('layouts.admin')

@section('title', 'Dashboard Overview')

@section('content')
    {{-- Key Metrics Cards --}}
    <div class="row g-4 mb-4 p-4">
        <!-- Active Students -->
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100 bg-primary bg-gradient text-white">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h6 class="text-uppercase mb-1 opacity-75">Mahasiswa Aktif</h6>
                            <h2 class="display-5 fw-bold mb-0">{{ $active_students }}</h2>
                        </div>
                        <i class="bi bi-people-fill display-4 opacity-50"></i>
                    </div>
                     <p class="small mb-0 opacity-75"><i class="bi bi-arrow-up-circle me-1"></i> Data Real-time</p>
                </div>
            </div>
        </div>

        <!-- Pending Payments (Action Item) -->
        <div class="col-md-6 col-lg-3">
            <a href="{{ route('admin.billings.index', ['status' => 'pending']) }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 bg-warning bg-gradient text-dark">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h6 class="text-uppercase mb-1 opacity-75">Menunggu Verifikasi</h6>
                                <h2 class="display-5 fw-bold mb-0">{{ $pending_bills_count }}</h2>
                            </div>
                            <i class="bi bi-clock-history display-4 opacity-50"></i>
                        </div>
                        <p class="small mb-0 opacity-75 fw-bold"><i class="bi bi-exclamation-circle me-1"></i> Klik untuk proses</p>
                    </div>
                </div>
            </a>
        </div>
        
        <!-- Total Prodi (Existing) -->
        <div class="col-md-6 col-lg-3">
             <div class="card border-0 shadow-sm h-100 bg-white">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h6 class="text-secondary text-uppercase mb-1">Total Prodi</h6>
                            <h2 class="display-5 fw-bold text-dark mb-0">{{ $stats['total_prodi'] }}</h2>
                        </div>
                        <div class="rounded-circle bg-info bg-opacity-10 p-3">
                             <i class="bi bi-book fs-2 text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
         <!-- Total Fakultas (Existing) -->
        <div class="col-md-6 col-lg-3">
             <div class="card border-0 shadow-sm h-100 bg-white">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h6 class="text-secondary text-uppercase mb-1">Total Fakultas</h6>
                            <h2 class="display-5 fw-bold text-dark mb-0">{{ $stats['total_fakultas'] }}</h2>
                        </div>
                        <div class="rounded-circle bg-success bg-opacity-10 p-3">
                             <i class="bi bi-building fs-2 text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4 p-4">
        <!-- Chart Section -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm h-100">
                     <h5 class="fw-bold mb-0 text-primary p-4">Sebaran Program Karir</h5>
                <div class="card-body">
                    <div style="height: 300px; position: relative;">
                        <canvas id="programChart"></canvas>
                    </div>
                    <div class="text-center mt-3 text-muted small">
                        Klik pada potongan chart untuk melihat data detail.
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity Tables -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0 text-primary">Aktivitas Terbaru</h5>
                </div>
                <div class="card-body p-0">
                    <ul class="nav nav-tabs nav-fill" id="activityTab" role="tablist">
                         <li class="nav-item" role="presentation">
                            <button class="nav-link active fw-bold" id="registrants-tab" data-bs-toggle="tab" data-bs-target="#registrants" type="button" role="tab">Pendaftar Terbaru</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link fw-bold" id="payments-tab" data-bs-toggle="tab" data-bs-target="#payments" type="button" role="tab">Pembayaran Terbaru</button>
                        </li>
                    </ul>
                    
                    <div class="tab-content p-3" id="activityTabContent">
                        <!-- Registrants -->
                        <div class="tab-pane fade show active" id="registrants" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Nama</th>
                                            <th>Program</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($recent_users as $user)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width:32px;height:32px;font-size:0.8rem;">
                                                        {{ substr($user->name, 0, 1) }}
                                                    </div>
                                                    <div>
                                                        <div class="fw-bold">{{ $user->name }}</div>
                                                        <div class="small text-muted">{{ $user->email }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                 @php
                                                    $reg = $user->registration;
                                                 @endphp
                                                 <span class="badge bg-light text-dark border">{{ $reg ? $reg->jalur_pendaftaran : '-' }}</span>
                                            </td>
                                            <td>
                                                 @if($user->status == 'active')
                                                    <span class="badge bg-success">Aktif</span>
                                                 @else
                                                    <span class="badge bg-secondary">{{ ucfirst($user->status) }}</span>
                                                 @endif
                                            </td>
                                        </tr>
                                        @empty
                                        <tr><td colspan="3" class="text-center text-muted">Belum ada data.</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <!-- Payments -->
                        <div class="tab-pane fade" id="payments" role="tabpanel">
                             <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Mahasiswa</th>
                                            <th>Nominal</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($recent_payments as $bill)
                                        <tr>
                                            <td>
                                                <div class="fw-bold">{{ $bill->user->name ?? 'Unknown' }}</div>
                                                <small class="text-muted">{{ $bill->billing_code }}</small>
                                            </td>
                                            <td>Rp {{ number_format($bill->amount, 0, ',', '.') }}</td>
                                            <td>
                                                @if($bill->status == 'paid')
                                                    <span class="badge bg-success">Lunas</span>
                                                @elseif($bill->status == 'pending')
                                                    <span class="badge bg-warning text-dark">Pending</span>
                                                @else
                                                    <span class="badge bg-secondary">{{ ucfirst($bill->status) }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @empty
                                        <tr><td colspan="3" class="text-center text-muted">Belum ada data.</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('programChart').getContext('2d');
            const data = @json($program_distribution);
            
            const labels = Object.keys(data);
            const values = Object.values(data);
            
            // Generate colors
            const colors = [
                '#0d6efd', '#20c997', '#ffc107', '#dc3545', '#6610f2', 
                '#fd7e14', '#0dcaf0', '#6c757d'
            ];
            
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [{
                        data: values,
                        backgroundColor: colors.slice(0, labels.length),
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                boxWidth: 12
                            }
                        }
                    },
                    onClick: (evt, elements) => {
                        if (elements.length > 0) {
                            const index = elements[0].index;
                            const label = labels[index];
                            // Redirect to drill-down view (assuming we have a filter or just to students list)
                             window.location.href = `{{ route('admin.students.index') }}?search=${label}`;
                        }
                    }
                }
            });
        });
    </script>
    @endpush
@endsection

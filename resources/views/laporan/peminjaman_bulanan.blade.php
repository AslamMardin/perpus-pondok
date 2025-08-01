@extends('layouts.admin')

@section('title', 'Grafik Peminjaman Per Bulan')

@section('content')
    <div class="page-header d-flex justify-content-between align-items-center">
        <h4 class="mb-4">Grafik Peminjaman Buku - Tahun {{ $tahun }}</h4>

        <!-- Filter Tahun -->
        <form method="GET" action="{{ route('laporan.grafik') }}">
            <select name="tahun" onchange="this.form.submit()" class="form-select">
                @foreach ($daftarTahun as $th)
                    <option value="{{ $th }}" {{ $tahun == $th ? 'selected' : '' }}>{{ $th }}</option>
                @endforeach
            </select>
        </form>
    </div>

    <div class="card shadow-sm p-4">
        <canvas id="peminjamanChart" height="120"></canvas>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('peminjamanChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($labels),
                datasets: [{
                    label: 'Jumlah Peminjaman',
                    data: @json($totals),
                    fill: false,
                    borderColor: 'rgba(0, 128, 0, 1)', // hijau
                    backgroundColor: 'rgba(0, 128, 0, 0.3)',
                    tension: 0.3,
                    pointBackgroundColor: 'rgba(0, 128, 0, 1)',
                    pointRadius: 5,
                    pointHoverRadius: 8
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true
                    },
                    tooltip: {
                        enabled: true
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            callback: function(value, index) {
                                const label = this.getLabelForValue(value);
                                return label; // label sudah array [bulan indo, bulan islami]
                            }
                        }
                    },
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection

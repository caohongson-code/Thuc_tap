@extends('admin.layouts.app')

@section('content')
<div class="container-fluid py-4">
    <h2 class="mb-4">📊 Bảng điều khiển</h2>
    <p class="text-muted">Xem nhanh doanh thu và số lượng đơn hàng hệ thống.</p>

    <div class="row mb-4">
        <!-- Tổng doanh thu -->
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="card-title text-uppercase text-muted mb-2">Doanh thu</h6>
                    <h4 class="text-success">{{ number_format($totalRevenue, 0, ',', '.') }}₫</h4>
                </div>
            </div>
        </div>

        <!-- Tổng đơn hàng -->
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="card-title text-uppercase text-muted mb-2">Tổng đơn hàng</h6>
                    <h4 class="text-primary">{{ $totalOrders }}</h4>
                </div>
            </div>
        </div>
    </div>

    <!-- Bộ lọc thời gian và biểu đồ -->
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="card-title mb-0">Thống kê đơn hàng theo 
                    {{ $type == 'week' ? 'tuần' : ($type == 'month' ? 'tháng' : 'năm') }}
                </h5>
                <form method="GET" class="d-inline-block">
                    <select name="type" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="week" {{ $type == 'week' ? 'selected' : '' }}>Theo tuần</option>
                        <option value="month" {{ $type == 'month' ? 'selected' : '' }}>Theo tháng</option>
                        <option value="year" {{ $type == 'year' ? 'selected' : '' }}>Theo năm</option>
                    </select>
                </form>
            </div>

            <canvas id="orderChart" height="100"></canvas>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    const ctx = document.getElementById('orderChart').getContext('2d');

    const labels = {!! json_encode($labels) !!};
    const statusLabels = {!! json_encode($statusLabels) !!};
    const rawData = {!! json_encode($datasets) !!};

    const statusColors = {
        choxuly: '#f39c12',
        daxacnhan: '#3498db',
        davanchuyen: '#27ae60',
        danggiao: '#9b59b6',
        thanhcong: '#2ecc71',
        huy: '#7f8c8d'
    };

    const datasets = [];
    for (const [statusKey, values] of Object.entries(rawData)) {
        datasets.push({
            label: statusLabels[statusKey] ?? statusKey,
            data: values,
            backgroundColor: statusColors[statusKey] ?? '#999',
            borderRadius: 5,
            barThickness: 24
        });
    }

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: datasets
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Thống kê số lượng đơn theo trạng thái',
                    font: { size: 18 }
                },
                legend: {
                    position: 'bottom'
                },
                tooltip: {
                    mode: 'index',
                    intersect: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0,
                        stepSize: 1
                    }
                }
            }
        }
    });
</script>
@endsection

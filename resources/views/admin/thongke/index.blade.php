@extends('admin.layouts.app')

@section('content')

<div class="container py-3">
    <h3 class="mb-4">📊 Thống kê đơn hàng theo {{ $type == 'week' ? 'tuần' : ($type == 'month' ? 'tháng' : 'năm') }}</h3>

    <form method="GET" class="mb-4">
        <select name="type" class="form-select w-auto d-inline-block" onchange="this.form.submit()">
            <option value="week" {{ $type == 'week' ? 'selected' : '' }}>Theo tuần</option>
            <option value="month" {{ $type == 'month' ? 'selected' : '' }}>Theo tháng</option>
            <option value="year" {{ $type == 'year' ? 'selected' : '' }}>Theo năm</option>
        </select>
    </form>

<canvas id="orderChart" height="150"></canvas>
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
        dangiao: '#9b59b6',
        thanhcong: '#e74c3c',
        huy: '#000000'
    };

    const datasets = [];
    for (const [statusKey, values] of Object.entries(rawData)) {
        datasets.push({
            label: statusLabels[statusKey] ?? statusKey,
            data: values,
            backgroundColor: statusColors[statusKey] ?? '#999'
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
                    text: 'Thống kê đơn hàng theo trạng thái'
                },
                legend: {
                    position: 'bottom'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { precision: 0 }
                }
            }
        }
    });
</script>
@endsection


<!-- Biểu đồ -->
<div class="row">
    <div class="col-md-6 centered-chart">
        <canvas id="statusPieChart"></canvas>
    </div>
    <div class="col-md-6">
        <canvas id="statusBarChart"></canvas>
    </div>
</div>
<div class="row mt-4">
    <div class="col-md-6">
        <canvas id="projectBarChart"></canvas>
    </div>
    <div class="col-md-6">
        <canvas id="userBarChart"></canvas>
    </div>
</div>

<!-- Xử lý thống kê -->
<?php
$statusStats = [];
$projectStats = [];
$userStats = [];
foreach ($allTasks as $task) {
    $status = $task['task_status'] ?? 'Chưa nhận việc';
    $statusStats[$status] = ($statusStats[$status] ?? 0) + 1;

    $project = $task['project_group_name'] ?? 'Không rõ';
    $projectStats[$project] = ($projectStats[$project] ?? 0) + 1;

    $users = $task['supervisor_names'] ?? '';
    foreach (explode(',', $users) as $u) {
        $u = trim($u);
        if ($u) $userStats[$u] = ($userStats[$u] ?? 0) + 1;
    }
}
arsort($projectStats);
arsort($userStats);
?>
<!-- Top 5 -->
<div class="row mt-4">
    <div class="col-md-6">
        <h6>Top 5 người phụ trách nhiều task nhất</h6>
        <ul class="list-group">
            <?php foreach (array_slice($userStats, 0, 5) as $u => $count): ?>
                <li class="list-group-item d-flex justify-content-between">
                    <span><?= $u ?></span>
                    <strong><?= number_format($count) ?></strong>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <div class="col-md-6">
        <h6>Top 5 dự án có nhiều task nhất</h6>
        <ul class="list-group">
            <?php foreach (array_slice($projectStats, 0, 5) as $p => $count): ?>
                <li class="list-group-item d-flex justify-content-between">
                    <span><?= $p ?></span>
                    <strong><?= number_format($count) ?></strong>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

<script>
const statusLabels = <?= json_encode(array_keys($statusStats)) ?>;
const statusCounts = <?= json_encode(array_values($statusStats)) ?>;
const projectLabels = <?= json_encode(array_keys($projectStats)) ?>;
const projectCounts = <?= json_encode(array_values($projectStats)) ?>;
const userLabels = <?= json_encode(array_keys($userStats)) ?>;
const userCounts = <?= json_encode(array_values($userStats)) ?>;

// Biểu đồ tròn - Tỉ lệ trạng thái công việc
new Chart(document.getElementById('statusPieChart'), {
    type: 'pie',
    data: {
        labels: statusLabels,
        datasets: [{
            data: statusCounts,
            backgroundColor: [
                '#9E9E9E', '#2196F3', '#FF9800', '#FFEB3B', '#00BCD4', '#4CAF50', '#9C27B0', '#F44336'
            ]
        }]
    },



    options: {
        responsive: true,
        plugins: {
            title: { display: true, text: 'Tỉ lệ trạng thái công việc' },
            legend: { position: 'right' },
            datalabels: {
                formatter: (value, ctx) => {
                    const sum = ctx.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                    return ((value / sum) * 100).toFixed(1) + '%';
                },
                color: '#fff',
                font: {
                    weight: 'bold',
                    size: 13
                }
            }
        }
    },
    plugins: [ChartDataLabels]
});

// Biểu đồ cột - Trạng thái
new Chart(document.getElementById('statusBarChart'), {
    type: 'bar',
    data: {
        labels: statusLabels,
        datasets: [{
            label: 'Số lượng công việc theo trạng thái',
            data: statusCounts,
            backgroundColor: '#607D8B'
        }]
    },
    options: {
        responsive: true,
        plugins: {
            title: { display: true, text: 'Số lượng công việc theo trạng thái' },
            legend: { display: false },
            datalabels: {
                anchor: 'end',
                align: 'top',
                color: '#000',
                font: { weight: 'bold' }
            }
        },
        scales: {
            y: { beginAtZero: true }
        }
    },
    plugins: [ChartDataLabels]
});

// Biểu đồ cột - Dự án
new Chart(document.getElementById('projectBarChart'), {
    type: 'bar',
    data: {
        labels: projectLabels,
        datasets: [{
            label: 'Số công việc theo dự án',
            data: projectCounts,
            backgroundColor: '#03A9F4'
        }]
    },
    options: {
        responsive: true,
        plugins: {
            title: { display: true, text: 'Số lượng công việc theo dự án' },
            legend: { display: false },
            datalabels: {
                anchor: 'end',
                align: 'top',
                color: '#000',
                font: { weight: 'bold' }
            }
        },
        scales: {
            y: { beginAtZero: true }
        }
    },
    plugins: [ChartDataLabels]
});

// Biểu đồ cột - Người phụ trách
new Chart(document.getElementById('userBarChart'), {
    type: 'bar',
    data: {
        labels: userLabels,
        datasets: [{
            label: 'Số công việc theo người phụ trách',
            data: userCounts,
            backgroundColor: '#FF9800'
        }]
    },
    options: {
        responsive: true,
        plugins: {
            title: { display: true, text: 'Số lượng công việc theo người phụ trách' },
            legend: { display: false },
            datalabels: {
                anchor: 'end',
                align: 'top',
                color: '#000',
                font: { weight: 'bold' }
            }
        },
        scales: {
            y: { beginAtZero: true }
        }
    },
    plugins: [ChartDataLabels]
});
</script>


<style>
.table-dashboard th {
    background-color: #f5f5f5;
    font-size: 14px;
    text-transform: uppercase;
    font-weight: 600;
    color: #444;
    border-bottom: 2px solid #ddd;
}

.table-dashboard td {
    font-size: 13px;
    vertical-align: middle;
}

.label {
    font-size: 12px;
    border-radius: 12px;
    padding: 4px 10px;
    font-weight: 500;
    display: inline-block;
    min-width: 100px;
    text-align: center;
}

.progress {
    background-color: #eee;
    height: 16px;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
}

.progress-bar {
    line-height: 16px;
    font-size: 11px;
    font-weight: 600;
}
canvas#statusPieChart{
    width: 460px !important;
    height: 460px !important;
}
.col-md-6.centered-chart {
    display: flex;
    justify-content: center;
}
</style>
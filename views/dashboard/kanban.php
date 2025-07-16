<?php
// Khai báo mảng cấu hình trạng thái
$statusConfig = [
    'Chưa nhận việc'       => ['class' => 'chua-nhan-viec',    'icon' => 'playlist_add',         'color' => '#9E9E9E'],
    'Đang thực hiện'       => ['class' => 'dang-thuc-hien',    'icon' => 'autorenew',            'color' => '#2196F3'],
    'Trình duyệt'          => ['class' => 'trinh-duyet',       'icon' => 'visibility',           'color' => '#FF9800'],
    'Điều chỉnh nội dung'  => ['class' => 'dieu-chinh',        'icon' => 'edit',                 'color' => '#FFEB3B'],
    'Tái trình duyệt'      => ['class' => 'tai-trinh-duyet',   'icon' => 'repeat',               'color' => '#00BCD4'],
    'Đã hoàn thành'        => ['class' => 'da-hoan-thanh',     'icon' => 'check_circle',         'color' => '#4CAF50'],
    'Đã hoãn việc'         => ['class' => 'da-hoan-viec',      'icon' => 'pause_circle_filled',  'color' => '#BA68C8'],
    'Đã hủy'               => ['class' => 'da-huy',            'icon' => 'cancel',               'color' => '#F44336']
];
?>

<style>
<?php foreach ($statusConfig as $key => $cfg): ?>
.status-<?= $cfg['class'] ?> { background: <?= $cfg['color'] ?>; }
.kanban-card[data-status="<?= $key ?>"] { border-left: 5px solid <?= $cfg['color'] ?>; }
<?php endforeach; ?>

.info-box {
    display: flex;
    align-items: center;
    color: white;
    padding: 6px;
    border-radius: 6px;
    margin-bottom: 12px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}
.info-box .icon {
    font-size: 36px;
    margin-right: 16px;
}
.info-box .content .text {
    font-size: 13px;
    text-transform: uppercase;
    opacity: 0.85;
    color: white;
}
.info-box .content .number {
    font-size: 24px;
    font-weight: bold;
    text-align: center;
    color: white;
}

.status-board {
    display: grid;
    grid-template-columns: repeat(8, 1fr);
    gap: 12px;
    overflow-x: auto;
    padding: 10px 0;
}
.status-column .info-box {
    height: 100%;
}

.kanban-board {
    display: grid;
    grid-template-columns: repeat(8, 1fr);
    gap: 12px;
    overflow-x: auto;
    padding: 10px;
}
.kanban-column {
    background: #f5f5f5;
    border-radius: 8px;
    padding: 8px;
    min-width: 180px;
    display: flex;
    flex-direction: column;
    max-height: 90vh;
}
.kanban-list {
    flex-grow: 1;
    overflow-y: auto;
}
.kanban-card {
    background: white;
    padding: 10px;
    margin-bottom: 10px;
    border-radius: 6px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    font-size: 13px;
    font-weight: 500;
}
</style>

<h4 style="margin: 20px 0 10px;">THỐNG KÊ TRẠNG THÁI</h4>
<div class="status-board">
    <?php foreach ($statusCount as $status => $count): 
        $config = $statusConfig[$status] ?? ['class' => 'default', 'icon' => 'assignment'];
    ?>
        <div class="status-column">
            <div class="info-box status-<?= $config['class'] ?>">
                <div class="icon"><i class="material-icons"><?= $config['icon'] ?></i></div>
                <div class="content">
                    <div class="text"><?= htmlspecialchars($status) ?></div>
                    <div class="number count-to" data-from="0" data-to="<?= $count ?>" data-speed="800"></div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<div class="kanban-board">
    <?php foreach ($statusCount as $status => $count): ?>
        <div class="kanban-column">
            <div class="kanban-list" data-status="<?= htmlspecialchars($status) ?>" id="list-<?= md5($status) ?>">
                <?php foreach ($allTasks as $task):
                    if (trim($task['task_status']) === $status): ?>
                       <!--  <div class="kanban-card" data-task-id="<?= $task['id'] ?>" data-status="<?= htmlspecialchars($status) ?>">
                            <strong><?= htmlspecialchars($task['project_group_name'] ?? 'Không rõ') ?></strong><br>
                            <small class="text-muted"><?= htmlspecialchars($task['category_name'] ?? 'Hạng mục chưa rõ') ?></small>
                        </div> -->
                        <div class="kanban-card" data-task-id="<?= $task['id'] ?>" data-status="<?= htmlspecialchars($status) ?>">
                            <div><strong><?= htmlspecialchars($task['detail'] ?? 'Không rõ nội dung') ?></strong></div>
                            <small class="text-muted">
                                <?= htmlspecialchars($task['supervisor_names'] ?? 'Chưa phân công') ?>
                            </small>
                            <small class="text-muted">Hạn: <?= date('d/m/Y', strtotime($task['due_date'])) ?></small>

                        </div>

                    <?php endif;
                endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<!-- ✅ Modal Popup Chi tiết công việc -->
<div class="modal fade" id="taskDetailModal" tabindex="-1" role="dialog" aria-labelledby="taskDetailLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="taskDetailLabel">Chi tiết công việc</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Đóng">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p><strong>Nội dung:</strong> <span id="modal-task-detail"></span><?= htmlspecialchars($task['detail'] ?? '') ?></p>
        <p><strong>Trạng thái:</strong> <span id="modal-task-status"></span></p>
        <p><strong>Người phụ trách:</strong> <span id="modal-task-users"></span><?= htmlspecialchars($task['supervisor_names'] ?? '') ?></p>
        <p><strong>Thời gian:</strong> <span id="modal-task-time"></span><?= htmlspecialchars($task['start_date'] ?? '') ?> - <?= htmlspecialchars($task['due_date'] ?? '') ?></p>
        <p><strong>Nhóm dự án:</strong> <span id="modal-task-group"></span><?= htmlspecialchars($task['project_group_name'] ?? '') ?></p>
        <p><strong>Hạng mục:</strong> <span id="modal-task-category"></span><?= htmlspecialchars($task['category_name'] ?? '') ?></p>
        <p><strong>Người giao:</strong> <span id="modal-task-creator"></span><?= htmlspecialchars($task['creator_full_name'] ?? '') ?></p>
        <!-- <p><strong>Người nhận:</strong> <span id="modal-task-assigned"></span><?= htmlspecialchars($task['assigned_full_name'] ?? '') ?></p> -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
      </div>
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll('.kanban-list').forEach(function (el) {
        new Sortable(el, {
            group: "kanban",
            animation: 150,
            onEnd: function (evt) {
                const taskId = evt.item.dataset.taskId;
                const newStatus = evt.to.dataset.status;
                fetch("index.php?controller=task&action=updateStatus", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ id: taskId, status: newStatus })
                }).then(r => r.text()).then(console.log);
            }
        });
    });
});
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll('.kanban-card').forEach(card => {
        card.addEventListener('click', function () {
            document.getElementById('modal-task-detail').textContent = this.dataset.detail;
            document.getElementById('modal-task-status').textContent = this.dataset.status;
            document.getElementById('modal-task-users').textContent = this.dataset.users;
            // document.getElementById('modal-task-time').textContent = ${this.dataset.start} → ${this.dataset.end};
            document.getElementById('modal-task-group').textContent = this.dataset.group;
            document.getElementById('modal-task-category').textContent = this.dataset.category;
            document.getElementById('modal-task-creator').textContent = this.dataset.creator;
            // document.getElementById('modal-task-assigned').textContent = this.dataset.assigned;

            $('#taskDetailModal').modal('show');
        });
    });
});
</script>

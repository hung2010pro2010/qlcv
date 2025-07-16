<!-- FullCalendar CSS & JS -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>

<style>
    #calendar {
        max-width: 100%;
        margin: 20px auto;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        padding: 10px;
    }
    .fc-event {
        font-size: 13px;
        border: none;
    }
    .status-Chưa-nhận-việc   { background-color: #9E9E9E !important; }
    .status-Đang-thực-hiện   { background-color: #2196F3 !important; }
    .status-Trình-duyet      { background-color: #FF9800 !important; }
    .status-Đã-hoàn-thành    { background-color: #4CAF50 !important; }
    .status-Đã-hoãn-việc     { background-color: #BA68C8 !important; }
    .status-Đã-hủy           { background-color: #F44336 !important; }
    .status-Điều-chỉnh-nội-dung { background-color: #FFEB3B !important; }
    .status-Tái-trình-duyet     { background-color: #00BCD4 !important; }
</style>

<!-- Lịch công việc -->
<div id="calendar"></div>

<!-- Modal Popup Chi tiết công việc -->
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
        <p><strong>Nội dung:</strong> <span id="modal-task-detail"></span></p>
        <p><strong>Trạng thái:</strong> <span id="modal-task-status"></span></p>
        <p><strong>Người phụ trách:</strong> <span id="modal-task-users"></span></p>
        <p><strong>Thời gian:</strong> <span id="modal-task-time"></span></p>
        <p><strong>Nhóm dự án:</strong> <span id="modal-task-group"></span></p>
        <p><strong>Hạng mục:</strong> <span id="modal-task-category"></span></p>
        <p><strong>Người giao:</strong> <span id="modal-task-creator"></span></p>
        <p><strong>Người nhận:</strong> <span id="modal-task-assigned"></span></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
      </div>
    </div>
  </div>
</div>

<!-- FullCalendar Script -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar');

    const rawTasks = <?= json_encode($allTasks) ?>;

    const events = rawTasks.map(task => {
        const statusClass = 'status-' + (task.task_status || '').replace(/\s/g, '-');

        return {
            id: task.id,
            title: task.detail || 'Không rõ nội dung',
            start: task.start_date && task.start_date !== '0000-00-00' ? task.start_date : undefined,
            end: task.due_date && task.due_date !== '0000-00-00' ? task.due_date : undefined,
            extendedProps: {
                detail: task.detail,
                status: task.task_status,
                start: task.start_date,
                end: task.due_date,
                users: task.supervisor_names,
                group: task.project_group_name,
                category: task.category_name,
                creator: task.creator_full_name,
                assigned: task.assigned_full_name
            },
            classNames: [statusClass]
        };
    });

    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek'
            // right: 'dayGridMonth,timeGridWeek,today'
        },
        buttonText: {
            today: 'Day',
            month: 'Month',
            week: 'Week',
            day: 'Today'
        },
        height: 'auto',
        events: events,
        eventClick: function (info) {
            const props = info.event.extendedProps;

            document.getElementById('modal-task-detail').textContent = props.detail || '';
            document.getElementById('modal-task-status').textContent = props.status || '';
            document.getElementById('modal-task-users').textContent = props.users || '';
            document.getElementById('modal-task-time').textContent = `${props.start || ''} → ${props.end || ''}`;
            document.getElementById('modal-task-group').textContent = props.group || '';
            document.getElementById('modal-task-category').textContent = props.category || '';
            document.getElementById('modal-task-creator').textContent = props.creator || '';
            document.getElementById('modal-task-assigned').textContent = props.assigned || '';

            $('#taskDetailModal').modal('show');
        }
    });

    calendar.render();
});
</script>

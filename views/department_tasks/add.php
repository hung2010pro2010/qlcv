<?php include 'views/layouts/header.php'; ?>
<?php include 'views/layouts/menu_header.php'; ?>
<?php include 'views/layouts/sidebar.php'; ?>

<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>Giao việc liên phòng</h2>
        </div>

        <div class="card">
            <div class="body">
<form method="post">
    <div class="row">
        <!-- Cột trái -->
        <div class="col-md-6">
            <!-- Mã công việc (tự sinh) -->
            <div class="form-group">
                <label>Mã công việc:</label>
                <!-- hiển thị cho người xem -->
                <input type="text"
                       class="form-control"
                       value="<?= htmlspecialchars($autoCode) ?>"
                       readonly>

                <!-- hidden để gửi sang server (phòng khi bạn muốn đọc lại) -->
                <input type="hidden"
                       name="code"
                       value="<?= htmlspecialchars($autoCode) ?>">
            </div>


            <div class="form-group">
                <label>Tên công việc:</label>
                <input type="text" name="title" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Mô tả công việc:</label>
                <textarea name="description" class="form-control" rows="4"></textarea>
            </div>

            <div class="form-group">
                <label>Danh mục công việc:</label>
                <select name="category_id" class="form-control" required>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category['id'] ?>"><?= htmlspecialchars($category['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
<div class="row">
  <div class="form-group">
    <label>Phân công nhân viên & phòng phụ trách:</label>
    <div id="user-department-list">
        <?php foreach ($managerUsers as $u): ?>
            <?php
                $deptId = $u['department_id'];
                $deptName = '';
                foreach ($departments as $d) {
                    if ($d['id'] == $deptId) {
                        $deptName = $d['name'];
                        break;
                    }
                }
            ?>
            <div class="row align-items-center mb-2">
                <!-- Nhân viên -->
                <div class="col-md-6">
                    <div class="form-check">
                        <input class="form-check-input responsible-checkbox"
                               type="checkbox"
                               name="responsibles[]"
                               id="responsible-<?= $u['id'] ?>"
                               value="<?= $u['id'] ?>"
                               data-department="<?= $deptId ?>">
                        <label class="form-check-label" for="responsible-<?= $u['id'] ?>">
                            <?= htmlspecialchars($u['full_name']) ?>
                        </label>
                    </div>
                </div>

                <!-- Phòng tương ứng -->
                <div class="col-md-6">
                    <div class="form-check">
                        <input class="form-check-input department-checkbox"
                               type="checkbox"
                               name="departments[]"
                               id="dept-checkbox-<?= $deptId ?>-<?= $u['id'] ?>"
                               value="<?= $deptId ?>">
                        <label class="form-check-label" for="dept-checkbox-<?= $deptId ?>-<?= $u['id'] ?>">
                            <?= htmlspecialchars($deptName) ?>
                        </label>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>


</div>



            <div class="form-group">
                <label>Thời gian bắt đầu:</label>
                <input type="date" name="start_date" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Hạn hoàn thành:</label>
                <input type="date" name="due_date" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Trạng thái:</label>
                <select name="status" class="form-control">
                    <option value="pending">Chờ xử lý</option>
                    <option value="in_progress">Đang thực hiện</option>
                    <option value="completed">Hoàn thành</option>
                </select>
            </div>
        </div>

        <!-- Cột phải -->
        <div class="col-md-6">
            <div class="form-group">
                <label>Các công việc nhỏ:</label>
                <div id="subtask-container"></div>
                <!-- <button type="button" class="btn btn-sm btn-info mt-2" onclick="addSubtask()">+ Thêm công việc nhỏ</button> -->
                <div class="form-group text-center">
                    <button type="button" class="btn btn-sm btn-info mt-3" onclick="addSubtask()">+ Thêm công việc nhỏ</button>
                </div>

            </div>
        </div>
    </div>

    <div class="form-group d-flex mt-3">
        <button type="submit" class="btn btn-primary flex-fill mr-2">Giao việc</button>
        <a href="index.php?controller=department_task&action=list" class="btn btn-default flex-fill">Hủy</a>
    </div>
</form>
            </div>
        </div>
    </div>
</section>

<!-- JS -->
<?php
$managerOptions = '<option value="">-- Chọn người --</option>';
foreach ($managerUsers as $u) {
    $managerOptions .= '<option value="' . $u['id'] . '">' . htmlspecialchars($u['full_name'], ENT_QUOTES) . '</option>';
}

$followerCheckboxesJs = '';
foreach ($allUsers as $u) {
    if ($u['role'] !== 'manager') continue;
    $id = $u['id'];
    $name = htmlspecialchars($u['full_name'], ENT_QUOTES);
    $followerCheckboxesJs .= '
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="follower-__INDEX__-' . $id . '" name="subtasks[__INDEX__][followers][]" value="' . $id . '">
            <label class="form-check-label" for="follower-__INDEX__-' . $id . '">' . $name . '</label>
        </div>';
}
?>

<script>
let subtaskIndex = 0;
const managerOptions = `<?= $managerOptions ?>`;
const followerCheckboxes = `<?= $followerCheckboxesJs ?>`;

function addSubtask() {
    const container = document.getElementById('subtask-container');
    const html = `
    <div class="border rounded p-3 mb-3 position-relative" id="subtask-${subtaskIndex}">
        <div class="form-group">
            <label>Tên công việc nhỏ:</label>
            <input type="text" name="subtasks[${subtaskIndex}][title]" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Giao cho:</label>
            <select name="subtasks[${subtaskIndex}][assignee_id]" class="form-control" required>
                ${managerOptions}
            </select>
        </div>
        <div class="form-group">
            <label>Người liên quan:</label>
            <div class="follower-checkboxes">
                ${followerCheckboxes.replaceAll('__INDEX__', subtaskIndex)}
            </div>
        </div>
        <div class="text-right mt-2">
            <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeSubtask(${subtaskIndex})">Xóa công việc nhỏ</button>
        </div>
    </div>
`;

    container.insertAdjacentHTML('beforeend', html);
    subtaskIndex++;
}

function removeSubtask(index) {
    const el = document.getElementById(`subtask-${index}`);
    if (el) el.remove();
}
</script>

<style>
.follower-checkboxes .form-check {
    margin-bottom: 6px;
    display: flex;
    align-items: center;
    gap: 6px;
}

#subtask-container > .border {
    background-color: #f8f9fa;
    box-shadow: 0 0 3px rgba(0,0,0,0.1);
}

.text-right button.btn-outline-danger {
    padding: 4px 12px;
    font-size: 13px;
}
</style>

<!-- Cập nhật thông tin phòng tương ứng -->
<?php
$usersByDepartment = [];
foreach ($managerUsers as $u) {
    $deptId = $u['department_id'] ?? 0;
    $usersByDepartment[$deptId][] = [
        'id' => $u['id'],
        'name' => htmlspecialchars($u['full_name'], ENT_QUOTES)
    ];
}
?>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const checkboxes = document.querySelectorAll('.responsible-checkbox');
    const departmentMap = {};

    // Mapping nhân viên theo phòng
    checkboxes.forEach(cb => {
        const deptId = cb.dataset.department;
        if (!departmentMap[deptId]) departmentMap[deptId] = [];
        departmentMap[deptId].push(cb);
    });

    checkboxes.forEach(cb => {
        cb.addEventListener('change', function () {
            const deptId = cb.dataset.department;

            // Tìm tất cả checkbox phòng liên quan đến phòng đó (có thể nhiều nếu nhiều nhân viên cùng phòng)
            const deptCheckboxes = document.querySelectorAll(`.department-checkbox[value="${deptId}"]`);

            if (cb.checked) {
                // Nếu tick nhân viên → tick tất cả checkbox phòng tương ứng
                deptCheckboxes.forEach(dc => dc.checked = true);
            } else {
                // Nếu bỏ tick → kiểm tra còn ai khác trong phòng đó không
                const stillChecked = departmentMap[deptId].some(c => c !== cb && c.checked);
                if (!stillChecked) {
                    deptCheckboxes.forEach(dc => dc.checked = false);
                }
            }
        });
    });
});
</script>



<style>
#department-radio-group .form-check {
    margin-right: 15px;
    margin-bottom: 8px;
}
</style>


<?php include 'views/layouts/footer.php'; ?>

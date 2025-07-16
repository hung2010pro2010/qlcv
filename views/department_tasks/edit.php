<?php include 'views/layouts/header.php'; ?>
<?php include 'views/layouts/menu_header.php'; ?>
<?php include 'views/layouts/sidebar.php'; ?>

<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>Sửa công việc liên phòng</h2>
        </div>

        <div class="card">
            <div class="body">
<form method="post">
    <input type="hidden" name="code" value="<?= htmlspecialchars($task['code']) ?>">
    <input type="hidden" id="deleted_subtasks" name="deleted_subtasks" value="">



    <div class="row">
        <!-- Cột trái -->
        <div class="col-md-6">
            <div class="form-group">
                <label>Tên công việc:</label>
                <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($task['title']) ?>" required>
            </div>

            <div class="form-group">
                <label>Mô tả công việc:</label>
                <textarea name="description" class="form-control" rows="4"><?= htmlspecialchars($task['description']) ?></textarea>
            </div>

            <div class="form-group">
                <label>Danh mục công việc:</label>
                <select name="category_id" class="form-control" required>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category['id'] ?>" <?= $task['category_id'] == $category['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($category['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

      
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Người phụ trách:</label>
                        <?php foreach ($managerUsers as $u): ?>
    <div class="form-check">
        <input class="form-check-input responsible-checkbox"
               type="checkbox"
               name="responsibles[]"
               value="<?= $u['id'] ?>"
               data-department-id="<?= $u['department_id'] ?>"
               <?= in_array($u['id'], $responsibleIds) ? 'checked' : '' ?>>
        <label class="form-check-label"><?= htmlspecialchars($u['full_name']) ?></label>
    </div>
<?php endforeach; ?>

                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mt-2">
                        <label>Phòng phụ trách:</label>
                        <div id="department-tags">
                            <?php foreach ($departments as $d): ?>
                                <div class="form-check">
                                    <input type="checkbox" 
                                           class="form-check-input" 
                                           name="departments[]" 
                                           value="<?= $d['id'] ?>"
                                           <?= in_array($d['id'], $departmentIds) ? 'checked' : '' ?>>
                                    <label class="form-check-label"><?= htmlspecialchars($d['name']) ?></label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                </div>
            </div>
     

            <div class="form-group">
                <label>Thời gian bắt đầu:</label>
                <input type="date" name="start_date" class="form-control" value="<?= date('Y-m-d', strtotime($task['start_time'])) ?>" required>
            </div>

            <div class="form-group">
                <label>Hạn hoàn thành:</label>
                <input type="date" name="due_date" class="form-control" value="<?= date('Y-m-d', strtotime($task['end_time'])) ?>" required>
            </div>

            <div class="form-group">
                <label>Trạng thái:</label>
                <select name="status" class="form-control">
                    <option value="pending" <?= $task['status'] == 'pending' ? 'selected' : '' ?>>Chờ xử lý</option>
                    <option value="in_progress" <?= $task['status'] == 'in_progress' ? 'selected' : '' ?>>Đang thực hiện</option>
                    <option value="completed" <?= $task['status'] == 'completed' ? 'selected' : '' ?>>Hoàn thành</option>
                </select>
            </div>
        </div>

        <!-- Cột phải -->
        <div class="col-md-6">
            <div class="form-group">
                <label>Các công việc nhỏ:</label>
                <div id="subtask-container">
                    <?php foreach ($subtasks as $i => $sub): ?>
                        <div class="border rounded p-2 mb-2 subtask-block">
                            <input type="hidden" name="subtasks[<?= $i ?>][id]" value="<?= $sub['id'] ?>">

                            <div class="form-group">
                                <label>Tên công việc nhỏ:</label>
                                <input type="text" name="subtasks[<?= $i ?>][title]" class="form-control" value="<?= htmlspecialchars($sub['title']) ?>" required>
                            </div>

                            <div class="form-group">
                                <label>Giao cho:</label>
                                <select name="subtasks[<?= $i ?>][assignee_id]" class="form-control" required>
                                    <option value="">-- Chọn người --</option>
                                    <?php foreach ($managerUsers as $u): ?>
                                        <option value="<?= $u['id'] ?>" <?= $sub['assignee_id'] == $u['id'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($u['full_name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Người liên quan:</label>
                                <div class="follower-checkboxes">
                                    <?php foreach ($managerUsers as $u): ?>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" 
                                                id="follower-<?= $i ?>-<?= $u['id'] ?>" 
                                                name="subtasks[<?= $i ?>][followers][]"
                                                value="<?= $u['id'] ?>"
                                                <?= in_array($u['id'], $sub['followers'] ?? []) ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="follower-<?= $i ?>-<?= $u['id'] ?>">
                                                <?= htmlspecialchars($u['full_name']) ?>
                                            </label>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                           <div class="text-right mt-2">
                                <button type="button" class="btn btn-danger btn-sm btn-delete-subtask" data-id="<?= $sub['id'] ?>">
                                    <i class="material-icons">delete</i> Xoá
                                </button>
                            </div>

                        </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" class="btn btn-sm btn-info mt-2" onclick="addSubtask()">+ Thêm công việc nhỏ</button>
            </div>
        </div>
    </div>

    <div class="form-group d-flex mt-3">
        <button type="submit" class="btn btn-primary flex-fill mr-2">Lưu thay đổi</button>
        <a href="index.php?controller=department_task&action=list" class="btn btn-default flex-fill">Hủy</a>
    </div>
</form>
            </div>
        </div>
    </div>
</section>

<script>
let subtaskIndex = <?= count($subtasks) ?>;
const deletedSubtasks = [];

const managerOptions = <?= json_encode(
    '<option value="">-- Chọn người --</option>' . implode('', array_map(function ($u) {
        return '<option value="' . $u['id'] . '">' . htmlspecialchars($u['full_name'], ENT_QUOTES) . '</option>';
    }, $managerUsers))
) ?>;

const followerCheckboxes = <?= json_encode(implode('', array_map(function ($u){
    if ($u['role'] !== 'manager') return '';
    $uid = $u['id'];
    $label = htmlspecialchars($u['full_name'], ENT_QUOTES);
    return "<div class='form-check'>
        <input class='form-check-input' type='checkbox' id='follower-__INDEX__-$uid' name='subtasks[__INDEX__][followers][]' value='$uid'>
        <label class='form-check-label' for='follower-__INDEX__-$uid'>$label</label>
    </div>";
}, $managerUsers))) ?>;

function addSubtask() {
    const container = document.getElementById('subtask-container');
    const html = `
        <div class="border rounded p-2 mb-2 subtask-block">
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
                <button type="button" class="btn btn-danger btn-sm btn-delete-subtask">
                    <i class="material-icons">delete</i> Xoá
                </button>
            </div>

        </div>
    `;
    container.insertAdjacentHTML('beforeend', html);
    subtaskIndex++;
}

document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('subtask-container').addEventListener('click', function (e) {
        if (e.target.classList.contains('btn-delete-subtask')) {
            const block = e.target.closest('.subtask-block');
            const id = e.target.dataset.id;
            if (id) {
                deletedSubtasks.push(id);
                document.getElementById('deleted_subtasks').value = deletedSubtasks.join(',');
            }
            block.remove();
        }
    });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const responsibleCheckboxes = document.querySelectorAll('.responsible-checkbox');
    const departmentCheckboxes = document.querySelectorAll('#department-tags input[type=checkbox]');

    function updateDepartmentSelection() {
        const selectedDeptIds = new Set();

        responsibleCheckboxes.forEach(cb => {
            if (cb.checked) {
                const deptId = cb.dataset.departmentId;
                if (deptId) selectedDeptIds.add(deptId);
            }
        });

        departmentCheckboxes.forEach(dept => {
            // Nếu phòng nằm trong danh sách thì bật check
            dept.checked = selectedDeptIds.has(dept.value);
        });
    }

    // Gán sự kiện khi chọn người phụ trách
    responsibleCheckboxes.forEach(cb => {
        cb.addEventListener('change', updateDepartmentSelection);
    });

    updateDepartmentSelection(); // chạy ngay lần đầu
});
</script>


<style>
    .subtask-block {
        position: relative;
        background-color: #f9f9f9;
        padding: 16px;
    }

    .btn-delete-subtask {
        transition: all 0.2s ease-in-out;
    }

    .btn-delete-subtask:hover {
        transform: scale(1.05);
    }

    .subtask-block .text-right {
        margin-top: -8px;
    }
</style>


<?php include 'views/layouts/footer.php'; ?>

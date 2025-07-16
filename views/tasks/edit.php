<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
 ?>
<?php include 'views/layouts/header.php'; ?>
<?php include 'views/layouts/menu_header.php'; ?>
<?php include 'views/layouts/sidebar.php'; ?>

<?php
$user = $_SESSION['user'] ?? null;
$isAdmin = isset($user['role']) && in_array($user['role'], ['admin', 'manager']);

$isNhanVien = isset($user['role']) && $user['role'] === 'nhanvien';
// Quyền chỉnh sửa toàn bộ
$canEditAll = $isAdmin;

// Các trường riêng cho nhân viên
$canEditResultLink = $isAdmin || $isNhanVien;
$canEditAttachment = $isAdmin || $isNhanVien;
$canEditStatus = $isAdmin || $isNhanVien;


?>

<section class="content">
    <div class="container-fluid">
            
        <div class="row clearfix">
            <div class="col-lg-10 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header bg-orange">
                        <h2 class="text-white">Cập nhật công việc</h2>
                    </div>
                    <div class="body">
                        <form method="post" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?= $task['id'] ?>">
                            <input type="hidden" name="old_attachment" value="<?= $task['attachment_path'] ?>">
                             <?php if (!$canEditAll): ?>
                            <input type="hidden" name="approval_time" id="approval_time" value="<?= $task['approval_time'] ?? '' ?>">
                            <?php endif; ?>
                            <!-- <input type="hidden" name="status_time" id="status_time" value="<?= $task['status_time'] ?? '' ?>"> -->


                            <div class="row clearfix">
                                <div class="col-sm-6">
                                    <label>Mã công việc</label>
                                    <input type="text" name="task_code" class="form-control" value="<?= $task['task_code'] ?>" <?= $canEditAll  ? '' : 'readonly' ?>>
                                </div>
                                <div class="col-sm-6">
                                    <label>Ngày tạo</label>
                                    <input type="date" class="form-control" value="<?= date('Y-m-d', strtotime($task['created_at'] ?? '')) ?>" readonly>
                                </div>

                                <div class="col-sm-6">
                                    <label>Gắn với công việc liên phòng (nếu có)</label>
                                    <select name="department_task_id" id="department_task_id" class="form-control" <?= $canEditAll ? '' : 'disabled' ?>>
                                        <option value="">-- Chọn mã công việc liên phòng --</option>
                                        <?php foreach ($relatedDepartmentTasks as $dt): ?>
                                            <option value="<?= $dt['id'] ?>" 
                                                    data-title="<?= htmlspecialchars($dt['title']) ?>"
                                                    <?= $task['department_task_id'] == $dt['id'] ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($dt['code']) ?> - <?= htmlspecialchars($dt['title']) ?>
                                            </option>

                                        <?php endforeach; ?>
                                    </select>

                                    <?php if (!$canEditAll): ?>
                                        <input type="hidden" name="department_task_id" value="<?= $task['department_task_id'] ?>">
                                    <?php endif; ?>
                                </div>

                                <div class="col-sm-6">
                                    <label>Tên công việc liên phòng</label>
                                    <input type="text" class="form-control" id="department_task_title" 
                                           value="<?= htmlspecialchars($departmentTaskTitle ?? '') ?>" readonly>
                                </div>

                                <div class="col-sm-6">
                                    <label>Dự án / Nhóm việc</label>
                                    <select id="project_group" class="form-control" <?= $canEditAll ? '' : 'disabled' ?>>
                                        <option value="">-- Chọn dự án --</option>
                                        <?php foreach ($projects as $project): ?>
                                            <option value="<?= $project['id'] ?>" <?= ($project['id'] == ($task['project_group'] ?? null)) ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($project['name']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>

                                    <!-- Hidden field để đảm bảo giá trị vẫn submit khi select bị disabled -->
                                    <?php if (!$canEditAll): ?>
                                        <input type="hidden" name="project_group" value="<?= $task['project_group'] ?>">
                                    <?php else: ?>
                                        <!-- Nếu có quyền, để select hoạt động bình thường -->
                                        <script>
                                            document.getElementById('project_group').setAttribute('name', 'project_group');
                                        </script>
                                    <?php endif; ?>
                                </div>


                               <div class="col-sm-6">
                                    <label>Hạng mục công việc</label>

                                    <select id="category" class="form-control" <?= $canEditAll ? '' : 'disabled' ?>>
                                        <option value="">-- Chọn hạng mục --</option>
                                        <?php foreach ($categories as $category): ?>
                                            <option value="<?= $category['id'] ?>" 
                                                data-project="<?= $category['project_group_id'] ?>"
                                                <?= ($category['id'] == ($task['category'] ?? null)) ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($category['name']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>

                                    <?php if (!$canEditAll): ?>
                                        <!-- Nếu không có quyền chỉnh sửa, giữ giá trị bằng hidden input -->
                                        <input type="hidden" name="category" value="<?= $task['category'] ?>">
                                    <?php else: ?>
                                        <!-- Nếu có quyền, đặt name cho select để gửi giá trị từ dropdown -->
                                        <script>
                                            document.getElementById('category').setAttribute('name', 'category');
                                        </script>
                                    <?php endif; ?>
                                </div>

                                <div class="col-sm-6">
                                    <label>Công việc chi tiết</label>
                                    <textarea name="detail" class="form-control" rows="2" <?= $canEditAll ? '' : 'readonly' ?>><?= $task['detail'] ?></textarea>
                                </div>
                                    <div class="col-sm-6">
                                    <label>Đầu vào yêu cầu</label>
                                    <textarea name="requirements" class="form-control" rows="4" <?= $canEditAll ? '' : 'readonly' ?>><?= $task['requirements'] ?></textarea>
                                </div>
                                         <!-- Mức độ ưu tiên -->
                                <div class="col-sm-6">
                                    <label>Mức độ ưu tiên</label>
                                    <select id="priority" class="form-control" <?= $canEditAll ? '' : 'disabled' ?>>
                                        <option value="1" <?= $task['priority'] == '1' ? 'selected' : '' ?>>Mức 1</option>
                                        <option value="2" <?= $task['priority'] == '2' ? 'selected' : '' ?>>Mức 2</option>
                                        <option value="3" <?= $task['priority'] == '3' ? 'selected' : '' ?>>Mức 3</option>
                                    </select>

                                    <?php if (!$canEditAll): ?>
                                        <input type="hidden" name="priority" value="<?= $task['priority'] ?>">
                                    <?php else: ?>
                                        <script>
                                            document.getElementById('priority').setAttribute('name', 'priority');
                                        </script>
                                    <?php endif; ?>
                                </div>


                               <div class="col-sm-12">
    <label>Kết quả cần đạt và link công việc</label>
</div>

<div id="result-wrapper" class="col-sm-12">
    <?php if (!empty($taskResults)): ?>
        <?php foreach ($taskResults as $index => $result): ?>
            <div class="row result-group mt-2">
                <div class="col-sm-6">
                    <label>Kết quả cần đạt</label>
                    <textarea name="description[]" class="form-control" rows="2"><?= htmlspecialchars($result['description'] ?? '') ?></textarea>
                </div>
                <div class="col-sm-6">
                    <!-- <label>Link kết quả công việc</label> -->
                    <div class="d-flex align-items-center">
                        <!-- <input type="url" name="result_link[]" class="form-control" value="<?= htmlspecialchars($result['result_link'] ?? '') ?>"> -->
                        <button type="button" <?= !$canEditAll ? 'disabled' : '' ?> class="btn btn-danger btn-sm ml-2 remove-result" title="Xóa dòng">X</button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="row result-group mt-2">
            <div class="col-sm-6">
                <label>Kết quả cần đạt</label>
                <textarea name="description[]" class="form-control" rows="2"></textarea>
            </div>
            <div class="col-sm-6">
                <!-- <label>Link kết quả công việc</label> -->
                <div class="d-flex align-items-center">
                    <!-- <input type="url" name="result_link[]" class="form-control"> -->
                    <button type="button" <?= !$canEditAll ? 'disabled' : '' ?> class="btn btn-danger btn-sm ml-2 remove-result" title="Xóa dòng">X</button>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
<div class="col-sm-12 mt-2 mb-3">
    <button type="button" class="btn btn-info" id="addResult" <?= !$canEditAll ? 'disabled' : '' ?>>
        <i class="material-icons">add</i> Thêm kết quả cần đạt
    </button>
</div>



                             
                                
                                <div class="col-sm-6">
                                    <label>Ngày bắt đầu</label>
                                    <input type="date" name="start_date" class="form-control" value="<?= $task['start_date'] ?>" <?= $canEditAll ? '' : 'readonly' ?>>
                                </div>

                                <div class="col-sm-6">
                                    <label>Ngày kết thúc</label>
                                    <input type="date" name="due_date" class="form-control" value="<?= $task['due_date'] ?>" <?= $canEditAll ? '' : 'readonly' ?>>
                                </div>
                                <!-- Người chịu trách nhiệm -->
                                <!-- Người phụ trách (chính/phụ) -->
<div class="col-sm-6">
    <label>Người chịu trách nhiệm</label><br>
    <?php foreach ($users as $user): ?>
        <div class="form-check">
            <input 
                class="form-check-input" 
                type="checkbox" 
                name="supervisors[]" 
                value="<?= $user['id'] ?>" 
                id="supervisor_<?= $user['id'] ?>"
                <?= in_array($user['id'], $supervisorIds ?? []) ? 'checked' : '' ?>
                <?= $canEditAll ? '' : 'disabled' ?>
            >
            <label class="form-check-label" for="supervisor_<?= $user['id'] ?>">
                <?= htmlspecialchars($user['full_name']) ?>
            </label>
        </div>
    <?php endforeach; ?>

    <?php if (!$canEditAll): ?>
        <?php foreach ($supervisorIds ?? [] as $id): ?>
            <input type="hidden" name="supervisors[]" value="<?= $id ?>">
        <?php endforeach; ?>
    <?php endif; ?>
</div>



                                <!-- Thành viên tham gia -->
                                <div class="col-sm-6">
                                    <label>Thành viên tham gia</label><br>
                                    <?php foreach ($users as $user): ?>
                                        <div class="form-check">
                                            <input 
                                                class="form-check-input" 
                                                type="checkbox" 
                                                name="responsible_person[]" 
                                                value="<?= $user['id'] ?>" 
                                                id="responsible_<?= $user['id'] ?>"
                                                <?= in_array($user['id'], $responsibleUserIds ?? []) ? 'checked' : '' ?>
                                                <?= $canEditAll ? '' : 'disabled' ?>
                                            >
                                            <label class="form-check-label" for="responsible_<?= $user['id'] ?>">
                                                <?= htmlspecialchars($user['full_name']) ?>
                                            </label>
                                        </div>
                                    <?php endforeach; ?>

                                    <?php if (!$canEditAll): ?>
                                        <?php foreach ($responsibleUserIds ?? [] as $uid): ?>
                                            <input type="hidden" name="responsible_person[]" value="<?= $uid ?>">
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>

                          

                                

                                <?php
                                    $approval_map = [
                                        'Giao việc' => 'Chưa nhận việc',
                                        'Phê duyệt' => 'Đã hoàn thành',
                                        'Hoãn việc' => 'Đã hoãn việc',
                                        'Hủy' => 'Đã hủy',
                                        'Điều chỉnh nội dung' => 'Đang thực hiện'
                                    ];

                                    $status_map = [
                                        'Trình duyệt' => 'Đang trình duyệt',
                                        'Tái trình duyệt' => 'Đang tái trình duyệt'
                                    ];
                                ?>

                                <div class="col-sm-6">
                                    <label>Phê duyệt</label>
                                    <select id="approval_status" name="approval_status" class="form-control" <?= $canEditAll ? '' : 'disabled' ?>>
                                        <?php
                                            $approvals = ['Giao việc', 'Phê duyệt', 'Điều chỉnh nội dung', 'Hoãn việc', 'Hủy', 'Đang trình duyệt','Đang tái trình duyệt'];
                                            foreach ($approvals as $value) {
                                                $hidden = ($value == 'Đang trình duyệt' || $value == 'Đang tái trình duyệt') && $isAdmin ? 'style="display:none;"' : '';
                                                $selected = ($task['approval_status'] == $value) ? 'selected' : '';
                                                echo "<option value=\"$value\" $selected $hidden>$value</option>";
                                            }
                                        ?>
                                    </select>
                                    <?php if (!$canEditAll): ?>
                                        <input type="hidden" name="approval_status" value="<?= $task['approval_status'] ?>">
                                    <?php endif; ?>
                                </div>

                                <div class="col-sm-6">
                                    <label>Trạng thái công việc</label>
                                    <select id="task_status" name="task_status" class="form-control" <?= $isApproved && !$isAdmin ? 'disabled' : '' ?>>
                                        <?php
                                            $statuses = ['Chưa nhận việc','Đang thực hiện', 'Trình duyệt', 'Tái trình duyệt', 'Đã hoàn thành', 'Đã hủy', 'Đã hoãn việc'];
                                            foreach ($statuses as $value) {
                                                $selected = ($task['task_status'] == $value) ? 'selected' : '';
                                                echo "<option value=\"$value\" $selected>$value</option>";
                                            }
                                        ?>
                                    </select>
                                </div>

                                <script>
                                    const approvalToStatus = {
                                        'Giao việc': 'Chưa nhận việc',
                                        'Phê duyệt': 'Đã hoàn thành',
                                        'Hoãn việc': 'Đã hoãn việc',
                                        'Hủy': 'Đã hủy',
                                        'Điều chỉnh nội dung': 'Đang thực hiện'
                                    };

                                    const statusToApproval = {
                                        'Trình duyệt': 'Đang trình duyệt',
                                        'Tái trình duyệt': 'Đang tái trình duyệt'
                                    };

                                    const approvalSelect = document.getElementById('approval_status');
                                    const statusSelect = document.getElementById('task_status');

                                    approvalSelect.addEventListener('change', function () {
                                        const selected = this.value;
                                        if (approvalToStatus[selected]) {
                                            statusSelect.value = approvalToStatus[selected];
                                        }
                                    });

                                    statusSelect.addEventListener('change', function () {
                                        const selected = this.value;
                                        if (statusToApproval[selected]) {
                                            approvalSelect.value = statusToApproval[selected];
                                        }
                                    });
                                </script>
                                
                            </div>

                            <div class="text-right mt-4">
                                <a href="index.php?controller=task&action=list" class="btn btn-secondary">
                                    <i class="material-icons">arrow_back</i> Quay lại
                                </a>
                                
                                    <button type="submit" class="btn btn-success">
                                        <i class="material-icons">save</i> Cập nhật công việc
                                    </button>
                                
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const projectSelect = document.getElementById('project_group');
    const categorySelect = document.getElementById('category');
    const approvalSelect = document.getElementById('approval_status');
    const statusSelect = document.getElementById('task_status');
    const approvalTimeInput = document.getElementById('approval_time');
    // const statusTimeInput = document.getElementById('status_time');
    const form = document.querySelector('form');

    // 🔁 Hiển thị danh sách hạng mục theo dự án, giữ lại option đã chọn
    function filterCategoriesByProject() {
        const selectedProjectId = projectSelect?.value;
        const selectedCategoryId = categorySelect?.value;
        const options = categorySelect?.querySelectorAll('option') || [];

        options.forEach(option => {
            if (!option.value) return;

            const projectMatch = option.getAttribute('data-project') === selectedProjectId;
            const isSelected = option.value === selectedCategoryId;

            // Hiển thị nếu đúng dự án hoặc là hạng mục đang chọn
            option.style.display = (projectMatch || isSelected) ? 'block' : 'none';
        });

        // Nếu hạng mục hiện tại không hợp lệ thì reset
        const isValid = [...options].some(opt => opt.value === selectedCategoryId && opt.style.display !== 'none');
        if (!isValid) categorySelect.value = '';
    }

    // 🕒 Lấy thời gian hiện tại định dạng VN
    function getCurrentDateTimeVN() {
        const now = new Date();
        now.setMinutes(now.getMinutes() + 420); // UTC+7
        const pad = n => n.toString().padStart(2, '0');
        return `${now.getFullYear()}-${pad(now.getMonth()+1)}-${pad(now.getDate())} ${pad(now.getHours())}:${pad(now.getMinutes())}:${pad(now.getSeconds())}`;
    }

    // 🔄 Cập nhật thời gian nếu chọn trạng thái/phê duyệt phù hợp
    function updateTimesIfApplicable() {
        const approval = approvalSelect?.value;
        // const status = statusSelect?.value;
        const currentTime = getCurrentDateTimeVN();

        if ((approval === "Phê duyệt" || approval === "Giao việc") && approvalTimeInput) {
            approvalTimeInput.value = currentTime;
        }

        // if ((status === "Đang thực hiện" || status === "Đã hoàn thành") && statusTimeInput) {
        //     statusTimeInput.value = currentTime;
        // }
    }

    // ➕ Thêm dòng kết quả cần đạt
    document.getElementById('addResult')?.addEventListener('click', function () {
        const wrapper = document.getElementById('result-wrapper');
        const group = document.createElement('div');
        group.className = 'row result-group mt-2';
        group.innerHTML = `
            <div class="col-sm-10">
                <label>Kết quả cần đạt</label>
                <textarea name="description[]" class="form-control" rows="2"></textarea>
            </div>
            <div class="col-sm-2">
                
                <div class="d-flex align-items-center">
                   
                    <button type="button" class="btn btn-danger btn-sm ml-2 remove-result" title="Xóa dòng">X</button>
                </div>
            </div>
        `;
        wrapper?.appendChild(group);
    });

    // ❌ Xóa dòng kết quả cần đạt
    document.getElementById('result-wrapper')?.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-result')) {
            e.target.closest('.result-group')?.remove();
        }
    });

    // Sự kiện khi phê duyệt hoặc trạng thái thay đổi
    approvalSelect?.addEventListener('change', updateTimesIfApplicable);
    statusSelect?.addEventListener('change', updateTimesIfApplicable);

    // Cập nhật thời gian trước khi submit
    form?.addEventListener('submit', updateTimesIfApplicable);

    // Gọi lọc hạng mục ban đầu
    filterCategoriesByProject();
    projectSelect?.addEventListener('change', filterCategoriesByProject);
});

// Dự án liên phòng
document.getElementById('department_task_id')?.addEventListener('change', function () {
    const selected = this.options[this.selectedIndex];
    const title = selected.getAttribute('data-title');
    document.getElementById('department_task_title').value = title || '';
});
// Khi tải trang, nếu đã chọn sẵn công việc liên phòng → hiển thị tên
document.addEventListener('DOMContentLoaded', function () {
    const select = document.getElementById('department_task_id');
    const selected = select.options[select.selectedIndex];
    const title = selected.getAttribute('data-title');
    document.getElementById('department_task_title').value = title || '';
});

</script>





<style>
    .form-control {
        background-color: #f7f7f7;
        padding-left: 5px !important;
        padding: 0px !important;
    }
    button.btn.dropdown-toggle.btn-default {
        display: none;
    }
</style>

<?php include 'views/layouts/footer.php'; ?>

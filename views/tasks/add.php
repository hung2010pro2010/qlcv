<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
 ?>
<?php include 'views/layouts/header.php'; ?>
<?php include 'views/layouts/menu_header.php'; ?>
<?php include 'views/layouts/sidebar.php'; ?>


<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-10 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header bg-cyan">
                        <h2 class="text-white">Khởi tạo công việc</h2>
                    </div>
                    <div class="body">
                        <form method="post" enctype="multipart/form-data">
                            <div class="row clearfix">
                                <div class="col-sm-6">
                                    <label>Mã công việc</label>
                                    <!-- <input type="text" name="code" class="form-control" required> -->
                                    <input type="text" name="code" class="form-control" value="<?= htmlspecialchars($autoCode ?? '') ?>" readonly>

                                </div>
                                <div class="col-sm-6">
                                    <label>Ngày tạo</label>
                                    <input type="date" name="created_at" class="form-control" value="<?= date('Y-m-d') ?>" readonly>
                                </div>

                              <div class="col-sm-6">
                                <label>Gắn với công việc liên phòng (nếu có)</label>
                                <select name="department_task_id" id="department_task_id" class="form-control">
                                    <option value="">-- Chọn mã công việc liên phòng --</option>
                                    <?php foreach ($relatedDepartmentTasks as $task): ?>
                                        <option value="<?= $task['id'] ?>" data-title="<?= htmlspecialchars($task['title']) ?>">
                                            <?= htmlspecialchars($task['code']) ?> - <?= htmlspecialchars($task['title']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-sm-6">
                                <label>Tên công việc liên phòng</label>
                                <input type="text" class="form-control" id="department_task_title" readonly>
                            </div>


                                <div class="col-sm-6">
                                    <label>Dự án / Nhóm việc</label>
                                    <select name="project_group_id" id="project_group" class="form-control" required>
                                        <option value="">-- Chọn dự án --</option>
                                        <?php foreach ($projects as $project): ?>
                                            <option value="<?= $project['id'] ?>"><?= htmlspecialchars($project['name']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                         
                                <div class="col-sm-6">
                                    <label>Hạng mục công việc</label>
                                    <div class="d-flex align-items-center">
                                        <select name="task_category_id" id="category" class="form-control" required style="flex: 1;">
                                            <option value="">-- Chọn hạng mục --</option>
                                            <?php foreach ($categories as $category): ?>
                                                <option value="<?= $category['id'] ?>" data-project="<?= $category['project_group_id'] ?>">
                                                    <?= htmlspecialchars($category['name']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <button type="button" class="btn btn-secondary ml-2" data-toggle="modal" data-target="#addCategoryModal">+</button>
                                    </div>
                                </div>


                                <div class="col-sm-6">
                                    <label>Công việc chi tiết</label>
                                    <textarea name="title" class="form-control" rows="2" required></textarea>
                                </div>
                                
                                <div class="col-sm-6">
                                    <label>Mức độ ưu tiên</label>
                                    <select name="priority" class="form-control">
                                        <option value="1">Mức 1</option>
                                        <option value="2">Mức 2</option>
                                        <option value="3">Mức 3</option>
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <label>Đầu vào yêu cầu</label>
                                    <textarea name="requirements" class="form-control" rows="2"></textarea>
                                </div>
                              <div id="result-wrapper">
                                <div class="row result-group">
                                    <div class="col-sm-6">
                                        <label>Kết quả cần đạt</label>
                                        <textarea name="description[]" class="form-control" rows="2"></textarea>
                                    </div>
                                    <!-- <div class="col-sm-6">
                                        <label>Link kết quả công việc</label>
                                        <input type="url" name="result_link[]" class="form-control">
                                    </div> -->
                                </div>
                            </div>
                            <div class="col-sm-12 mt-2 mb-3">
                                <button type="button" class="btn btn-info" id="addResult">
                                    <i class="material-icons">add</i> Thêm kết quả cần đạt
                                </button>
                            </div>



                                
                                 

                                <div class="col-sm-6">
                                   
                                    <label>Người phụ trách (chính/phụ)</label><br>
                                    <?php foreach ($users as $user): ?>
                                        <div class="form-check">
                                            <input 
                                                class="form-check-input" 
                                                type="checkbox" 
                                                name="supervisors[]" 
                                                value="<?= $user['id'] ?>" 
                                                id="supervisor_<?= $user['id'] ?>"
                                            >
                                            <label class="form-check-label" for="supervisor_<?= $user['id'] ?>">
                                                <?= htmlspecialchars($user['full_name']) ?>
                                            </label>
                                        </div>
                                    <?php endforeach; ?>

                                </div>

                              <div class="col-sm-6">
                                <label>Thành viên tham gia</label><br>
                                <?php foreach ($users as $user): ?>
                                    <div class="form-check">
                                        <input 
                                            class="form-check-input" 
                                            type="checkbox" 
                                            name="responsible_person[]" 
                                            value="<?= $user['id'] ?>" 
                                            id="user_<?= $user['id'] ?>"
                                        >
                                        <label class="form-check-label" for="user_<?= $user['id'] ?>">
                                            <?= htmlspecialchars($user['full_name']) ?>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                          
                         

                                

                                <div class="col-sm-6">
                                    <label>Ngày bắt đầu</label>
                                    <input type="date" name="start_date" class="form-control">
                                </div>
                                <div class="col-sm-6">
                                    <label>Ngày kết thúc</label>
                                    <input type="date" name="due_date" class="form-control">
                                </div>

                                <div class="col-sm-6">
                                    <label>Phê duyệt</label>
                                    <select name="approval" class="form-control">
                                        <option value="Giao việc">Giao việc</option>
                                        <option value="Điều chỉnh nội dung">Điều chỉnh nội dung</option>
                                        <option value="Đã duyệt">Đã duyệt</option>
                                        <option value="Hoãn việc">Hoãn việc</option>
                                        <option value="Đã hủy">Đã hủy</option>
                                    </select>
                                    <input type="hidden" name="approval_time" id="approval_time" value="<?= date('Y-m-d H:i:s') ?>">
                                </div>
                                
                                <div class="col-sm-6">
                                    <label>Trạng thái công việc</label>
                                    <select name="status" class="form-control">
                                        <option value="Chưa nhận việc">Chưa nhận việc</option>
                                        <option value="Đã nhận việc">Đã nhận việc</option>
                                        <option value="Đang thực hiện">Đang thực hiện</option>
                                        <option value="Tái trình duyệt">Tái trình duyệt</option>
                                        <option value="Đã hoàn thành">Đã hoàn thành</option>
                                        <option value="Đã hủy">Đã hủy</option>
                                    </select>
                                    <input type="hidden" name="status_time" id="status_time" value="<?= date('Y-m-d H:i:s') ?>">
                                </div>
                                

                            </div>

                            <div class="text-right mt-4">
                                <a href="index.php?controller=task&action=list" class="btn btn-secondary">
                                    <i class="material-icons">arrow_back</i> Quay lại
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="material-icons">add</i> Thêm công việc
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Modal thêm hạng mục -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form id="addCategoryForm">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Thêm Hạng mục mới</h5>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
              <div class="form-group">
                  <label>Tên hạng mục</label>
                  <input type="text" class="form-control" name="name" required>
              </div>
              <div class="form-group">
                  <label>Thuộc nhóm dự án</label>
                  <select class="form-control" name="project_group_id" required>
                      <?php foreach ($projects as $project): ?>
                          <option value="<?= $project['id'] ?>"><?= htmlspecialchars($project['name']) ?></option>
                      <?php endforeach; ?>
                  </select>
              </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Lưu</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
          </div>
        </div>
    </form>
  </div>
</div>

<script>
document.getElementById('project_group').addEventListener('change', function () {
    var selectedProjectId = this.value;
    var categorySelect = document.getElementById('category');
    var options = categorySelect.querySelectorAll('option');

    options.forEach(function (opt) {
        if (!opt.value) return; // giữ option đầu tiên
        opt.style.display = (opt.getAttribute('data-project') === selectedProjectId) ? 'block' : 'none';
    });

    categorySelect.value = '';
});


function updateTimesIfApplicable() {
    const approval = document.querySelector('select[name="approval"]').value;
    const status = document.querySelector('select[name="status"]').value;

    if (approval === "Giao việc" && status === "Đang thực hiện") {
        const currentTime = new Date().toISOString().slice(0,19).replace('T', ' ');
        document.getElementById('approval_time').value = currentTime;
        document.getElementById('status_time').value = currentTime;
    }
}

document.querySelector('select[name="approval"]').addEventListener('change', updateTimesIfApplicable);
document.querySelector('select[name="status"]').addEventListener('change', updateTimesIfApplicable);

// Thêm option
document.getElementById('addResult').addEventListener('click', function () {
    const wrapper = document.getElementById('result-wrapper');

    const group = document.createElement('div');
    group.className = 'row result-group mt-3';

    group.innerHTML = `
        <div class="col-sm-6">
            <label>Kết quả cần đạt</label>
            <textarea name="description[]" class="form-control" rows="2"></textarea>
        </div>
        
    `;

    wrapper.appendChild(group);
});

// Bổ sung công việc liên phòng
// Khi chọn mã công việc liên phòng → hiển thị tên công việc
document.getElementById('department_task_id').addEventListener('change', function () {
    const selected = this.options[this.selectedIndex];
    const title = selected.getAttribute('data-title');
    document.getElementById('department_task_title').value = title || '';
});


</script>

<style type="text/css">
button.btn.dropdown-toggle.btn-default {
    display: none;
}
.form-control {
    background-color: #f7f7f7;
    padding-left: 5px !important;
    padding: 0px !important;
}
</style>

<?php include 'views/layouts/footer.php'; ?>

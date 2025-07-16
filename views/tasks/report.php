<?php include 'views/layouts/header.php'; ?>
<?php include 'views/layouts/menu_header.php'; ?>
<?php include 'views/layouts/sidebar.php'; ?>

<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-8 col-md-10 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header bg-orange">
                        <h2 class="text-white">BÁO CÁO CÔNG VIỆC</h2>
                    </div>
                    <div class="body">
                        <form action="index.php?controller=task&action=submitReport&id=<?= (int)$task['id'] ?>" method="post">
                            <!-- Tên công việc -->
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="form-control" name="taskName" value="<?= htmlspecialchars($task['detail']) ?>" readonly>
                                    <label class="form-label">Tên công việc</label>
                                </div>
                            </div>
                                  <!-- Trạng thái -->
                            <div class="form-group">
                                <label>Trạng thái báo cáo</label>
                                <div class="form-line">
                                    <select class="form-control show-tick" name="status" required>
                                        <option value="Đang thực hiện">Đang thực hiện</option>
                                        <option value="Trình duyệt">Trình duyệt</option>
                                        <option value="Tái trình duyệt">Tái trình duyệt</option>
                                    </select>
                                </div>
                            </div>
                            <!-- Nội dung báo cáo -->
                        <!-- Nội dung báo cáo + link -->
                    <div class="form-group">
                        <div class="form-line">
                            <textarea rows="5" class="form-control no-resize" name="content"></textarea>
                            <label class="form-label">Nội dung và/hoặc Link báo cáo</label>
                        </div>
                    </div>

                      

                            <!-- Nút hành động -->
                            <div class="form-group">
                                <button class="btn bg-orange waves-effect" type="submit">
                                    <i class="material-icons">send</i> XÁC NHẬN 
                                </button>
                                <a href="index.php?controller=task&action=list" class="btn btn-default waves-effect">
                                    QUAY LẠI DANH SÁCH
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.querySelector('form').addEventListener('submit', function(e) {
    const submitBtn = this.querySelector('button[type="submit"]');
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="material-icons">hourglass_top</i> ĐANG GỬI...';
});
</script>

<?php include 'views/layouts/footer.php'; ?>

<?php include 'views/layouts/header.php'; ?>
<?php include 'views/layouts/menu_header.php'; ?>
<?php include 'views/layouts/sidebar.php'; ?>

<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>Chỉnh sửa báo cáo: <?= htmlspecialchars($report['title']) ?></h2>
        </div>

        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header bg-deep-orange">
                        <h2 class="text-white">Sửa nội dung báo cáo</h2>
                    </div>
                    <div class="body">
                        <form method="POST" action="index.php?controller=task&action=editReport&id=<?= (int)$report['id'] ?>">
                            <label><strong>Tiêu đề báo cáo</strong></label>
                            <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($report['title']) ?>" required>

                            <label class="mt-2"><strong>Đường dẫn kết quả</strong></label>
                            <input type="url" name="link" class="form-control" value="<?= htmlspecialchars($report['result_link']) ?>">

                            <label class="mt-2"><strong>Nội dung báo cáo</strong></label>
                            <textarea name="content" class="form-control" rows="4" required><?= htmlspecialchars($report['content']) ?></textarea>

                            <label class="mt-2"><strong>Trạng thái</strong></label>
                            <select name="status" class="form-control" required>
                                <?php foreach (['Đang thực hiện', 'Trình duyệt', 'Tái trình duyệt'] as $statusOpt): ?>
                                    <option value="<?= $statusOpt ?>" <?= $report['status'] == $statusOpt ? 'selected' : '' ?>>
                                        <?= $statusOpt ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>

                            <button type="submit" class="btn bg-orange mt-3">
                                <i class="material-icons">save</i> Cập nhật báo cáo
                            </button>

                            <a href="index.php?controller=task&action=report&id=<?= $report['task_id'] ?>" class="btn bg-grey mt-3">
                                <i class="material-icons">arrow_back</i> Quay lại
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'views/layouts/footer.php'; ?>

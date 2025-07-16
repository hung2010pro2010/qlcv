<?php include 'views/layouts/header.php'; ?>
<?php include 'views/layouts/menu_header.php'; ?>
<?php include 'views/layouts/sidebar.php'; ?>

<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>Sửa báo cáo công việc nhỏ</h2>
        </div>

        <div class="card">
            <div class="body">
                <?php if (!empty($report)): ?>
                   <form method="post" action="index.php?controller=department_task&action=update_subtask_report" enctype="multipart/form-data">
    <input type="hidden" name="report_id" value="<?= $report['id'] ?>">
    <input type="hidden" name="task_id" value="<?= $taskId ?>">

    <div class="form-group">
        <label>Nội dung báo cáo</label>
        <textarea name="report_content" class="form-control" rows="4" required><?= htmlspecialchars($report['content']) ?></textarea>
    </div>

    <div class="form-group">
        <label>File đính kèm (nếu muốn thay)</label>
        <?php if (!empty($report['attachment'])): ?>
            <p>File hiện tại: <a href="<?= htmlspecialchars($report['attachment']) ?>" target="_blank">Tải xuống</a></p>
        <?php endif; ?>
        <input type="file" name="attachment" class="form-control" accept=".pdf,.doc,.docx,.jpg,.png,.zip">
    </div>

    <button type="submit" class="btn btn-primary">Cập nhật</button>
    <a href="javascript:history.back()" class="btn btn-default">Hủy</a>
</form>

                <?php else: ?>
                    <div class="alert alert-danger">Không tìm thấy báo cáo cần sửa.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php include 'views/layouts/footer.php'; ?>

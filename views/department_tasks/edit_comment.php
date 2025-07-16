<?php include 'views/layouts/header.php'; ?>
<?php include 'views/layouts/menu_header.php'; ?>
<?php include 'views/layouts/sidebar.php'; ?>

<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>Sửa bình luận</h2>
        </div>

        <div class="card">
            <div class="body">
                <?php if (!empty($comment)): ?>
                    <form method="post" action="index.php?controller=department_task&action=update_comment">
    <input type="hidden" name="id" value="<?= htmlspecialchars($comment['id']) ?>">
    <input type="hidden" name="task_id" value="<?= htmlspecialchars($_GET['task_id']) ?>">

    <div class="form-group">
        <label for="content">Nội dung bình luận</label>
        <textarea name="content" class="form-control" rows="3" required><?= htmlspecialchars($comment['content']) ?></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Cập nhật</button>
    <a href="index.php?controller=department_task&action=view&id=<?= htmlspecialchars($_GET['task_id']) ?>" class="btn btn-default">Hủy</a>
</form>

                <?php else: ?>
                    <div class="alert alert-danger">Không tìm thấy bình luận để sửa.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php include 'views/layouts/footer.php'; ?>

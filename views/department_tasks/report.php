<?php include 'views/layouts/header.php'; ?>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>Báo cáo công việc: <?= htmlspecialchars($task['title']) ?></h2>
        </div>

        <div class="card">
            <div class="body">
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger"><?= $error ?></div>
                <?php endif; ?>
                <form method="post">
                    <div class="form-group">
                        <label>Nội dung báo cáo:</label>
                        <textarea name="content" class="form-control" rows="6" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Gửi báo cáo</button>
                    <a href="index.php?controller=department_task&action=view&id=<?= $task['id'] ?>" class="btn btn-default">Hủy</a>
                </form>
            </div>
        </div>
    </div>
</section>
<?php include 'views/layouts/footer.php'; ?>

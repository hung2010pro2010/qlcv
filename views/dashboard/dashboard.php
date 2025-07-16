<?php include 'views/layouts/header.php'; ?>
<?php include 'views/layouts/menu_header.php'; ?>
<?php include 'views/layouts/sidebar.php'; ?>

<section class="content">
    <div class="container-fluid">

        <!-- TAB CHUYỂN VIEW -->
        <ul class="nav nav-tabs" style="margin-bottom: 20px;">
            <li class="<?= ($_GET['view'] ?? 'list') === 'list' ? 'active' : '' ?>">
                <a href="index.php?controller=dashboard&action=index&view=list">Danh sách</a>
            </li>
            <li class="<?= ($_GET['view'] ?? '') === 'kanban' ? 'active' : '' ?>">
                <a href="index.php?controller=dashboard&action=index&view=kanban">Kanban</a>
            </li>
            <li class="<?= ($_GET['view'] ?? '') === 'gantt' ? 'active' : '' ?>">
                <a href="index.php?controller=dashboard&action=index&view=gantt">Gantt</a>
            </li>
        </ul>

        <!-- FORM LỌC CÔNG VIỆC -->
        <form method="GET" class="row clearfix" style="margin-bottom: 25px; background: #f5f5f5; padding: 15px; border-radius: 8px;">
            <input type="hidden" name="controller" value="dashboard">
            <input type="hidden" name="action" value="index">
            <input type="hidden" name="view" value="<?= htmlspecialchars($_GET['view'] ?? 'list') ?>">

            <div class="col-md-3">
                <label><strong>Tên công việc</strong></label>
                <input type="text" name="keyword" class="form-control" placeholder="Nhập tên..." value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>">
            </div>

            <div class="col-md-3">
                <label><strong>Trạng thái</strong></label>
                <select name="status" class="form-control">
                    <option value="">-- Tất cả --</option>
                    <?php foreach (array_keys($statusCount) as $status): ?>
                        <option value="<?= $status ?>" <?= (($_GET['status'] ?? '') === $status) ? 'selected' : '' ?>>
                            <?= $status ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-2">
                <label><strong>Từ ngày</strong></label>
                <input type="date" name="from_date" class="form-control" value="<?= htmlspecialchars($_GET['from_date'] ?? '') ?>">
            </div>

            <div class="col-md-2">
                <label><strong>Đến ngày</strong></label>
                <input type="date" name="to_date" class="form-control" value="<?= htmlspecialchars($_GET['to_date'] ?? '') ?>">
            </div>

            <div class="col-md-2" style="margin-top: 25px;">
                <button type="submit" class="btn btn-primary waves-effect"><i class="material-icons">search</i> Lọc</button>
                <a href="index.php?controller=dashboard&action=index" class="btn btn-default waves-effect" style="margin-left: 5px;"><i class="material-icons">clear</i></a>
            </div>
        </form>

        <!-- GỌI VIEW PHÙ HỢP -->
        <?php
        $view = $_GET['view'] ?? 'list';
        switch ($view) {
            case 'kanban': include 'views/dashboard/kanban.php'; break;
            case 'gantt': include 'views/dashboard/gantt.php'; break;
            default: include 'views/dashboard/list.php'; break;
        }
        ?>

    </div>
</section>

<?php include 'views/layouts/footer.php'; ?>
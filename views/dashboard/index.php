<?php include 'views/layouts/header.php'; ?>
<?php include 'views/layouts/menu_header.php'; ?>
<?php include 'views/layouts/sidebar.php'; ?>

<section class="content">
    <div class="container-fluid">

        <!-- TAB CHUYỂN VIEW -->
        <ul class="nav nav-tabs custom-tabs m-b-20" role="tablist" style="border-bottom: 2px solid #e0e0e0;">
            <li role="presentation" class="<?= ($_GET['view'] ?? 'list') === 'list' ? 'active' : '' ?>">
                <a href="index.php?controller=dashboard&action=index&view=list">
                    <i class="material-icons">list</i> DANH SÁCH
                </a>
            </li>
            <li role="presentation" class="<?= ($_GET['view'] ?? '') === 'kanban' ? 'active' : '' ?>">
                <a href="index.php?controller=dashboard&action=index&view=kanban">
                    <i class="material-icons">view_column</i> KANBAN
                </a>
            </li>
            <li role="presentation" class="<?= ($_GET['view'] ?? '') === 'gantt' ? 'active' : '' ?>">
                <a href="index.php?controller=dashboard&action=index&view=gantt">
                    <i class="material-icons">timeline</i> GANTT
                </a>
            </li>
        </ul>

        <!-- FORM LỌC CÔNG VIỆC -->
         <div class="card">
        <!--     <div class="header bg-blue">
                <h2>
                    <i class="material-icons">filter_list</i> LỌC CÔNG VIỆC
                </h2>
            </div> -->
            <div class="body">
                <form method="GET" class="row clearfix">
                    <input type="hidden" name="controller" value="dashboard">
                    <input type="hidden" name="action" value="index">
                    <input type="hidden" name="view" value="<?= htmlspecialchars($_GET['view'] ?? 'list') ?>">

                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="form-line">
                                <label>Người phụ trách</label>
                                <select name="responsible_person" class="form-control show-tick">
                                    <option value="">-- Tất cả --</option>
                                    <?php foreach ($userList as $user): ?>
                                        <option value="<?= $user['id'] ?>" <?= (($_GET['responsible_person'] ?? '') == $user['id']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($user['full_name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="form-line">
                                <label>Trạng thái</label>
                                <select name="status" class="form-control show-tick">
                                    <option value="">-- Tất cả --</option>
                                    <?php foreach (array_keys($statusCount) as $status): ?>
                                        <option value="<?= $status ?>" <?= (($_GET['status'] ?? '') === $status) ? 'selected' : '' ?>>
                                            <?= $status ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="form-line">
                                <label>Từ ngày</label>
                                <input type="date" name="from_date" class="form-control" value="<?= htmlspecialchars($_GET['from_date'] ?? '') ?>">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="form-line">
                                <label>Đến ngày</label>
                                <input type="date" name="to_date" class="form-control" value="<?= htmlspecialchars($_GET['to_date'] ?? '') ?>">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2 text-right" style="margin-top: 25px;">
                        <button type="submit" class="btn bg-blue waves-effect">
                            <i class="material-icons">search</i> Tìm kiếm
                        </button>
                        <a href="index.php?controller=dashboard&action=index" class="btn bg-grey waves-effect">
                            <i class="material-icons">clear</i>
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- NỘI DUNG VIEW TƯƠNG ỨNG -->
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
<style>
    .form-group{
        margin-bottom: 0px !important;
    }
</style>
<?php include 'views/layouts/footer.php'; ?>

<?php
$projectGroups = $projectGroups ?? [];

require_once 'models/User.php';
$userModel = new User($this->db);
$allUsers = $userModel->getAll();

require_once 'models/DepartmentTaskCategory.php';
$categoryModel = new DepartmentTaskCategory($db);
$departmentTaskCategories = $categoryModel->getAll();

$currentController = $_GET['controller'] ?? '';
$currentAction = $_GET['action'] ?? '';
$currentStatus = $_GET['status'] ?? '';
?>
<section>
    <!-- Left Sidebar -->
    <aside id="leftsidebar" class="sidebar">
        <!-- User Info -->
        <div class="user-info">
            <div class="info-container">
                <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?= isset($_SESSION['user']['full_name']) ? htmlspecialchars($_SESSION['user']['full_name']) : 'Người dùng' ?>
                </div>
                <div class="email">
                    <?= isset($_SESSION['user']['email']) ? htmlspecialchars($_SESSION['user']['email']) : '' ?>
                </div>
            </div>
        </div>

        <!-- Menu -->
        <div class="menu">
            <ul class="list">
                <li class="<?= ($currentController === 'dashboard') ? 'active' : '' ?>">
                    <a href="index.php?controller=dashboard&action=index">
                        <i class="material-icons">dashboard</i>
                        <span>DASHBOARD</span>
                    </a>
                </li>

         

                <!-- DỰ ÁN LIÊN PHÒNG -->
                <?php if (isset($_SESSION['user']) && in_array($_SESSION['user']['role'], ['admin', 'manager'])): ?>
                   <li class="<?= ($currentController === 'department_task') ? 'active' : '' ?>">
                        <a href="javascript:void(0);" class="menu-toggle waves-effect">
                            <i class="material-icons">apartment</i><span>DỰ ÁN LIÊN PHÒNG</span>
                        </a>

                        <ul class="ml-menu custom-submenu" style="<?= $currentController === 'department_task' ? 'display:block;' : '' ?>">

                            <!-- ◼︎ danh mục -->
                            <?php foreach ($departmentTaskCategories as $cat): ?>
                                <li class="submenu-item <?= ($_GET['category_id'] ?? '') == $cat['id'] ? 'active' : '' ?>">
                                    <a href="index.php?controller=department_task&action=list&category_id=<?= $cat['id'] ?>">
                                        <i class="material-icons tiny">label</i>
                                        <span><?= htmlspecialchars($cat['name']) ?></span>
                                    </a>
                                </li>
                            <?php endforeach; ?>

                        

                            <!-- ■■■ PHÂN CÁCH ■■■ -->
                            <li class="separator"></li>

                            <!-- 3 trạng thái -->
                            <li class="<?= empty($_GET['status']) && empty($_GET['category_id']) ? 'active' : '' ?>">
                                <a href="index.php?controller=department_task&action=list">
                                    <i class="material-icons tiny">view_list</i> <span>Tất cả công việc</span>
                                </a>
                            </li>
                            <li class="<?= ($_GET['status'] ?? '') === 'doing' ? 'active' : '' ?>">
                                <a href="index.php?controller=department_task&action=list&status=doing">
                                    <i class="material-icons tiny">timelapse</i> <span>Đang làm</span>
                                </a>
                            </li>
                            <li class="<?= ($_GET['status'] ?? '') === 'completed' ? 'active' : '' ?>">
                                <a href="index.php?controller=department_task&action=list&status=completed">
                                    <i class="material-icons tiny">check_circle</i> <span>Hoàn thành</span>
                                </a>
                            </li>
                        </ul>
                    </li>


                <?php endif; ?>

                <!-- DỰ ÁN - NHIỆM VỤ -->
               <li class="<?= $currentController === 'task' ? 'active' : '' ?>">
                    <a href="javascript:void(0);" class="menu-toggle waves-effect">
                        <i class="material-icons">folder_open</i><span>DỰ ÁN - NHIỆM VỤ</span>
                    </a>

                    <ul class="ml-menu custom-submenu" style="<?= $currentController === 'task' ? 'display:block;' : '' ?>">

                        <!-- ◼︎ danh sách nhóm -->
                        <?php foreach ($projectGroups as $group): ?>
                            <li class="submenu-item <?= ($_GET['group_id'] ?? '') == $group['id'] ? 'active' : '' ?>">
                                <a href="index.php?controller=task&action=listByGroup&group_id=<?= $group['id'] ?>">
                                    <i class="material-icons tiny">folder</i>
                                    <span class="group-name"><?= htmlspecialchars($group['name']) ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>

                        <!-- ■■■ PHÂN CÁCH ■■■ -->
                        <li class="separator"></li>

                        <!-- 3 trạng thái -->
                        <li class="<?= empty($_GET['status']) ? 'active' : '' ?>">
                            <a href="index.php?controller=task&action=list&status=all">
                                <i class="material-icons tiny">view_list</i><span>Tất cả công việc</span>
                            </a>
                        </li>
                        <li class="<?= ($_GET['status'] ?? '') === 'list' ? 'active' : '' ?>">
                              <a href="index.php?controller=task&action=list">
                                <i class="material-icons tiny">timelapse</i><span>Đang làm</span>
                            </a>
                        </li>
                        <li class="<?= ($_GET['status'] ?? '') === 'Đã hoàn thành' ? 'active' : '' ?>">
                           <a href="index.php?controller=task&action=list&status=Đã hoàn thành">
                                <i class="material-icons tiny">check_circle</i><span>Hoàn thành</span>
                            </a>
                        </li>
                    </ul>
                </li>



                <!-- QUẢN TRỊ -->
                    <!-- ◼︎ Quản lý danh mục (chỉ admin) -->
                        <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                            <li class="submenu-item <?= $currentController === 'department_task_category' ? 'active' : '' ?>">
                                <a href="index.php?controller=department_task_category&action=list">
                                    <i class="material-icons tiny">settings</i><span>Quản lý danh mục Liên phòng</span>
                                </a>
                            </li>
                        <?php endif; ?>

                <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'): ?>
                    <li class="<?= ($currentController === 'project_groups') ? 'active' : '' ?>">
                        <a href="index.php?controller=project_groups&action=list">
                            <i class="material-icons">business</i>
                            <span>QUẢN LÝ DỰ ÁN - NHIỆM VỤ</span>
                        </a>
                    </li>
                    <li class="<?= ($currentController === 'category') ? 'active' : '' ?>">
                        <a href="index.php?controller=category&action=list">
                            <i class="material-icons">view_list</i>
                            <span>QUẢN LÝ HẠNG MỤC CÔNG VIỆC</span>
                        </a>
                    </li>

                    <li class="header">CHỌN NGƯỜI DÙNG</li>
                    <li class="luachon" style="background: #f7f7f7;">
                        <div class="input-group" style="display: flex; align-items: center; padding: 0 15px 10px;">
                            <select id="userSelect" class="form-control show-tick" style="flex: 1; height: 30px; font-size: 13px;">
                                <option value="">-- Chọn người dùng --</option>
                                <?php foreach ($allUsers as $user): ?>
                                    <option value="index.php?controller=task&action=listByUser&user_id=<?= $user['id'] ?>"
                                        <?= (isset($_GET['user_id']) && $_GET['user_id'] == $user['id']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($user['full_name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
        <!-- #Menu -->

        <!-- Footer -->
        <div class="legal">
            <div class="copyright">
                &copy; 2025 <a href="javascript:void(0);">DK Pharma</a>.
            </div>
            <div class="version">
                <b>Version:</b> 1.0
            </div>
        </div>
    </aside>
</section>

<script>
document.getElementById('userSelect').addEventListener('change', function () {
    const url = this.value;
    if (url) {
        window.location.href = url;
    }
});
</script>



</ul>



            </div>
            <!-- #Menu -->
            <!-- Footer -->
            <div class="legal">
                <div class="copyright">
                    &copy; 2025 <a href="javascript:void(0);">DK Pharma</a>.
                </div>
                <div class="version">
                    <b>Version: </b> 1.0
                </div>
            </div>
            <!-- #Footer -->
        </aside>
        <!-- #END# Left Sidebar -->
        <!-- Right Sidebar -->
        <aside id="rightsidebar" class="right-sidebar">
            <ul class="nav nav-tabs tab-nav-right" role="tablist">
                <li role="presentation" class="active"><a href="#skins" data-toggle="tab">SKINS</a></li>
                <li role="presentation"><a href="#settings" data-toggle="tab">SETTINGS</a></li>
            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade in active in active" id="skins">
                    <ul class="demo-choose-skin">
                        <li data-theme="red" class="active">
                            <div class="red"></div>
                            <span>Red</span>
                        </li>
                        <li data-theme="pink">
                            <div class="pink"></div>
                            <span>Pink</span>
                        </li>
                        <li data-theme="purple">
                            <div class="purple"></div>
                            <span>Purple</span>
                        </li>
                        <li data-theme="deep-purple">
                            <div class="deep-purple"></div>
                            <span>Deep Purple</span>
                        </li>
                        <li data-theme="indigo">
                            <div class="indigo"></div>
                            <span>Indigo</span>
                        </li>
                        <li data-theme="blue">
                            <div class="blue"></div>
                            <span>Blue</span>
                        </li>
                        <li data-theme="light-blue">
                            <div class="light-blue"></div>
                            <span>Light Blue</span>
                        </li>
                        <li data-theme="cyan">
                            <div class="cyan"></div>
                            <span>Cyan</span>
                        </li>
                        <li data-theme="teal">
                            <div class="teal"></div>
                            <span>Teal</span>
                        </li>
                        <li data-theme="green">
                            <div class="green"></div>
                            <span>Green</span>
                        </li>
                        <li data-theme="light-green">
                            <div class="light-green"></div>
                            <span>Light Green</span>
                        </li>
                        <li data-theme="lime">
                            <div class="lime"></div>
                            <span>Lime</span>
                        </li>
                        <li data-theme="yellow">
                            <div class="yellow"></div>
                            <span>Yellow</span>
                        </li>
                        <li data-theme="amber">
                            <div class="amber"></div>
                            <span>Amber</span>
                        </li>
                        <li data-theme="orange">
                            <div class="orange"></div>
                            <span>Orange</span>
                        </li>
                        <li data-theme="deep-orange">
                            <div class="deep-orange"></div>
                            <span>Deep Orange</span>
                        </li>
                        <li data-theme="brown">
                            <div class="brown"></div>
                            <span>Brown</span>
                        </li>
                        <li data-theme="grey">
                            <div class="grey"></div>
                            <span>Grey</span>
                        </li>
                        <li data-theme="blue-grey">
                            <div class="blue-grey"></div>
                            <span>Blue Grey</span>
                        </li>
                        <li data-theme="black">
                            <div class="black"></div>
                            <span>Black</span>
                        </li>
                    </ul>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="settings">
                    <div class="demo-settings">
                        <p>GENERAL SETTINGS</p>
                        <ul class="setting-list">
                            <li>
                                <span>Report Panel Usage</span>
                                <div class="switch">
                                    <label><input type="checkbox" checked><span class="lever"></span></label>
                                </div>
                            </li>
                            <li>
                                <span>Email Redirect</span>
                                <div class="switch">
                                    <label><input type="checkbox"><span class="lever"></span></label>
                                </div>
                            </li>
                        </ul>
                        <p>SYSTEM SETTINGS</p>
                        <ul class="setting-list">
                            <li>
                                <span>Notifications</span>
                                <div class="switch">
                                    <label><input type="checkbox" checked><span class="lever"></span></label>
                                </div>
                            </li>
                            <li>
                                <span>Auto Updates</span>
                                <div class="switch">
                                    <label><input type="checkbox" checked><span class="lever"></span></label>
                                </div>
                            </li>
                        </ul>
                        <p>ACCOUNT SETTINGS</p>
                        <ul class="setting-list">
                            <li>
                                <span>Offline</span>
                                <div class="switch">
                                    <label><input type="checkbox"><span class="lever"></span></label>
                                </div>
                            </li>
                            <li>
                                <span>Location Permission</span>
                                <div class="switch">
                                    <label><input type="checkbox" checked><span class="lever"></span></label>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </aside>
        <!-- #END# Right Sidebar -->
    </section>

<style>
/* Menu cha “DỰ ÁN NHÓM” */
.menu-toggle.group-header {
    background-color: #fce4ec;
    font-weight: bold;
    padding: 10px 16px;
    color: #d81b60;
    border-radius: 4px;
    margin: 4px 0;
}

/* Bỏ thụt đầu dòng submenu */
.custom-submenu, .ml-menu {
    margin-left: 0 !important;
    padding-left: 0 !important;
}

/* Submenu item */
.custom-submenu .submenu-item a {
    /*display: flex;*/
    justify-content: space-between;
    align-items: center;
    padding: 8px 16px;
    margin: 2px 0;
    font-size: 14px;
    color: #333;
    border-radius: 6px;
    transition: all 0.2s ease;
    background-color: transparent;
}

/* Hover effect */
.custom-submenu .submenu-item a:hover {
    background-color: #e3f2fd;
    color: #1565c0;
}

/* Active submenu item */
.custom-submenu .submenu-item.active a {
    background-color: #2196F3;
    color: white;
    font-weight: 600;
}

/* Tên nhóm */
.group-name {
    display: inline-block;
    max-width: 180px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

/* Badge số lượng */
.badge-custom {
    background-color: #4CAF50;
    color: #fff;
    font-size: 12px;
    font-weight: 600;
    padding: 3px 8px;
    border-radius: 20px;
    line-height: 1;
    min-width: 26px;
    text-align: center;
}
.sidebar .menu .list .ml-menu li.active a.toggled:not(.menu-toggle):before{
    color: red;
}
.sidebar .menu .list a{
    display: inline-flex;
    justify-content:flex-start;
}
li.active {
    background: #e5e5e5 !important;
}

/* Header "DỰ ÁN LIÊN PHÒNG" */
.sidebar .menu .list .header {
    background-color: #f3f3f3;
    font-weight: bold;
    color: #555;
    padding: 8px 16px;
    text-transform: uppercase;
}

/* Mục danh sách liên phòng */
.sidebar .menu .list li a span {
    font-size: 13px;
}
/* Submenu liên phòng */
.ml-menu.custom-submenu li a {
    padding-left: 32px !important;
}

/* icon mini */
.material-icons.tiny { font-size:16px; margin-right:6px; }

/* dải phân cách */
.separator {
    border-top:1px solid #e0e0e0;
    margin:6px 0;
    height:0;
    list-style:none;
}

/* submenu item padding đẹp hơn */
.custom-submenu li a {
    padding:8px 20px !important;
}

/* active màu xanh */
.custom-submenu li.active > a {
    background:#2196f3; color:#fff; font-weight:600;
}

</style>

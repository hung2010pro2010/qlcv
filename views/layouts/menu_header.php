
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once 'models/Notification.php';

$notifications = [];

if (!empty($_SESSION['user']['id'])) {
    $db = (new DB())->connect();
    $notificationModel = new Notification($db);
    $notifications = $notificationModel->getAllByUser($_SESSION['user']['id'], 5); // Giới hạn số lượng
}
?>


 <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="preloader">
                <div class="spinner-layer pl-red">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
            <p>Please wait...</p>
        </div>
    </div>
    <!-- #END# Page Loader -->
    <div class="overlay"></div>
    <!-- Search Bar -->
    <div class="search-bar">
        <div class="search-icon"> 
            <i class="material-icons">search</i>
        </div>
        <input type="text" placeholder="START TYPING...">
        <div class="close-search">
            <i class="material-icons">close</i>
        </div>
    </div>
    <!-- #END# Search Bar -->
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
                <a href="javascript:void(0);" class="bars"></a>
                <a class="navbar-brand" href="#">DK PHARMA</a>
            </div>
            
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <!-- Call Search -->
                    <li><a href="javascript:void(0);" class="js-search" data-close="true"><i class="material-icons">search</i></a></li>
                    <!-- #END# Call Search -->
                    <!-- Notifications -->
                    <li class="dropdown">
                       <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" onclick="markNotificationsRead()">

                            <i class="material-icons">notifications</i>
                            <?php
                            $notificationModel = new Notification($db);
                            $unreadCount = $notificationModel->countUnread($_SESSION['user']['id']);
                            ?>
                            <span class="label-count"><?= $unreadCount ?></span>


                        </a>
                        <ul class="dropdown-menu">
                        <li class="header">THÔNG BÁO MỚI NHẤT</li>
                        <li class="body">
                            <ul class="menu">
                                <?php if (!empty($notifications)): ?>
                                    <?php foreach ($notifications as $n): ?>
                                        <li>
                                            <a href="javascript:void(0);">
                                                <div class="icon-circle <?= htmlspecialchars($n['color']) ?>">
                                                    <i class="material-icons"><?= htmlspecialchars($n['icon']) ?></i>
                                                </div>
                                                <div class="menu-info">
                                                    <h4><?= htmlspecialchars($n['message']) ?></h4>
                                                    <p>
                                                        <i class="material-icons">access_time</i>
                                                        <?= date('H:i d/m/Y', strtotime($n['created_at'])) ?>
                                                    </p>
                                                </div>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <li><a><em>Không có thông báo nào</em></a></li>
                                <?php endif; ?>
                            </ul>
                        </li>
                        <li class="footer"><a href="index.php?controller=notification&action=list">Xem tất cả</a></li>
                    </ul>

                    </li>

                    <!-- #END# Notifications -->
                    <!-- Tasks -->
                     
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">
                            <i class="material-icons">people</i>
                            
                        </a>
                       
                        <ul class="dropdown-menu">
                            <li class="header">SETTING</li>
                            <li class="body"> 
                                 <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'): ?>
                                <ul class="menu tasks">                                                                 
                                      

                                        <li class="<?= ($currentController === 'user' && $currentAction === 'list') ? 'active' : '' ?>">
                                            <a href="index.php?controller=user&action=list">
                                                <i class="material-icons">people</i>
                                                <span>Quản lý người dùng</span>
                                            </a>
                                        </li>
                                        <!-- ✅ Mục mới: Quản lý phòng ban -->
                                        <li class="<?= ($currentController === 'department' && $currentAction === 'list') ? 'active' : '' ?>">
                                            <a href="index.php?controller=department&action=list">
                                                <i class="material-icons">account_balance</i>
                                                <span>Quản lý phòng ban</span>
                                            </a>
                                        </li>
                                    
                                </ul>
                                  <?php endif; ?>
                            </li>
                            <li><a href="index.php?controller=user&action=changePassword"><i class="material-icons">vpn_key</i><span>Đổi mật khẩu</span></a></li>
                            <li class="<?= ($currentController === 'user' && $currentAction === 'logout') ? 'active' : '' ?>">
                                <a href="index.php?controller=user&action=logout" onclick="return confirm('Bạn có chắc chắn muốn đăng xuất không?');">
                                    <i class="material-icons">exit_to_app</i>
                                    <span>Đăng xuất</span>
                                </a>
                            </li>
                     
                    

            
              

                        </ul>
                    </li>
                   
                    <!-- #END# Tasks -->
                    <li class="pull-right"><a href="javascript:void(0);" class="js-right-sidebar" data-close="true"><i class="material-icons">more_vert</i></a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Thông báo -->
<script>
function markNotificationsRead() {
    fetch('index.php?controller=notification&action=markRead');
}
</script>

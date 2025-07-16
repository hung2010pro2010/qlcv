<?php
session_start();

require_once 'config/db.php';

// Load controllers
require_once 'controllers/UserController.php';
require_once 'controllers/TaskController.php';
require_once 'controllers/CategoryController.php';
require_once 'controllers/ProjectGroupController.php';
require_once 'controllers/BaseController.php';
require_once 'controllers/NotificationController.php';
require_once 'controllers/DashboardController.php';
require_once 'controllers/DepartmentController.php';
require_once 'controllers/DepartmentTaskController.php';
require_once 'controllers/DepartmentTaskCategoryController.php';
require_once 'helpers/DepartmentTaskStatus.php';


// Load models if needed directly
require_once 'models/DepartmentTaskCategory.php';

// Get controller and action from URL
$controller = $_GET['controller'] ?? 'user';
$action = $_GET['action'] ?? 'login';

// DB connection
$db = (new DB())->connect();

// Load project groups for sidebar if needed
$projectGroupModel = new ProjectGroup($db);
$projectGroups = $projectGroupModel->getAll();

switch ($controller) {
    case 'user':
        $ctrl = new UserController($db);
        break;
    case 'task':
        $ctrl = new TaskController($db);
        break;
    case 'category':
        $ctrl = new CategoryController($db);
        break;
    case 'project_groups':
        $ctrl = new ProjectGroupController($db);
        break;
    case 'notification':
        $ctrl = new NotificationController($db);
        break;
    case 'dashboard':
        $ctrl = new DashboardController($db);
        break;
    case 'department':
        $ctrl = new DepartmentController($db);
        break;
    case 'department_task':
        $ctrl = new DepartmentTaskController($db);
        break;
    case 'department_task_category':
        $ctrl = new DepartmentTaskCategoryController($db);
        break;
    default:
        echo "Controller '$controller' không tồn tại.";
        exit;
}

// Gọi phương thức tương ứng nếu có
if (method_exists($ctrl, $action)) {
    $ctrl->$action();
} else {
    echo "Action '$action' không tồn tại trong controller '$controller'.";
}
?>

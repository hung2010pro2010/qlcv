<?php
// controllers/BaseController.php

require_once 'models/ProjectGroup.php';

class BaseController
{
    protected $db;
    protected $sharedData = [];

    public function __construct($db)
    {
        $this->db = $db;
        $this->loadSharedData();
    }

    protected function loadSharedData()
    {
        // Lấy danh sách nhóm dự án dùng chung trong menu sidebar
        $projectGroupModel = new ProjectGroup($this->db);
        $this->sharedData['projectGroups'] = $projectGroupModel->getAll();
    }

    protected function render($view, $data = [])
    {
        // Gộp dữ liệu chung và dữ liệu riêng view
        extract(array_merge($this->sharedData, $data));
        require_once "views/layouts/layout.php";
    }
}

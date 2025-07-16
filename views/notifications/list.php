<h2>Thông báo của bạn</h2>
<ul>
    <?php foreach ($notifications as $notify): ?>
        <li>
            <i class="material-icons"><?= htmlspecialchars($notify['icon']) ?></i>
            <span style="color: <?= htmlspecialchars($notify['color']) ?>"><?= htmlspecialchars($notify['message']) ?></span>
            <a href="index.php?controller=notification&action=delete&id=<?= $notify['id'] ?>" onclick="return confirm('Xóa thông báo này?')">Xoá</a>
        </li>
    <?php endforeach; ?>
</ul>

<a href="index.php?controller=notification&action=deleteAll" onclick="return confirm('Xoá tất cả thông báo?')">🗑 Xoá tất cả</a>

<ul class='breadcrumb'>
    <li><a href="/manage/index.php">Manage Ships</a></li>
    <?php foreach ($breadcrumbItems as $item): ?>
    <li>
        <a href="<?php echo $item['url']; ?>">
            <?php echo $item['name']; ?>
        </a>
    </li>
    <?php endforeach; ?>
</ul>

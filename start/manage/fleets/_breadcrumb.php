<ul class='breadcrumb'>
    <li><a href="/manage/fleets/index.php">Manage Fleets</a></li>
    <?php foreach ($breadcrumbItems as $item): ?>
    <li>
        <a href="<?php echo $item['url']; ?>">
            <?php echo $item['name']; ?>
        </a>
    </li>
    <?php endforeach; ?>
</ul>

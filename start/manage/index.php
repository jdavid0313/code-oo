<?php
require 'header.php';

use Service\Container;

$container = new Container($configuration);
$shipLoader = $container->getShipLoader();
$ships = $shipLoader->getShips();

?>

<div class="row">
    <?php foreach ($ships as $ship): ?>
    <div class="col-sm-6">
        <h2>
            <a
                href="/manage/show.php?id=<?php echo $ship->getId();?>">
                <?php echo $ship->getName();?>
            </a>
        </h2>

        <?php if ($ship->getImage()) { ?>
        <img src="/images/<?php echo $ship->getImage(); ?>"
            class="img-thumbnail">
        <?php } else { ?>
        <h4> Image Not Available </h4>
        <?php } ?>

    </div>
    <?php endforeach;?>
</div>

<?php require 'footer.php';

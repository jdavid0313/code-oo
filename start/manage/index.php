<?php
require 'header.php';

use Service\Container;

$container = new Container($configuration);
$shipLoader = $container->getShipLoader();
$ships = $shipLoader->getShips();

?>

<div class="container">
    <div class="row">
        <?php foreach ($ships as $ship): ?>
            <div class="col-sm-6">
                <h2><a href="show.php?id=<?php echo $ship->getId();?>"><?php echo $ship->getName();?></a></h2>

                <img src="/images/<?php echo $ship->getImage(); ?>" class="img-thumbnail">

                

            </div>
        <?php endforeach;?>
    </div>
</div>    

<?php require 'footer.php'; ?>

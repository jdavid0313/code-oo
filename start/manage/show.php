<?php 
require 'header.php';
$id = $_GET['id'];

use Service\Container;

$container = new Container($configuration);

$shipLoader = $container->getShipLoader();

$ship = $shipLoader->findOneById($id);

//var_dump($ship);die;
?>

<div class="container">
    <h2> <?php echo $ship->getName(); ?>  </h2>

    <ul>
        <li>Ship Weapon Power: <?php echo $ship->getWeaponPower(); ?></li>
        <li>Ship Jedi Factor: <?php echo $ship->getJediFactor(); ?></li>
        <li>Ship Strength: <?php echo $ship->getstrength(); ?></li>
        <li>Ship Team: <?php echo $ship->getType();?></li>

        <li>
            Ship Details: <?php echo $ship->getDescription();?>
        </li>
    </ul>
</div>


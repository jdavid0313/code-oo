<?php
require '../ships/header.php';
$id = isset($_GET['id']) ? $_GET['id'] : null;

use Service\Container;

$container = new Container($configuration);
$fleetLoader = $container->getFleetLoader();
$fleetShips = $fleetLoader->getSingleFleetById($id);

if ($fleetShips === null):
    echo '<h1>Fleet Not Available</h1>';
else:

?>
<h1><?php ?></h1>
<table class="table">
    <thead>
        <tr>
            <th>Ship</th>
            <th>Quantity</th>
            <th>Options</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($fleetShips as $fleetShip):?>
        <tr>
            <td><?php echo $fleetShip->getShipName();?></td>
            <td><?php echo $fleetShip->getQuantity();?></td>
            <td>
                <a href="#" class="btn btn-success">Update</a>
                <a href="#" class="btn btn-danger">Delete</a>
            </td>
        </tr>
    <?php endforeach;?>
</table>
<?php endif;?>
<?php require '../ships/footer.php';?>

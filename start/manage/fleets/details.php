<?php
require '../ships/header.php';
$id = isset($_GET['id']) ? $_GET['id'] : null;

use Service\Container;

$container = new Container($configuration);
$fleetLoader = $container->getFleetLoader();
$fleetShips = $fleetLoader->getSingleFleetById($id);

if ($fleetShips === null):
    $breadcrumbItems = [];
    include '_breadcrumb.php';
    echo '<h1>Fleet Not Available</h1>';
else:

foreach ($fleetShips as $fleetShipName => $fleetShips):
    $breadcrumbItems = [
        [
            'url'=>'/manage/fleets/details.php?id='.$id,
            'name'=> $fleetShipName. ' Fleet'
        ]
    ];

    include '_breadcrumb.php';
?>
<h1><?php echo $fleetShipName;?> Fleet</h1>

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
                <a href="/manage/fleets/edit.php?shipId=<?php echo $fleetShip->getShipId();?>&fleetId=<?php echo $fleetShip->getId();?>" class="btn btn-success btn-sm">Edit</a>
                <a href="/manage/fleets/removeShip.php?shipId=<?php echo $fleetShip->getShipId();?>&fleetId=<?php echo $fleetShip->getId();?>" class="btn btn-danger btn-sm">Remove</a>
            </td>
        </tr>
    <?php endforeach;?>
</table>
<?php endforeach;?>

<div class='text-center'>
    <a href="/manage/fleets/update.php?id=<?php echo $fleetShip->getId();?>" class="btn btn-success">Add Ship</a>
    <a href="/manage/fleets/delete.php?id=<?php echo $fleetShip->getId();?>" class="btn btn-danger">Delete Fleet</a>
</div>

<?php endif;?>
<?php require '../ships/footer.php';?>

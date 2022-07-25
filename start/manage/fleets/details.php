<?php
require '../ships/header.php';
$id = isset($_GET['id']) ? $_GET['id'] : null;
$team = isset($_GET['team']) ? $_GET['team'] : null;

use Service\Container;

$container = new Container($configuration);
$fleetLoader = $container->getFleetLoader();
$shipLoader = $container->getShipLoader();
$ships = $shipLoader->findShipByTeam($team);
$fleet = $fleetLoader->getFleetById($id);

if ($fleet === null):
    $breadcrumbItems = [];
    include '_breadcrumb.php';
    echo '<h1>Fleet Not Available</h1>';
else:
    $breadcrumbItems = [
        [
            'url'=>'/manage/fleets/details.php?id='.$fleet->getId().'&team='.$fleet->getTeam(),
            'name'=> $fleet->getName(). ' Fleet'
        ]
    ];

    include '_breadcrumb.php';
?>
<h1><?php echo $fleet->getName();?> Fleet</h1>

<table class="table">
    <thead>
        <tr>
            <th>Ship</th>
            <th>Quantity</th>
            <th>Options</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($fleet->getShipFleets() as $ship):?>
        <tr>
            <td><?php echo $ship->getShip()->getName();?></td>
            <td><?php echo $ship->getQuantity();?></td>
            <td>
                <a href="/manage/fleets/edit.php?shipId=<?php echo $ship->getShip()->getId();?>&fleetId=<?php echo $fleet->getId()?>" class="btn btn-success btn-sm">Edit</a>
                <a href="/manage/fleets/removeShip.php?shipId=<?php echo $ship->getShip()->getId();?>&fleetId=<?php echo $fleet->getId();?>" class="btn btn-danger btn-sm">Remove</a>
            </td>
        </tr>
    <?php endforeach;?>
</table>

<div class='text-center'>
    <?php if (count($ships) != count($fleet->getShipFleets())):?>
        <a href="/manage/fleets/addShip.php?id=<?php echo $fleet->getId();?>&team=<?php echo $fleet->getTeam();?>" class="btn btn-success">Add Ship</a>
    <?php else:?>
        <button class='btn btn-success' disabled>Add Ship</button>
    <?php endif;?>
    <a href="/manage/fleets/delete.php?id=<?php echo $fleet->getId();?>" class="btn btn-danger">Delete Fleet</a>
</div>

<?php endif;?>
<?php require '../ships/footer.php';?>

<?php
require '../ships/header.php';
use Service\Container;

$container = new Container($configuration);

$fleetLoader = $container->getFleetLoader();
$fleets = $fleetLoader->getFleets();
?>

<div class="row">
    <div class="col-sm-6">
        <h2 class='text-center'>Rebel Fleets</h2>
        <?php foreach ($fleets['rebel'] as $fleet): ?>
        <h1>
            <a
                href='/manage/fleets/details.php?id=<?php echo $fleet->getId();?>'>
                <?php echo $fleet->getName();?>: <?php echo $fleet->getQuantity();?>
            </a>
        </h1>
        <?php endforeach;?>
    </div>
    <div class='col-sm-6'>
        <h2 class='text-center'>Empire Fleets</h2>
        <table class="table table-dark">
            <thead>
                <tr>
                    <th>Fleet</th>
                    <th>Quantity</th>
                    <th>Options</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($fleets['empire'] as $fleet):?>
                <tr>
                    <td><?php echo $fleet->getName();?>
                    <td><?php echo $fleet->getQuantity();?>
                    <td><a href="#" class="btn btn-success btn-small">Update</a>
                </tr>
                <?php endforeach;?>
            </tbody>
        </table>
    </div>
</div>

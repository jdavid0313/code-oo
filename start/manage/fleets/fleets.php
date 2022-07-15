<?php
require '../ships/header.php';
use Service\Container;

$container = new Container($configuration);

$fleetLoader = $container->getFleetLoader();
$fleets = $fleetLoader->getFleets();


//var_dump($fleets);die;
?>

<div class="row">
    <div class="col-sm-6">
        <h2 class='text-center'>Rebel Fleets</h2>
        <?php foreach ($fleets as $fleet):?>
        <?php if ($fleet->getTeam() == 'rebel'):?>
        <h1>
            <a
                href='/manage/fleets/details.php?id=<?php echo $fleet->getId();?>'>
                <?php echo $fleet->getName();?>: <?php echo $fleet->getQuantity();?>
            </a>
        </h1>
        <?php endif;?>
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
                <?php foreach ($fleets as $fleet):?>
                <?php if ($fleet->getTeam() == 'empire'):?>
                <tr>
                    <td><?php echo $fleet->getName();?>
                    <td><?php echo $fleet->getQuantity();?>
                    <td><a href="#" class="btn btn-success btn-small">Update</a>
                </tr>
                <?php endif;?>
                <?php endforeach;?>
            </tbody>
        </table>
    </div>
</div>

<?php
require '../ships/header.php';
use Service\Container;

$container = new Container($configuration);

$fleetLoader = $container->getFleetLoader();
$fleetsByTeam = $fleetLoader->getFleetsByTeam();
?>
<div class="navbar-right">
    <a class="btn btn-primary" type="button" href="/manage/fleets/addFleet.php">Add Fleet</a>
</div>
<br><br>

<div class="row">
    <?php foreach ($fleetsByTeam as $team => $fleets): ?>
    <div class="col-md-6">
        <h2 class='text-center'><?php echo ucfirst($team); ?> Fleets
        </h2>
        <table class="table table-dark">
            <thead>
                <tr>
                    <th>Fleet</th>
                    <th>Quantity</th>
                    <th>Options</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($fleets as $fleet): ?>
                <tr>
                    <td><?php echo $fleet->getName();?>
                    <td><?php echo $fleet->getQuantity();?>
                    <td><a href="/manage/fleets/details.php?id=<?php echo $fleet->getId();?>&team=<?php echo $fleet->getTeam();?>" class="btn btn-primary btn-small">Details</a>
                </tr>
                <?php endforeach;?>
            </tbody>
        </table>
    </div>
    <?php endforeach; ?>
</div>

<?php require '../ships/footer.php';?>

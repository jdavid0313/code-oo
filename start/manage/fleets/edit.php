<?php
require '../ships/header.php';
$shipId = isset($_GET['shipId']) ? $_GET['shipId'] : null;
$fleetId = isset($_GET['fleetId']) ? $_GET['fleetId'] : null;
$errors = [];

use Service\Container;

$container = new Container($configuration);
$fleetLoader = $container->getFleetLoader();
$fleetShip = $fleetLoader->getFleetShipByIds($shipId, $fleetId);

if ($fleetShip === null):
    $breadcrumbItems = [];
    include '_breadcrumb.php';
    echo '<h1>Fleet Not Available</h1>';
else:

$breadcrumbItems = [
    [
        'url'=>'/manage/fleets/details.php?id='.$fleetShip->getFleet()->getId().'&team='.$fleetShip->getFleet()->getTeam(),
        'name'=> $fleetShip->getFleet()->getName(). ' Fleet',
    ],
    [
        'url'=>'#',
        'name'=>'Edit'
    ]
];

include '_breadcrumb.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $fleetShip->setQuantity(trim($_POST['quantity']));

    if (empty($fleetShip->getQuantity())) {
        $errors[] = 'Please enter quantity';
    }  elseif (is_numeric($fleetShip->getQuantity()) === false || ($fleetShip->getQuantity() < 0)) {
        $errors[] = "Invalid quantity entered";
    }

    if (empty($errors)){
        $fleetStorage = $container->getFleetStorage();
        $fleetStorage->updateShipInFLeet($fleetShip);

        header('Location: /manage/fleets/details.php?id='.$fleetShip->getFleet()->getId().'&team='.$fleetShip->getFleet()->getTeam());
        return;
    }
}
?>
<h1>Edit</h1>

<div class='row'>
    <div class="col-lg-3">
        <ul class="list-group">
            <?php foreach ($errors as $errmessage):  ?>
            <li class="list-group-item list-group-item-danger"><?php echo $errmessage ?>
            </li>
            <?php endforeach;  ?>
        </ul>
    </div>
</div>

<form method='POST' action='/manage/fleets/edit.php?shipId=<?php echo $fleetShip->getShip()->getId();?>&fleetId=<?php echo $fleetShip->getFleet()->getId();?>'>
    <label for='quantity'>Quantity</label>
    <input class='form-control' type='number' id='quantity' name='quantity' value='<?php echo $fleetShip->getQuantity();?>'/>
    <br>
    <div class='text-center'>
        <button type="submit" class="btn btn-success">Submit</button>
    </div>
</form>

<?php endif;?>
<?php require '../ships/footer.php';?>

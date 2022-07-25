<?php
require '../ships/header.php';
use Service\Container;
use Model\AbstractShip;
use Model\Fleet;
use Model\ShipFleet;
$errors = [];

$container = new Container($configuration);
$shipLoader = $container->getShipLoader();
$ships = $shipLoader->getShips();

$breadcrumbItems = [
    [
        'url' => '#',
        'name' => 'Add Fleet',
    ],
];

include '_breadcrumb.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $fleet = new Fleet(trim($_POST['name']));
    $fleet->setTeam(trim($_POST['team']));

    $fleetShip = new ShipFleet();
    $fleetShip->setFleet($fleet);
    foreach ($ships as $ship):
        $fleetShip->setShip($ship);
    endforeach;

    if (isset($_POST['ships'])):
        $fleetShip->getShip()->setId($_POST['ships']);
    else:
        $errors[] = 'Please select a ship';
    endif;

    if (empty($fleetShip->getFleet()->getName())) {
        $errors[] = 'Pleae enter name';
    }

    if (empty($errors)) {
        $fleetStorage = $container->getFleetStorage();
        $fleetStorage->addFleet($fleetShip);

        header('Location: /manage/fleets/fleets.php');
        return;
    }
}
?>
<div class='row'>
    <div class="col-lg-3">
        <ul class="list-group">
            <?php foreach ($errors as $errmessage): ?>
            <li class="list-group-item list-group-item-danger"><?php echo $errmessage ?>
            </li>
            <?php endforeach;  ?>
        </ul>
    </div>
</div>

<form action='/manage/fleets/addFleet.php' method='POST'>
    <div>
        <label for='name'>Name:</label>
        <input class='form-control' type='text' id='name' name='name'/>
    </div>
    <div>
        <label for='team'>Team:</label>
        <select name="team" id="team" class="form-control">
            <?php foreach (AbstractShip::validTypes() as $type):?>
                <option value="<?php echo $type; ?>">
                    <?php echo $type; ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <br>
    <div class='form-check'>
        <label for='ships'>Select Ships:</label><br>
        <?php foreach ($ships as $ship):?>
            <input class="form-check-input" type="checkbox" value="<?php echo $ship->getId();?>" name='ships[]' id="ship">
            <label class="form-check-label" for="ship"><?php echo $ship->getName();?></label>
        <?php endforeach;?>
    </div>
    <br>
    <div class='text-center'>
        <button type="submit" class="btn btn-success">Submit</button>
    </div>
</form>

<?php require '../ships/footer.php'?>

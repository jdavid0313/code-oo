<?php
require '../ships/header.php';
use Service\Container;
use Model\AbstractShip;
use Model\Fleet;
use Model\ShipFleet;
$errors = [];

$container = new Container($configuration);

$breadcrumbItems = [
    [
        'url' => '#',
        'name' => 'Add Fleet',
    ],
];

include '_breadcrumb.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $fleet = new Fleet();
    $fleet->setName(trim($_POST['name']));
    $fleet->setTeam(trim($_POST['team']));

    if (empty($fleet->getName())) {
        $errors[] = 'Pleae enter name';
    }

    if (empty($errors)) {
        $fleetStorage = $container->getFleetStorage();
        $fleetStorage->addFleet($fleet);

        header('Location: /manage/fleets/details.php?id='.$fleet->getId());
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

<form action='/manage/fleets/add.php' method='POST'>
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
    <div class='text-center'>
        <button type="submit" class="btn btn-success">Submit</button>
    </div>
</form>

<?php require '../ships/footer.php'?>

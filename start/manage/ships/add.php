<?php

use Model\AbstractShip;
use Model\RebelShip;
use Model\Ship;
use Service\Container;
use Service\ErrorHandling;

require 'header.php';

$errors = [];

// handle submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // check for valid team
    if (in_array($_POST['team'], AbstractShip::validTypes()) === false) {
        $errors[] = 'Invalid team';
    }

    if ($_POST['team'] == 'Rebel') {
        $ship = new RebelShip($_POST['shipName']);
    } else {
        $ship = new Ship($_POST['shipName']);
    }

    $ship->setWeaponPower($_POST['weaponPower']);
    $ship->setJediFactor($_POST['jediFactor']);
    $ship->setStrength($_POST['strength']);
    $ship->setDescription($_POST['description']);

    $errors = ErrorHandling::errorCheckShip($ship);

    if (empty($errors)) {
        // persist to db
        $container = new Container($configuration);
        $shipStorage = $container->getShipStorage();
        $shipStorage->addShip($ship);

        header('Location: /manage/ships/index.php');
        return;
    }
}


$breadcrumbItems = [
    [
        'url' => '#',
        'name' => 'Add Ship',
    ],
];

include '_breadcrumb.php';

?>

<?php if (! empty($errors)): ?>
<div class='row'>
    <div class="col-lg-3">
        <ul class="list-group">
            <?php foreach ($errors as $error):  ?>
            <li class="list-group-item list-group-item-danger">
                <?php echo $error ?>
            </li>
            <?php endforeach;  ?>
        </ul>
    </div>
</div>
<?php endif; ?>

<div class='row'>
    <div class="col-lg-12">
        <form action="/manage/ships/add.php" method="POST">
            <div>
                <label for="shipName">Ship Name:</label><br>
                <input class="form-control" type="text" name="shipName" id="shipName" />
            </div>
            <div>
                <label for="team">Team:</label>
                <select name="team" id="team" class="form-control">
                    <?php foreach (AbstractShip::validTypes() as $type): ?>
                    <option value="<?php echo $type; ?>">
                        <?php echo $type; ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label for="weaponPower">Weapon Power:</label>
                <input class="form-control" type="text" name="weaponPower" id="weaponPower" />
            </div>
            <div>
                <label for="jediFactor">Jedi Factor:</label>
                <input class="form-control" type="text" name="jediFactor" id="jediFactor" />
            </div>
            <div>
                <label for="strength">Strength:</label>
                <input class="form-control" type="text" name="strength" id="strength" />
            </div>
            <div>
                <label for="team">Ship Description:</label>
                <textarea class="form-control" name="description" id="description"></textarea>
            </div>
            <br>
            <div class='text-center'>
                <button type="submit" class="btn btn-success">Submit</button>
            </div>
        </form>
    </div>
</div>

<?php require 'footer.php';

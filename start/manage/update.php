<?php
require 'header.php';
use Service\Container;

$id = isset($_GET['id']) ? $_GET['id'] : null;
$errors = [];

$container = new Container($configuration);

$shipLoader = $container->getShipLoader();

$ship = $shipLoader->findOneById($id);

if ($ship === null):
    $breadcrumbItems = [];
    include '_breadcrumb.php';
    echo '<h1>Ship Not Available</h1>';
else:

$breadcrumbItems = [
    [
        'url' => '/manage/show.php?id='.$ship->getId(),
        'name' => $ship->getName(),
    ],
    [
        'url' => '#',
        'name' => 'Edit',
    ],
];
include '_breadcrumb.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ship->setName($_POST['shipName']);
    $ship->setWeaponPower($_POST['weaponPower']);
    $ship->setJediFactor($_POST['jediFactor']);
    $ship->setStrength($_POST['strength']);
    $ship->setDescription($_POST['description']);

    if (empty(trim($ship->getName()))) {
        $errors[] = "Please enter ship name";
    }

    if (empty(trim($ship->getWeaponPower()))) {
        $errors[] = "Please enter weapon power";
    } elseif (is_numeric($ship->getWeaponPower()) === false || ($ship->getWeaponPower() < 0)) {
        $errors[] = "Invalid weapon power entered";
    }

    if (empty(trim($ship->getJediFactor()))) {
        $errors[] = "Please enter Jedi Factor";
    } elseif (is_numeric($ship->getJediFactor()) === false || ($ship->getJediFactor() < 0)) {
        $errors[] = "Invalid jedi factor entered";
    }

    if (empty(trim($ship->getStrength()))) {
        $errors[] = "Please enter ship strength";
    } elseif (is_numeric($ship->getStrength()) === false || ($ship->getStrength() < 0)) {
        $errors[] = "Invalid strength entered";
    }

    if (empty(trim($ship->getDescription()))) {
        $errors[] = "Please enter ship description";
    }

    if (empty($errors)) {
        $shipStorage = $container->getShipStorage();
        $shipStorage->updateShip($ship);

        header('Location: /manage/show.php?id='.$ship->getId());
    }
}
?>
<h2>Update <?php echo $ship->getName();?> Ship Details:</h2>

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

<div class='row'>
    <div class="col-lg-12">
        <form action="update.php?id=<?php echo $ship->getId();?>"
            method="POST">
            <div>
                <label for="shipName">Ship Name:</label><br>
                <input class="form-control" type="text" name="shipName" id="shipName"
                    value="<?php echo $ship->getName();  ?>" />
            </div>
            <div>
                <label for="weaponPower">Weapon Power:</label>
                <input class="form-control" type="text" name="weaponPower" id="weaponPower"
                    value="<?php echo $ship->getWeaponPower(); ?>" />
            </div>
            <div>
                <label for="jediFactor">Jedi Factor:</label>
                <input class="form-control" type="text" name="jediFactor" id="jediFactor"
                    value="<?php echo $ship->getJediFactor(); ?>" />
            </div>
            <div>
                <label for="strength">Strength:</label>
                <input class="form-control" type="text" name="strength" id="strength"
                    value="<?php echo $ship->getStrength(); ?>" />
            </div>
            <div>
                <label for="team">Ship Description:</label>
                <textarea class="form-control" name="description"
                    id="description"><?php echo $ship->getDescription();  ?></textarea>
            </div>
            <br>
            <div class='text-center'>
                <button type="submit" class="btn btn-success">Submit</button>
            </div>
        </form>
    </div>
</div>

<?php endif;  ?>
<?php require 'footer.php';

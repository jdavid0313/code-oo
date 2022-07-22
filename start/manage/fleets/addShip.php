<?php
require '../ships/header.php';
$id = isset($_GET['id']) ? $_GET['id'] : null;
$team = isset($_GET['team']) ? $_GET['team'] : null;
$errors = [];

use Service\Container;
use Model\Fleet;

$container = new Container($configuration);

$fleetLoader = $container->getFleetLoader();
$shipLoader = $container->getShipLoader();
$fleetShips = $fleetLoader->getSingleFleetById($id);
$ships = $shipLoader->findShipByTeam($team);

if ($fleetShips === null):
    $breadcrumbItems = [];
    include '_breadcrumb.php';
    echo '<h1>Fleet Not Available</h1>';
else:

    foreach ($fleetShips as $fleetName => $fleetShips):
        $breadcrumbItems = [
            [
                'url'=>'/manage/fleets/details.php?id='.$id.'&team='.$team,
                'name'=> $fleetName. ' Fleet'
            ],
            [
                'url'=>'#',
                'name'=>'Add to fleet',
            ]
        ];

        include '_breadcrumb.php';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $fleet = new Fleet($fleetName);

            $fleet->setShipId(trim($_POST['ship']));
            $fleet->setQuantity(trim($_POST['quantity']));
            $fleet->setId(trim($id));

            if (empty($fleet->getQuantity())) {
                $errors[] = 'Please enter quantity';
            } elseif (is_numeric($fleet->getQuantity()) === false || ($fleet->getQuantity() < 0)) {
                $errors[] = "Invalid quantity entered";
            }

            if (empty($errors)) {
                $fleetStorage = $container->getFleetStorage();
                $fleetStorage->addShipToFleet($fleet);

                header('Location: /manage/fleets/details.php?id='.$id);
                return;
            }
        }
?>
<h1>Add ship to <?php echo $fleetName;?> fleet</h1>

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

<form method='POST' action='/manage/fleets/addShip.php?id=<?php echo $id;?>&team=<?php echo $team?>'>
    <div>
        <label for='ship'>Ship</label>
        <select name="ship" id="ship" class="form-control">
            <?php foreach ($ships as $ship): ?>
                <option value="<?php echo $ship->getId(); ?>">
                    <?php echo $ship->getName(); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div>
        <label for='quantity'>Quantity</label>
        <input class='form-control' type='number' id='quantity' name='quantity'/>
    </div>
    <br>
    <div class='text-center'>
        <button type="submit" class="btn btn-success">Submit</button>
    </div>
</form>

<?php endforeach;?>
<?php endif;?>
<?php require '../ships/footer.php';?>

<?php
require '../ships/header.php';
$id = isset($_GET['id']) ? $_GET['id'] : null;
$errors = [];

use Service\Container;
use Model\ShipFleet;

$container = new Container($configuration);

$fleetLoader = $container->getFleetLoader();
$shipLoader = $container->getShipLoader();
$fleet = $fleetLoader->getFleetById($id);
$fleetShips = $fleetLoader->getFleetShipsByFleet($fleet);
$ships = $shipLoader->findShipsByTeam($fleet->getTeam());

if ($fleetShips === null):
    $breadcrumbItems = [];
    include '_breadcrumb.php';
    echo '<h1>Fleet Not Available</h1>';
else:

        $breadcrumbItems = [
            [
                'url'=>'/manage/fleets/details.php?id='.$fleet->getId(),
                'name'=> $fleet->getName(). ' Fleet'
            ],
            [
                'url'=>'#',
                'name'=>'Add to fleet',
            ]
        ];

        include '_breadcrumb.php';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $fleetShip = new ShipFleet();

            foreach ($ships as $ship):
                $fleetShip->setShip($ship);
            endforeach;
            $fleetShip->setFleet($fleet);

            $fleetShip->getShip()->setId(trim($_POST['ship']));
            $fleetShip->setQuantity(trim($_POST['quantity']));
            $fleetShip->getFleet()->setId(trim($id));

            if (empty($fleetShip->getQuantity())) {
                $errors[] = 'Please enter quantity';
            } elseif (is_numeric($fleetShip->getQuantity()) === false || ($fleetShip->getQuantity() < 0)) {
                $errors[] = "Invalid quantity entered";
            }

            if (empty($errors)) {
                $fleetStorage = $container->getFleetStorage();
                $fleetStorage->addSingleShipToFleet($fleetShip);

                header('Location: /manage/fleets/details.php?id='.$fleet->getId());
                return;
            }
        }
?>
<h1>Add ship to <?php echo $fleet->getName();?> fleet</h1>

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

<form method='POST' action='/manage/fleets/addShip.php?id=<?php echo $fleet->getId();?>&team=<?php echo $fleet->getTeam();?>'>
    <div>
        <label for='ship'>Ship</label>
        <select name="ship" id="ship" class="form-control">
            <?php foreach ($ships as $ship): ?>
                <?php if (!$fleet->hasShip($ship)):?>
                    <option value="<?php echo $ship->getId(); ?>">
                        <?php echo $ship->getName(); ?>
                    </option>
                <?php endif;?>
            <?php endforeach;?>
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

<?php endif;?>
<?php require '../ships/footer.php';?>

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
$ships = $shipLoader->findShipsByTeam($fleet->getTeam());

if ($fleet === null):
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
            $shipFleet = new ShipFleet();

            foreach ($ships as $ship):
                $shipFleet->setShip($ship);
            endforeach;
            $shipFleet->setFleet($fleet);

            $shipFleet->getShip()->setId(trim($_POST['ship']));
            $shipFleet->setQuantity(trim($_POST['quantity']));
            $shipFleet->getFleet()->setId(trim($id));

            if (empty($shipFleet->getQuantity())) {
                $errors[] = 'Please enter quantity';
            } elseif (is_numeric($shipFleet->getQuantity()) === false || ($shipFleet->getQuantity() < 0)) {
                $errors[] = "Invalid quantity entered";
            }

            if (empty($errors)) {
                $fleetStorage = $container->getFleetStorage();
                $fleetStorage->addShipFleet($shipFleet);

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

<form method='POST' action='/manage/fleets/addShipFleet.php?id=<?php echo $fleet->getId();?>'>
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

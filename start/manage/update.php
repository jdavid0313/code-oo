<?php 
require 'header.php';

$id = isset($_GET['id']) ? $_GET['id'] : null;
$errmessages = [];


use Service\Container;

$container = new Container($configuration);

$shipLoader = $container->getShipLoader();

$ship = $shipLoader->findOneById($id);


if ($_SERVER['REQUEST_METHOD'] == 'POST'){


    $ship->setName($_POST['shipName']);
    $ship->setWeaponPower($_POST['weaponPower']);
    $ship->setJediFactor($_POST['jediFactor']);
    $ship->setStrength($_POST['strength']);
    $ship->setDescription($_POST['description']);


    if (empty(trim($ship->getName()))){
        $errmessages[] = "Please enter ship name";
    }

    if (empty(trim($ship->getWeaponPower()))){
        $errmessages[] = "Please enter weapon power";
    } elseif (is_numeric($ship->getWeaponPower() == false) || ($ship->getWeaponPower() < 0)){
        $errmessages[] = "Invalid weapon power entered";
    } 
    
    if (empty(trim($ship->getJediFactor()))){
        $errmessages[] = "Please enter Jedi Factor";
    } elseif (is_numeric($ship->getJediFactor() == false) || ($ship->getJediFactor() < 0)) {
        $errmessages[] = "Invalid jedi factor entered";
    } 

    if (empty(trim($ship->getStrength()))){
        $errmessages[] = "Please enter ship strength";
    } elseif (is_numeric($ship->getStrength() == false) || ($ship->getStrength() < 0)) {
        $errmessages[] = "Invalid strength entered";
    } 

    if (empty(trim($ship->getDescription()))){
        $errmessages[] = "Please enter ship description";
    }

    if (empty($errmessages)){

        $shipStorage = $container->getShipStorage();
        $shipStorage->updateShip($ship);

        header('location: show.php');
    }

}

?>

<div class='container'>

    <ul class='breadcrumb'>
        <li><a href="index.php">Manage Ships</a></li>
        <li><a href="show.php?id=<?php echo $id?>"><?php echo $ship->getName(); ?> Details </a></li>
        <li>Edit</li>
    </ul>

    <?php if ($ship === null): ?>
        <h1> Ship Not Available </h1>
    <?php else: ?>

    <h2>Update <?php echo $ship->getName();?> Ship Details:  </h2>
    
    <div class='row'>
        <div class="col-lg-3">
            <ul class="list-group">
                <?php foreach($errmessages as $errmessage):  ?>
                    <li class="list-group-item list-group-item-danger"><?php echo $errmessage ?></li>
                <?php endforeach;  ?>
            </ul>
        </div>
    </div>

    
    <div class='row'>
        <div class="col-lg-12">
            <form action="update.php?id=<?php echo $ship->getId();?>" method="POST">

                    <div>
                        <label for="shipName">Update Ship Name:</label><br>
                        <input class="form-control" type="text" name="shipName" id="shipName" value="<?php echo $ship->getName();  ?>" />
                    </div>

                    <div>
                        <label for="weaponPower">Update Weapon Power:</label>
                        <input class="form-control" type="text" name="weaponPower" id="weaponPower" value="<?php echo $ship->getWeaponPower(); ?>" />
                    </div>  

                    <div>
                        <label for="jediFactor">Update Jedi Factor:</label>
                        <input class="form-control" type="number" name="jediFactor" id="jediFactor" value="<?php echo $ship->getJediFactor(); ?>" />
                    </div>

                    <div>
                        <label for="strength">Update Strength:</label>
                        <input class="form-control" type="number" name="strength" id="strength" value="<?php echo $ship->getStrength(); ?>" />
                    </div>

                    <div> 
                        <label for="team">Update Ship Description:</label>
                        <textarea class="form-control" name="description" id="description"><?php echo $ship->getDescription();  ?></textarea>
                    </div>

                    <br>
                    <div class='text-center'>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                
            </form>
        </div>
    </div>
    
    <?php endif;  ?>

</div>


<?php require 'footer.php';

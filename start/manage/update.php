<?php 
require 'header.php';

$id = isset($_GET['id']) ? $_GET['id'] : null;
$errmessages = [];


use Service\Container;

$container = new Container($configuration);

$shipLoader = $container->getShipLoader();

$ship = $shipLoader->findOneById($id);


if ($_SERVER['REQUEST_METHOD'] == 'POST'){


    $ship->setName($_POST['ship']);
    $ship->setWeaponPower($_POST['weaponPower']);
    $ship->setJediFactor($_POST['jediFactor']);
    $ship->setStrength($_POST['strength']);
    $ship->setDescription($_POST['description']);


    if (empty(trim($ship->getName()))){
        $errmessages[] = "Please enter ship name";
    }

    if (empty(trim($ship->getWeaponPower()))){
        $errmessages[] = "Please enter weapon power";
    } elseif ($ship->getWeaponPower() < 0){
        $errmessages[] = "Weapon Power can't be less than zero";
    } elseif (is_int($ship->getWeaponPower() == false)) {
        $errmessages[] = "Weapn Power must be a number";
    }
    
    if (empty(trim($ship->getJediFactor()))){
        $errmessages[] = "Please enter Jedi Factor";
    } elseif ($ship->getJediFactor() < 0){
        $errmessages[] = "Jedi Factor can't be less than zero";
    } elseif (is_int($ship->getJediFactor() == false)){
        $errmessages[] = "Jedi Factor must be a number";
    }

    if (empty(trim($ship->getStrength()))){
        $errmessages[] = "Please enter ship strength";
    } elseif ($ship->getStrength() < 0) {
        $errmessages[] = "Strength can't be less than zero";
    } elseif (is_int($ship->getstrength() == false)){
        $errmessages[] = "Strength must be a number";
    }

    if (empty(trim($ship->getDescription()))){
        $errmessages[] = "Please enter ship description";
    }

    

    
    if ($errmessages == []){

        $shipStorage = $container->getShipStorage();
        $shipStorage->updateShip($ship);

        header('location: index.php');
    }

}

?>

<div class='container'>
    <a href="show.php?id=<?php echo $id?>"> Back to previous page </a>

    <?php if ($ship === null): ?>
        <h1> Ship Not Available </h1>
    <?php else: ?>

    <h2>Update <?php echo $ship->getName();?> Ship Details:  </h2>
    
    <div class="col-lg-3">
        <ul class="list-group">
            <?php foreach($errmessages as $errmessage):  ?>
                <li class="list-group-item list-group-item-danger"><?php echo $errmessage ?></li>
            <?php endforeach;  ?>
        </ul>
    </div>

    <br>
    
    <div class="col-lg-12">
        <form action="update.php?id=<?php echo $ship->getId();?>" method="POST">

                <div>
                    <label for="shipname">Update Ship Name:</label><br>
                    <input class="form-control" type="text" name="ship" id="ship" value="<?php if (isset($shipName)) { echo $shipName; } else { echo $ship->getName(); } ?>" />
                </div>

                <div>
                    <label for="weaponPower">Update Weapon Power:</label>
                    <input class="form-control" type="text" name="weaponPower" id="weaponPower" value="<?php if (isset($weaponPower)) { echo $weaponPower; } else { echo $ship->getWeaponPower(); } ?>" />
                </div>  

                <div>
                    <label for="jediFactor">Update Jedi Factor:</label>
                    <input class="form-control" type="number" name="jediFactor" id="jediFactor" value="<?php if (isset($jediFactor)) { echo $jediFactor; } else { echo $ship->getJediFactor(); } ?>" />
                </div>

                <div>
                    <label for="strength">Update Strength:</label>
                    <input class="form-control" type="number" name="strength" id="strength" value="<?php if (isset($strength)) { echo $strength; } else { echo $ship->getStrength(); }?>" />
                </div>

                <div> 
                    <label for="team">Update Ship Description:</label>
                    <textarea class="form-control" name="description" id="description"><?php if (isset($description)) { echo $description; } else { echo $ship->getDescription(); } ?></textarea>
                </div>

                <br>
                <div class='text-center'>
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
            
        </form>
    </div>
    
    <?php endif;  ?>

</div>


<?php require 'footer.php';

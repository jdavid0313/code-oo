<?php 
require 'header.php';

$id = isset($_GET['id']) ? $_GET['id'] : null;
$errmessages = [];


use Service\Container;

$container = new Container($configuration);

$shipLoader = $container->getShipLoader();

$ship = $shipLoader->findOneById($id);

$shipStorage = $container->getShipStorage();

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    $shipName = $_POST['ship'];
    $weaponPower = $_POST['weaponPower'];
    $jediFactor = $_POST['jediFactor'];
    $strength = $_POST['strength'];
    $team = $_POST['team'];
    $description = $_POST['description'];

    // $pdoShipStorage = $container->getShipStorage();
    // $update = $pdoShipStorage->updateShip($shipname, $weaponPower, $jediFactor, $strength, $team, $description);

    if (empty(trim($shipName))){
        $errmessages[] = "Please enter ship name";
    }

    if (empty(trim($weaponPower))){
        $errmessages[] = "Please enter weapon power";
    }

    if (empty(trim($jediFactor))){
        $errmessages[] = "Please enter Jedi Factor";
    }

    if (empty(trim($strength))){
        $errmessages[] = "Please enter ship strength";
    }

    if (empty(trim($team))){
        $errmessages[] = "Please enter ship team";
    }

    if (empty(trim($description))){
        $errmessages[] = "Please enter ship description";
    }

    if ($errmessages == []){

        
        $shipStorage->updateShip($id, $shipName, $weaponPower, $jediFactor, $strength, $team, $description);

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
                    <input class="form-control" type="number" name="weaponPower" id="weaponPower" value="<?php echo $ship->getWeaponPower()?>" />
                </div>  

                <div>
                    <label for="jediFactor">Update Jedi Factor:</label>
                    <input class="form-control" type="number" name="jediFactor" id="jediFactor" value="<?php echo $ship->getJediFactor()?>" />
                </div>

                <div>
                    <label for="strength">Update Strength:</label>
                    <input class="form-control" type="number" name="strength" id="strength" value="<?php echo $ship->getStrength()?>" />
                </div>

                <div>
                    <label for="team">Update Ship Team:</label>
                    <input class="form-control" type="text" name="team" id="team" value="<?php echo $ship->getType()?>" />
                </div>

                <div> 
                    <label for="team">Update Ship Description:</label>
                    <textarea class="form-control" name="description" id="description"><?php echo $ship->getDescription()?></textarea>
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

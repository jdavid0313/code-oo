<?php 
require 'header.php';
// if ($_SERVER['REQUEST_METHOD'] == 'POST'){
//     header('location:index.php');die;
// }
$id = $_GET['id'];

// if ($_SERVER['REQUEST_METHOD'] == 'POST'){
//     header('location:index.php');die;
// }

use Service\Container;

$container = new Container($configuration);

$shipLoader = $container->getShipLoader();

$ship = $shipLoader->findOneById($id);

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    header('location:index.php');die;
}

?>

<div class='container'>
    <a href="show.php?id=<?php echo $id?>"> Back to previous page </a>

    <h2>Update <?php echo $ship->getName();?> Ship Details:  </h2>
    
    <br>

    <form action="update.php" method="POST">

            <div>
                <label for="shipname">Update Ship Name:</label><br>
                <input class="form-control" type="text" name="ship" id="ship" />
            </div>

            <div>
                <label for="weaponPower">Update Weapon Power:</label>
                <input class="form-control" type="number" name="weaponPower" id="weaponPower" />
            </div>  

            <div>
                <label for="jediFactor">Update Jedi Factor:</label>
                <input class="form-control" type="number" name="jediFactor" id="jediFactor" />
            </div>

            <div>
                <label for="strength">Update Strength:</label>
                <input class="form-control" type="number" name="strength" id="strength" />
            </div>

            <div>
                <label for="team">Update Ship Team:</label>
                <input class="form-control" type="text" name="team" id="team" />
            </div>

            <div> 
                <label for="team">Update Ship Description:</label>
                <textarea class="form-control" name="description" id="description"></textarea>
            </div>

            <br>
            <div class='text-center'>
                <button type="submit" class="btn btn-success">Submit</button>
            </div>
        
    </form>

</div>


<?php require 'footer.php';

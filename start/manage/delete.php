<?php
require 'header.php';

$id = $_GET['id'];

use Service\Container;

$container = new Container($configuration);

$shipLoader = $container->getShipLoader();

$ship = $shipLoader->findOneById($id);

?>

<div class='container'>

    <ul class='breadcrumb'>
        <li><a href="index.php">Manage Ships</a></li>
        <li><a href="show.php?id=<?php echo $id?>"><?php echo $ship->getName(); ?> Details </a></li>
        <li>Delete</li>
    </ul>

    <h2> Are you sure you want to delete the <?php echo $ship->getName();?> ship? </h2>

    <br>

    <a href="delete.php?id=<?php echo $id ?>"><button type="button" class="btn btn-secondary btn-lg">Yes, Delete</button></a>
    <a href="show.php?id=<?php echo $id ?>"><button type="button" class="btn btn-secondary btn-lg">No, Don't Delete</button></a>



</div>

<?php require 'footer.php';?>

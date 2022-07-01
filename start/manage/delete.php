<?php
require 'header.php';

$id = $_GET['id'];

use Service\Container;

$container = new Container($configuration);

$shipLoader = $container->getShipLoader();

$ship = $shipLoader->findOneById($id);

?>

<div class='container'>
    <a href="show.php?id=<?php echo $id?>"> Back to previous page </a>

    <h2> Are you sure you want to delete the <?php echo $ship->getName();?> ship? </h2>

</div>

<?php require 'footer.php';?>

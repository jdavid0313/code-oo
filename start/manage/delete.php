<?php
require 'header.php';

$id = isset($_GET['id']) ? $_GET['id'] : null;

use Service\Container;

$container = new Container($configuration);

$shipLoader = $container->getShipLoader();

$ship = $shipLoader->findOneById($id);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $shipStorage = $container->getShipStorage();
    $shipStorage->deleteShip($ship);

    header('Location: /manage/index.php');
    return;
}
?>
<?php if ($ship === null):?>
    <h1>Ship Not Available</h1>
<?php else:?>
<?php
$breadcrumbItems = [
    [
        'url' => '/manage/show.php?id='.$ship->getId(),
        'name' => $ship->getName(),
    ],
    [
        'url' => '#',
        'name' => 'Delete Ship',
    ],
];

include '_breadcrumb.php';
?>
<h2>Are you sure you want to delete the <?php echo $ship->getName();?> ship?</h2>

<br>

<form action='/manage/delete.php?id=<?php echo $ship->getId();?>' method='POST'>
    <button type="submit" class="btn btn-danger btn-lg">Yes, Delete</button>
</form>
<a href="show.php?id=<?php echo $ship->getId(); ?>" class="btn btn-primary btn-lg">No, Don't Delete</a>

<?php endif;?>
<?php require 'footer.php';?>

<?php
require '../ships/header.php';

$shipId = isset($_GET['shipId']) ? $_GET['shipId'] : null;
$fleetId = isset($_GET['fleetId']) ? $_GET['fleetId'] : null;

use Service\Container;

$container = new Container($configuration);
$fleetLoader = $container->getFleetLoader();
$fleetShip = $fleetLoader->findShipInFleetById($shipId, $fleetId);

if ($fleetShip === null):
    $breadcrumbItems = [];
    include '_breadcrumb.php';
    echo '<h1>Fleet Not Available</h1>';
else:

$breadcrumbItems = [
    [
        'url'=>'/manage/fleets/details.php?id='.$fleetShip->getId(),
        'name'=> $fleetShip->getName(). ' Fleet',
    ],
    [
        'url'=>'#',
        'name'=>'Delete Fleet'
    ]
];

include '_breadcrumb.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fleetStorage = $container->getFleetStorage();
    $fleetStorage->deleteShipFromFleet($fleetShip);

    header('Location: /manage/fleets/fleets.php');
    return;
}
?>
<h2> Are you sure you want to delete the <?php echo $fleetShip->getShipName();?> Ship from the <?php echo $fleetShip->getName();?> Fleet?</h2>

<br>
<form action='/manage/fleets/removeShip.php?shipId=<?php echo $fleetShip->getShipId();?>&fleetId=<?php echo $fleetShip->getId();?>' method='POST'>
    <button type="submit" class="btn btn-danger btn-lg">Yes, Delete</button>
</form>
<a href="/manage/fleets/details.php?id=<?php echo $fleetShip->getId(); ?>" class="btn btn-primary btn-lg">No, Don't Delete</a>

<?php endif;?>
<?php require '../ships/footer.php';?>
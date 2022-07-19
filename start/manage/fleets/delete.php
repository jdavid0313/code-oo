<?php
require '../ships/header.php';

$id = isset($_GET['id']) ? $_GET['id'] : null;

use Service\Container;

$container = new Container($configuration);
$fleetLoader = $container->getFleetLoader();
$fleetShips = $fleetLoader->getSingleFleetById($id);

if ($fleetShips === null):
    $breadcrumbItems = [];
    include '_breadcrumb.php';
    echo '<h1>Fleet Not Available</h1>';
else:

foreach ($fleetShips as $fleetShipName => $fleetShips):
    foreach($fleetShips as $fleetShip):
    $breadcrumbItems = [
        [
            'url'=>'/manage/fleets/details.php?id='.$fleetShip->getId(),
            'name'=> $fleetShipName. ' Fleet',
        ],
        [
            'url'=>'#',
            'name'=>'Delete Fleet'
        ]
    ];
    endforeach;
    include '_breadcrumb.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $fleetStorage = $container->getFleetStorage();
        $fleetStorage->deleteFleet($fleetShip->getId());

        header('Location: /manage/fleets/fleets.php');
        return;
    }
?>
<h1> Are you sure you want to delete the <?php echo $fleetShipName;?> Fleet?</h2>

<br>
<form action='/manage/fleets/delete.php?id=<?php echo $fleetShip->getId();?>' method='POST'>
    <button type="submit" class="btn btn-danger btn-lg">Yes, Delete</button>
</form>
<a href="/manage/fleets/details.php?id=<?php echo $fleetShip->getId(); ?>" class="btn btn-primary btn-lg">No, Don't Delete</a>

<?php endforeach;?>
<?php endif;?>
<?php require '../ships/footer.php';?>

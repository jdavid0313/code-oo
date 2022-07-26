<?php
require '../ships/header.php';
$id = isset($_GET['id']) ? $_GET['id'] : null;

use Service\Container;

$container = new Container($configuration);
$fleetLoader = $container->getFleetLoader();
$fleet = $fleetLoader->getFleetById($id);

if ($fleet === null):
    $breadcrumbItems = [];
    include '_breadcrumb.php';
    echo '<h1>Fleet Not Available</h1>';
else:

$breadcrumbItems = [
    [
        'url'=>'/manage/fleets/details.php?id='.$fleet->getId(),
        'name'=> $fleet->getName(). ' Fleet',
    ],
    [
        'url'=>'#',
        'name'=>'Delete Fleet'
    ]
];
include '_breadcrumb.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fleetStorage = $container->getFleetStorage();
    $fleetStorage->deleteFleet($fleet);

    header('Location: /manage/fleets/index.php');
    return;
}
?>
<h1> Are you sure you want to delete the <?php echo $fleet->getName();?> Fleet?</h2>

<br>
<form action='/manage/fleets/delete.php?id=<?php echo $fleet->getId();?>' method='POST'>
    <button type="submit" class="btn btn-danger btn-lg">Yes, Delete</button>
</form>
<a href="/manage/fleets/details.php?id=<?php echo $fleet->getId();?>" class="btn btn-primary btn-lg">No, Don't Delete</a>

<?php endif;?>
<?php require '../ships/footer.php';?>

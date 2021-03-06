<?php
require 'header.php';

use Service\Container;

$breadcrumbItems = [];
$searchName = null;
$container = new Container($configuration);
$shipLoader = $container->getShipLoader();
$ships = $shipLoader->getShips();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && array_key_exists('searchName', $_POST)) {
    $searchName = $_POST['searchName'];
    $ships = $shipLoader->searchByName($searchName);
}

?>
<div class="navbar-right">
    <a class="btn btn-primary" type="button" href="/manage/ships/add.php">Add Ship</a>
</div>

<form action='/manage/ships/index.php' method='POST' class='form-inline'>
    <div class='form-group'>
        <label for='searchName'>Search Ships: </label>
        <input id='searchName' name='searchName' class="form-control" value='<?php if ($searchName !== null) { echo $searchName;}?>'/>
        <button type="submit" class="btn btn-success">Search</button>
        <a href="/manage/ships/index.php" class="btn btn-primary" type='button'>Clear</a>
    </div>
</form>

<?php if (empty($ships)):?>
    <h3>No Ship Found</h3>
<?php else:?>

<div class="row">
    <?php foreach ($ships as $ship):?>
        <div class="col-sm-6">
            <h2>
                <a
                    href="/manage/ships/show.php?id=<?php echo $ship->getId();?>">
                    <?php echo $ship->getName();?>
                </a>
            </h2>

            <?php if ($ship->getImage()) { ?>
            <img src="/images/<?php echo $ship->getImage(); ?>"
                class="img-thumbnail">
            <?php } else { ?>
            <h4> Image Not Available </h4>
            <?php } ?>

        </div>
    <?php endforeach;?>
</div>

<?php endif;?>
<?php require 'footer.php';

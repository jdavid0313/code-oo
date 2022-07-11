<?php
require 'header.php';

use Service\Container;

$container = new Container($configuration);
$shipLoader = $container->getShipLoader();
$ships = $shipLoader->getShips();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $shipName = $_POST['shipName'];
    $ships = $shipLoader->searchByName($shipName);
}

?>
<form action='/manage/index.php' method='POST' class='form-inline'>
    <div class='form-group'>
        <label for='shipName'>Search Ships: </label>
        <input id='shipName' name='shipName' class="form-control" value='<?php if (isset($_POST['shipName'])) { echo $_POST['shipName'];}?>'/>
        <button type="submit" class="btn btn-success">Search</button>
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
                href="/manage/show.php?id=<?php echo $ship->getId();?>">
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

<?php
require "header.php";
use Service\Container;
$container = new Container($configuration);
$ships = [];
$errors = [];

$breadcrumbItems = [
    [
    'url' => '#',
    'name' => 'Search For Ship',
    ]
];

include '_breadcrumb.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (empty($_POST['shipName'])) {
        $errors[] = 'Please enter a ship';
    }

    $shipName = trim($_POST['shipName']). '%';

    //var_dump($shipName);die;

    if (empty($errors)) {

        $shipLoader = $container->getShipLoader();
        $ships = $shipLoader->findOneByName($shipName);

        if (empty($ships)) {
            echo '<h3>No Ship Found</h3>';
        }
    }
}
?>
<h1>Search for a ship:</h1>

<div class='row'>
    <div class="col-lg-3">
        <ul class="list-group">
            <?php foreach ($errors as $errmessage):  ?>
            <li class="list-group-item list-group-item-danger"><?php echo $errmessage ?>
            </li>
            <?php endforeach;  ?>
        </ul>
    </div>
</div>

<form action="/manage/search.php" method='POST'>
    <label for='shipName'>Enter Ship Name</label>
    <input class='form-control' type='text' name='shipName' id='shipName'/>
    <br>
    <div class='text-center'>
        <button type="submit" class="btn btn-success">Search</button>
    </div>
</form>

<?php foreach ($ships as $ship):?>
<div class="col-sm-4">
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

<?php
require "footer.php";
?>

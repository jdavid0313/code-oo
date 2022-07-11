<?php
require "header.php";
use Service\Container;
$container = new Container($configuration);
$ships = [];

$breadcrumbItems = [
    [
    'url' => '#',
    'name' => 'Search For Ship',
    ]
];

include '_breadcrumb.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $shipName = trim($_POST['shipName']). '%';

    $shipLoader = $container->getShipLoader();
    $ships = $shipLoader->findOneByName($shipName);

    if (empty($ships)) {
        echo '<h3>No Ship Found</h3>';
    }
}
?>
<h1>Search for a ship:</h1>

<form action="/manage/search.php" method='POST'>
    <label for='shipName'>Enter Ship Name</label>
    <input class='form-control' type='text' name='shipName' id='shipName'/>
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

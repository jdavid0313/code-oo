<?php
require 'header.php';

$id = isset($_GET['id']) ? $_GET['id'] : null;

use Service\Container;

$container = new Container($configuration);

$shipLoader = $container->getShipLoader();

$ship = $shipLoader->findOneById($id);

if ($ship === null):
    $breadcrumbItems = [];
    include '_breadcrumb.php';
    echo '<h1>Ship Not Available</h1>';
else:

$breadcrumbItems = [
    [
        'url' => '/manage/ships/show.php?id='.$ship->getId(),
        'name' => $ship->getName(),
    ]
];

include '_breadcrumb.php';
?>
<h1> <?php echo $ship->getName(); ?>
</h1>

<?php if ($ship->getImage()): ?>
<img src="/images/<?php echo $ship->getImage(); ?>"
    class="img-thumbnail">
<?php else:?>
<h4> Image Not Available </h4>
<?php endif; ?>

<h3>Ship Details:</h3>

<br>

<table class="table">
    <tr>
        <th>Weapon Power:</th>
        <td><?php echo $ship->getWeaponPower();?>
        </td>
    </tr>
    <tr>
        <th>Jedi Factor:</th>
        <td><?php echo $ship->getJediFactor();?>
        </td>
    </tr>
    <tr>
        <th>Ship Strength:</th>
        <td><?php echo $ship->getStrength();?>
        </td>
    </tr>
    <tr>
        <th>Team:</th>
        <td><?php echo $ship->getType();?>
        </td>
    </tr>
    <tr>
        <th>Ship Description:</th>
        <td><?php echo $ship->getDescription();?>
        </td>
    </tr>

</table>

<hr>

<div class='text-center'>
    <a href="update.php?id=<?php echo $id ?>"><button type="button"
            class="btn btn-success">Update</button></a>
    <a href="delete.php?id=<?php echo $id ?>"><button type="button"
            class="btn btn-danger">Delete</button></a>
</div>

<br>

<?php endif; ?>
<?php require "footer.php";

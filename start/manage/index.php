<?php
require 'header.php';

use Service\Container;

$container = new Container($configuration);
$shipLoader = $container->getShipLoader();
$ships = $shipLoader->getShips();

?>


<div class="container">
    
    <table class='table'>
        <thead>
            
            <tr>
                <th></th>    
                <th>Weapon Power</th>   
                <th>Jedi Factor</th>
                <th>Strength</th>
                <th>Team</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($ships as $ship): ?>
            <tr>
                <td><a href='show.php?id=<?php echo $ship->getId();?>'><?php echo $ship->getName() ?></a></td>
                <td><?php echo $ship->getWeaponPower();?></td>
                <td><?php echo $ship->getJediFactor();?></td>
                <td><?php echo $ship->getStrength();?></td>
                <td><?php echo $ship->getType();?></td>

            </tr>
            <?php endforeach;?>
        </tbody>

    </table>

</div>    

<?php require 'footer.php'; ?>

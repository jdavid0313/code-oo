<?php
require __DIR__.'/functions.php';

use Service\Container;

$container = new Container($configuration);
$shipLoader = $container->getShipLoader();
$fleetLoader = $container->getFleetLoader();
$fleetStorage = $container->getFleetStorage();
$ships = $shipLoader->getShips();

$fleet1id = isset($_POST['fleet1_id']) ? $_POST['fleet1_id'] : null;
$fleet2id = isset($_POST['fleet2_id']) ? $_POST['fleet2_id'] : null;


if (!$fleet1id || !$fleet2id) {
    header('Location: /index.php?error=missing_data');
    die;
}

$fleet1 = $fleetLoader->getFleetById($fleet1id);
$fleet2 = $fleetLoader->getFleetById($fleet2id);

if (!$fleet1|| !$fleet2) {
    header('Location: /index.php?error=bad_ships');
    die;
}


$battleManager = $container->getBattleManager();
$battleType = $_POST['battle_type'];
$battleResult = $battleManager->battleFleet($fleet1, $fleet2, $battleType);
foreach ($fleet1->getShipFleets() as $sf):
    $fleetStorage->updateShipFleet($sf); // this method should loop over each ship_fleet and update the quantity for each
endforeach;

foreach ($fleet2->getShipFleets() as $sf):
    $fleetStorage->updateShipFleet($sf);
endforeach;
// if ($battleResult->getLosingShip() !== null) {
//     $fleetStorage = $container->getFleetStorage();
//     $fleetStorage->updateShipFleet($battleResult->getLosingShip());
// }
?>

<html>
    <head>
        <meta charset="utf-8">
           <meta http-equiv="X-UA-Compatible" content="IE=edge">
           <meta name="viewport" content="width=device-width, initial-scale=1">
           <title>OO Battleships</title>

           <!-- Bootstrap -->
           <link href="css/bootstrap.min.css" rel="stylesheet">
           <link href="css/style.css" rel="stylesheet">
           <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
           <link href='http://fonts.googleapis.com/css?family=Audiowide' rel='stylesheet' type='text/css'>

           <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
           <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
           <!--[if lt IE 9]>
             <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
             <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
           <![endif]-->
    </head>
    <body>
        <div class="container">
            <div class="page-header">
                <h1>OO Battleships of Space</h1>
            </div>
            <div>
                <h2 class="text-center">The Matchup:</h2>
                <p class="text-center">
                    <br>
                    <?php echo $fleet1->getName(); ?> Fleet <?php //echo $fleetShip1->getQuantity() > 1 ? 's': ''; ?>
                    VS.
                    <?php echo $fleet2->getName(); ?> Fleet <?php //echo $fleetShip2->getQuantity() > 1 ? 's': ''; ?>
                </p>
            </div>


            <div class="result-box center-block">
                <h3 class="text-center audiowide">
                    Winner:
                    <?php if ($battleResult->isThereAWinner()): ?>
                        <?php echo $battleResult->getWinningFleet()->getName(); ?> Fleet
                    <?php else: ?>
                        Nobody
                    <?php endif; ?>
                </h3>
                <p class="text-center">
                    <?php if (!$battleResult->isThereAWinner()): ?>
                        Both ships destroyed each other in an epic battle to the end.
                    <?php else: ?>
                        The <?php echo $battleResult->getWinningFleet()->getName();?> Fleet
                        <?php if ($battleResult->wereJediPowersUsed()): ?>
                            used their Jedi Powers for a stunning victory!
                        <?php else: ?>
                            overpowered and destroyed the <?php echo $battleResult->getLosingFleet()->getName() ?> Fleet
                        <?php endif; ?>
                    <?php endif; ?>
                </p>


                <h3>Fleet Health</h3>
                <dl class="dl-horizontal">
                    <dt><?php echo $battleResult->getWinningFleet()->getName();?></dt>
                    <dd><?php echo $battleResult->getWinningShip()->getShip()->getStrength();?></dd>
                    <?php foreach ($battleResult->getWinningFleet()->getShipFleets() as $shipFleets):?>
                        <li><?php echo $shipFleets->getShip()->getName();?> Quantity - <?php echo $shipFleets->getQuantity();?></li>
                    <?php endforeach;?>
                    <dt><?php echo $battleResult->getLosingFleet()->getName();?></dt>
                    <dd><?php echo $battleResult->getLosingShip()->getShip()->getStrength();?></dd>
                    <?php foreach ($battleResult->getLosingFleet()->getShipFleets() as $shipFleets):?>
                        <li><?php echo $shipFleets->getShip()->getName();?> Quantity - <?php echo $shipFleets->getQuantity();?></li>
                    <?php endforeach;?>
                </dl>
            </div>
            <a href="/index.php"><p class="text-center"><i class="fa fa-undo"></i> Battle again</p></a>

            <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
            <!-- Include all compiled plugins (below), or include individual files as needed -->
            <script src="js/bootstrap.min.js"></script>
        </div>
    </body>
</html>

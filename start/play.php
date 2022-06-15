<?php
require_once __DIR__.'/lib/ship.php';

function printShipSummary($someship){
    echo 'Ship name: ' . $someship->name;
    echo '<hr/>';
    $someship->sayhello();
    echo '<hr/>';
    echo $someship->getname();
    echo '<hr/>';
    echo $someship->getNameAndSpecs(false);
    echo '<hr/>';
    echo $someship->getNameAndSpecs(true);
}


$myShip = new Ship();
$myShip->name = 'Jedi Starhip';
$myShip->weaponPower = 10;
$myShip->strength = 35;

$otherShip = new Ship();
$otherShip->name = 'Imperial Shuttle';
$otherShip->weaponPower = 5;
$otherShip->strength = 50;

printShipSummary($myShip);
echo "<hr/>";
printShipSummary($otherShip);
echo "<hr/>";


if ($myShip->doesGivenShipHaveMoreStrength($otherShip) == true)
    echo $otherShip->name . ' has more strength';
else{
    echo $myShip->name . ' has more strength';
}


//echo $myShip->doesGivenShipHaveMoreStrength($otherShip);

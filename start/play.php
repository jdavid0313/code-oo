<?php
class Ship{

    public $name; //Property (class memeber variables.)
    public $weaponPower = 0;
    public $jediFactor = 0;
    public $strength = 0;

    public function sayhello(){ //Method (Function that lives inside a class.)
        echo 'Hello!';
    }

    public function getname(){
        return $this->name;
    }

    public function getNameAndSpecs($shortformat){
        if ($shortformat){
            return sprintf(
                '%s: w:%s, j:%s, s:%s',
                $this->name,
                $this->weaponPower,
                $this->jediFactor,
                $this->strength
                );  
        }
        else{
            return sprintf(
                '%s: %s/%s/%s',
                $this->name,
                $this->weaponPower,
                $this->jediFactor,
                $this->strength
                );  
        }
    }

    public function doesGivenShipHaveMoreStrength($givenship){
        return $givenship->strength > $this->strength;
    }
}

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

/*
if ($myShip->doesGivenShipHaveMoreStrength($otherShip) == true)
    echo $otherShip->name . ' has more strength';
else{
    echo $myShip->name . ' has more strength';
}
*/

//echo $myShip->doesGivenShipHaveMoreStrength($otherShip);

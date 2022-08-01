<?php

namespace Model;
class BattleResult implements \ArrayAccess
{

    private $winningShip;
    private $winningFleet;
    private $losingShip;
    private $losingFleet;
    private $usedJediPowers;

    public function __construct($usedJediPowers, ShipFleet $winningShip = null, ShipFleet $losingShip = null){
        $this->usedJediPowers = $usedJediPowers;
        $this->winningShip = $winningShip;
        $this->losingShip = $losingShip;
    }

    public function wereJediPowersUsed(){
        return $this->usedJediPowers;
    }

    public function getWinningShip(){
        return $this->winningShip;
    }

    public function getLosingShip(){
        return $this->losingShip;
    }

    public function setWinningFleet($fleet)
    {
        $this->winningFleet = $fleet;
    }

    public function getWinningFleet()
    {
        return $this->winningFleet;
    }

    public function setLosingFleet($fleet)
    {
        $this->losingFleet = $fleet;
    }

    public function getlosingFleet()
    {
        return $this->losingFleet;
    }

    public function isThereAWinner(){
        return $this->getWinningShip() !== null;
    }

    public function offsetExists($offset)
    {
        return property_exists($this, $offset);
    }

    public function offsetGet($offset)
    {
        return $this->offset;
    }

    public function offsetSet($offset, $value)
    {
        $this->$offset = $value;
    }

    public function offsetUnset($offset)
    {
        unset($this->$offset);
    }
}

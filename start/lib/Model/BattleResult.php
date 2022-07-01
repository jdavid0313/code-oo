<?php

namespace Model;
class BattleResult implements \ArrayAccess
{

    private $winningShip;
    private $losingShip;
    private $usedJediPowers;

    public function __construct($usedJediPowers, AbstractShip $winningShip = null, Abstractship $losingShip = null){
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

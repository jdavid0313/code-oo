<?php
class BattleResult{
    
    private $winningShip;
    private $losingShip;
    private $usedJediPowers;

    public function __construct($usedJediPowers, $winningShip = null, $losingShip = null){
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
}

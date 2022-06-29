<?php 

namespace Model;

class Ship extends AbstractShip
{

    use SettableJediFactorTrait;
    
    private $underRepair;

    public function __construct($name)
    {
        parent::__construct($name);

        $this->underRepair = mt_rand(1, 100) < 30;
    }

    /*
    public function getJediFactor(){
        return $this->jediFactor;
    }

    public function setJediFactor($jediFactor){
        if (is_numeric($jediFactor) == false){
            throw new Exception('Invalid jedi factor passed ' . $jediFactor);
        }
        else{
            $this->jediFactor = $jediFactor;
        }
    }
    */

    public function isFunctional(){
        return $this->underRepair == false;
    }

    public function getType()
    {
        return 'Empire';
    }
}

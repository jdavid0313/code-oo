<?php 


class RebelShip extends Ship 
{
    public function getFavoriteJedi()
    {
     $coolJedis = array('Yoda', 'Ben Kenobi');
     $key = array_rand($coolJedis);

     return $coolJedis[$key];
    }

    public function getType()
    {
        return 'Rebel';
    }

    public function isFunctional(){
        return true;
    }

    public function getNameAndSpecs($shortformat = false){
        
        $val = parent::getNameAndSpecs($shortformat);
        $val .= ' (Rebel)';

        return $val;
        
        
    }

    public function getJediFactor()
    {
        return rand(10, 30);
    }
}

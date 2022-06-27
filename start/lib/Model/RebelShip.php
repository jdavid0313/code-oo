<?php 

namespace Model;
class RebelShip extends AbstractShip 
{

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
        
        if ($this->jediFactor === 0){
            $this->jediFactor = rand(10,30);
        }

        return $this->jediFactor;
    }

}

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

<?php 

class Ship{

    private $name; //Property (class memeber variables.)
    private  $weaponPower = 0;
    private $jediFactor = 0;
    private $strength = 0;
    private $underRepair;

    public function __construct($name){
        $this->name = $name;
        $this->underRepair = mt_rand(1,100) < 30;
    }

    public function isFunctional(){
        return $this->underRepair == false;
    }

    public function sayhello(){ //Method (Function that lives inside a class.)
        echo 'Hello!';
    }
    public function setname ($name){
        $this->name = $name;
    }

    public function getname(){
        return $this->name;
    }

    public function getNameAndSpecs($shortformat = false){
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

    public function setWeaponPower($weaponPower){
        if (is_numeric($weaponPower) == false){
            throw new Exception('Invalid weapon power passed ' . $weaponPower);
        }
        else{
            $this->weaponPower = $weaponPower;
        }

    }

    public function getWeaponPower(){
        return $this->weaponPower;
    }

    public function setJediFactor($jediFactor){
        if (is_numeric($jediFactor) == false){
            throw new Exception('Invalid jedi factor passed ' . $jediFactor);
        }
        else{
            $this->jediFactor = $jediFactor;
        }
    }

    public function getJediFactor(){
        return $this->jediFactor;
    }

    public function setStrength($strength){
        if (is_numeric($strength) == false){
            throw new Exception("Invalid strength passed " . $strength);
        }
        
        $this->strength = $strength;
        
    }

    public function getStrength(){
        return $this->strength;
    }
}

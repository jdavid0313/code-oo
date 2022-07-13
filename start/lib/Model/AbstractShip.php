<?php

namespace Model;

abstract class AbstractShip
{

    //use SettableJediFactorTrait;
    private $id;
    private $name; //Property (class memeber variables.)
    private $weaponPower = 0;
    //protected $jediFactor = 0;
    private $strength = 0;
    private $description;
    private $image;
    private $shipQuantity;

    use SettableJediFactorTrait;

    const EMPIRE = 'Empire';
    const REBEL = 'Rebel';

    abstract public function getJediFactor();
    abstract public function getType();
    abstract public function isFunctional();


    public function __construct($name)
    {
        $this->name = $name;

    }

    public static function validTypes()
    {
        return [AbstractShip::EMPIRE, AbstractShip::REBEL];
    }

    public function sayhello()
    { //Method (Function that lives inside a class.)
        echo 'Hello!';
    }
    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getNameAndSpecs($shortformat = false)
    {
        if ($shortformat) {
            return sprintf(
                '%s: w:%s, j:%s, s:%s',
                $this->name,
                $this->weaponPower,
                $this->getJediFactor(),
                $this->strength
            );
        } else {
            return sprintf(
                '%s: %s/%s/%s',
                $this->name,
                $this->weaponPower,
                $this->getJediFactor(),
                $this->strength
            );
        }
    }

    public function doesGivenShipHaveMoreStrength($givenship)
    {
        return $givenship->strength > $this->strength;
    }

    public function setWeaponPower($weaponPower)
    {
        $this->weaponPower = $weaponPower;
    }

    public function getWeaponPower()
    {
        return $this->weaponPower;
    }




    public function setStrength($strength)
    {
        $this->strength = $strength;
    }

    public function getStrength()
    {
        return $this->strength;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }
    public function getDescription()
    {
        return $this->description;
    }

    public function setImage($image)
    {
        $this->image = $image;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function __toString()
    {
        return $this->getName();
    }

    public function __get($propertyName)
    {
        return $this->$propertyName;
    }

    public function setShipQuantity($shipQuantity)
    {
        $this->shipQuantity = $shipQuantity;
    }

    public function getShipQuantity()
    {
        return $this->shipQuantity;
    }
}

<?php

namespace Model;

class Fleet
{
    private $id;
    private $name;
    private $team;
    private $quantity;
    private $shipName;
    private $shipId;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setShipName($shipName)
    {
        $this->shipName = $shipName;
    }

    public function getShipName()
    {
        return $this->shipName;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setShipId($shipId)
    {
        $this->shipId = $shipId;
    }

    public function getShipId()
    {
        return $this->shipId;
    }

    public function setTeam($team)
    {
        $this->team = $team;
    }

    public function getTeam()
    {
        return $this->team;
    }

    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

}

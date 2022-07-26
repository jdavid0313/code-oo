<?php

namespace Model;

class Fleet
{
    private $id;
    private $name;
    private $team;
    private $fleetShips;

    public function findShipFleetByShip(AbstractShip $ship): ?ShipFleet
    {
        foreach($this->shipFleets as $shipFleet) {
            if ($shipFleet->getShip()->getId() == $ship->getId()) {
                return $shipFleet;
            }
        }

        return null;
    }

    public function getShips(): array
    {
        $ships = [];
        foreach ($this->shipFleets as $shipFleet) {
            $ships[] = $shipFleet->getShip();
        }

        return $ships;
    }

    public function hasShip(AbstractShip $ship): bool
    {
        foreach ($this->getShips() as $s) {
            if ($s->getId() == $ship->getId()) {
                return true;
            }
        }

        return false;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }


    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }


    public function setTeam($team)
    {
        $this->team = $team;
    }

    public function getTeam()
    {
        return $this->team;
    }

    public function setShipFleets(array $shipFleets)
    {
        $this->shipFleets = $shipFleets;
    }

    public function getShipFleets(): array
    {
        return $this->shipFleets;
    }

}

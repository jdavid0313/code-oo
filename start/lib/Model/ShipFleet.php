<?php

namespace Model;

class ShipFleet
{
    private $ship;
    private $fleet;
    private $quantity;

    public function setShip(AbstractShip $ship): ShipFleet
    {
        $this->ship = $ship;

        return $this;
    }

    public function getShip(): AbstractShip
    {
        return $this->ship;
    }

    public function setFleet(Fleet $fleet): ShipFleet
    {
        $this->fleet = $fleet;

        return $this;
    }

    public function getFleet(): Fleet
    {
        return $this->fleet;
    }

    public function setQuantity(int $quantity): ShipFleet
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }
}

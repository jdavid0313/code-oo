<?php

namespace Service;

use Model\Fleet;
use Model\ShipFleet;

interface FleetStorageInterface
{
    public function fetchFleetsWithShipQuantity(): array;

    public function findTeams(): array;

    public function findFleetById($id);

    public function findFleetShipsByFleet(Fleet $fleet): array;

    public function deleteFleet(Fleet $fleet): void;

    public function deleteShipFleet(ShipFleet $fleetShip): void;

    public function updateShipFleet(ShipFleet $fleetShip): void;

    public function addShipFleet(ShipFleet $fleetShip): void;

    public function addFleet(Fleet $fleet): Fleet;
}

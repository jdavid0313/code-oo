<?php

namespace Service;

use Model\Fleet;
use Model\ShipFleet;

interface FleetStorageInterface
{
    public function fetchFleets(): array;

    public function findTeams(): array;

    public function findFleetById($id);

    public function findFleetShipsByFleet(Fleet $fleet): array;

    public function fetchSingleFleetById($id): ?array;

    public function deleteFleet($id): void;

    public function deleteShipFromFleet(ShipFleet $fleetShip): void;

    public function fetchShipInFleetByIds($shipId, $fleetId);

    public function updateShipInFleet(ShipFleet $fleetShip): void;

    public function addSingleShipToFleet(ShipFleet $fleetShip): void;

    public function addFleet(Fleet $fleet): Fleet;

    public function getFleetIdFromName(Fleet $fleet): Fleet;
}

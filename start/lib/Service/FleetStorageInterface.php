<?php

namespace Service;

interface FleetStorageInterface
{
    public function fetchFleets(): array;

    public function findTeams(): array;

    public function findFleetById($id);

    public function fetchShipInFleetByIds($shipId, $fleetId);

    public function fetchSingleFleetById($id): ?array;

    public function addSingleShipToFleet($fleet);
}

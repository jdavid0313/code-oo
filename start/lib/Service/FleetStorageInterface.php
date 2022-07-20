<?php

namespace Service;

interface FleetStorageInterface
{
    public function fetchFleets(): array;

    public function findTeams(): array;

    public function findFleetNameById($id);

    public function fetchShipInFleetById($shipId, $fleetId);

    public function fetchSingleFleetById($id): ?array;

    public function addShipToFleet($fleet);
}

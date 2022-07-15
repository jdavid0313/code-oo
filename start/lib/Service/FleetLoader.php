<?php

namespace Service;

use Model\Fleet;

class FleetLoader
{
    private $fleetStorage;

    public function __construct(FleetStorageInterface $fleetStorage)
    {
        $this->fleetStorage = $fleetStorage;
    }

    public function getFleets(): array
    {
        $types = $this->fleetStorage->findTeams();
        $fleetsData = $this->fleetStorage->fetchFleets();

        $fleets = [];
        foreach ($types as $type) {
            $fleets[$type] = [];
        }

        foreach ($fleetsData as $fleetData) {
            $fleet = $this->createFleetFromData($fleetData);
            $fleets[$fleet->getTeam()][] = $fleet;
        }

        return $fleets;
    }

    private function createFleetFromData($fleetData): Fleet
    {
        $fleet = new Fleet($fleetData['name']);

        $fleet->setId($fleetData['id']);
        $fleet->setTeam($fleetData['team']);
        $fleet->setQuantity($fleetData['sum(ship_fleets.quantity)']);

        return $fleet;
    }
}

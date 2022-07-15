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

    public function getFleets()
    {
        $fleetsData = $this->fleetStorage->fetchFleets();

        $fleets = [];
        foreach ($fleetsData as $fleetData) {
            $fleets[] = $this->createFleetFromData($fleetData);
        }

        return $fleets;
    }

    private function createFleetFromData($fleetData)
    {
        $fleet = new Fleet($fleetData['name']);

        $fleet->setId($fleetData['id']);
        $fleet->setTeam($fleetData['team']);
        $fleet->setQuantity($fleetData['sum(ship_fleets.quantity)']);

        return $fleet;
    }
}

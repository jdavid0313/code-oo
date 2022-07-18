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

    public function getFleetsByTeam(): array
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

    public function getSingleFleetById($id)
    {
        $fleetNames = $this->fleetStorage->findFleetNameById($id);
        $fleetsData = $this->fleetStorage->fetchSingleFleetById($id);

        $fleets = [];
        foreach ($fleetNames as $fleetName) {
            $fleets[$fleetName] = [];
        }

        if ($fleetsData === null) {
            return null;
        }

        foreach ($fleetsData as $fleetData) {
            $fleet = $this->createFleetFromData($fleetData);
            $fleets[$fleet->getName()][] = $fleet;
        }

        return $fleets;
    }

    private function createFleetFromData(array $fleetData): Fleet
    {
        $fleet = new Fleet($fleetData['name']);

        $fleet->setId($fleetData['id']);
        $fleet->setTeam($fleetData['team']);
        $fleet->setQuantity($fleetData['quantity']);

        if (array_key_exists('ship_name', $fleetData)) {
            $fleet->setShipName($fleetData['ship_name']);
        }

        return $fleet;
    }
}

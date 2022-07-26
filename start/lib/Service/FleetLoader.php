<?php

namespace Service;

use Model\Fleet;
use Model\ShipFleet;


class FleetLoader
{
    private $fleetStorage;
    private $shipLoader;

    public function __construct(FleetStorageInterface $fleetStorage, ShipLoader $shipLoader)
    {
        $this->fleetStorage = $fleetStorage;
        $this->shipLoader = $shipLoader;
    }

    public function getFleetsByTeam(): array
    {
        $types = $this->fleetStorage->findTeams();
        $fleetShipData = $this->fleetStorage->fetchFleetsWithShipQuantity();

        $fleets = [];
        foreach ($types as $type) {
            $fleets[$type] = [];
        }

        foreach ($fleetShipData as $fleetData) {
            $fleet = $this->createFleetFromData($fleetData);
            $fleetShip = $this->createFleetShipFromData($fleet, $fleetData);
            $fleets[$fleet->getTeam()][] = $fleetShip;
        }

        return $fleets;
    }

    public function getFleetById($id): Fleet
    {
        $fleetData = $this->fleetStorage->findFleetById($id);

        $fleet = $this->createFleetFromData($fleetData);

        $fleet->setShipFleets($this->getFleetShipsByFleet($fleet));

        return $fleet;
    }

    public function getFleetShipsByFleet(Fleet $fleet): array
    {
        $fleetShipsData = $this->fleetStorage->findFleetShipsByFleet($fleet);

        $fleetShips = [];
        foreach ($fleetShipsData as $fleetShipData) {
            $fleetShips[] = $this->createFleetShipFromData($fleet, $fleetShipData);
        }

        return $fleetShips;
    }

    public function getFleetShipByIds($shipId, $fleetId): ShipFleet
    {
        $fleetData = $this->fleetStorage->findFleetById($fleetId);
        if ($fleetData === null) {
            return null;
        }

        $fleet = $this->createFleetFromData($fleetData);
        $fleetShipData = $this->fleetStorage->fetchShipInFleetByIds($shipId, $fleetId);

        return $this->createFleetShipFromData($fleet, $fleetShipData);
    }

    private function createFleetShipFromData(Fleet $fleet, array $fleetShipData): ShipFleet
    {
        $ship = $this->shipLoader->findOneById($fleetShipData['ship_id']);

        $shipFleet = new ShipFleet();
        $shipFleet->setFleet($fleet);
        $shipFleet->setShip($ship);
        $shipFleet->setQuantity($fleetShipData['quantity']);

        return $shipFleet;
    }

    private function createFleetFromData(array $fleetData): Fleet
    {
        $fleet = new Fleet();

        $fleet->setName($fleetData['name']);
        $fleet->setId($fleetData['id']);
        $fleet->setTeam($fleetData['team']);

        return $fleet;
    }
}

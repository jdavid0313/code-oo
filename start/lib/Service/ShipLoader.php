<?php

namespace Service;

use Model\RebelShip;
use Model\Ship;
use Model\AbstractShip;
use Model\ShipCollection;
use Model\BountyHunterShip;
use Model\Fleet;

class ShipLoader
{
    private $shipStorage;

    public function __construct(ShipStorageInterface $shipStorage)
    {
        $this->shipStorage = $shipStorage;
    }

    public function getShips()
    {
        try {
            $shipsData = $this->shipStorage->fetchAllShipsData();
        } catch (\Exception $e) {
            trigger_error('Exception!'.$e->getMessage());
            $shipsData = [];
        }


        $ships = array();
        foreach ($shipsData as $shipData) {
            $ships[] = $this->createShipFromData($shipData);
        }

        //$ships[] = new BountyHunterShip('Slave 1');
        return new ShipCollection($ships);
    }

    public function getFleets()
    {
        $fleetsData = $this->shipStorage->fetchFleets();
        $fleets = [];
        foreach ($fleetsData as $fleetData) {
            $fleets[] = $this->createFleetFromData($fleetData);
        }

        return $fleets;
    }

    public function searchByName($name): array
    {
        $shipsData = $this->shipStorage->searchShipByName($name);

        $ships = [];
        foreach ($shipsData as $shipData) {
            $ships[] = $this->createShipFromData($shipData);
        }

        return $ships;
    }

    public function findOneById($id): ?AbstractShip
    {
        $shiparray = $this->shipStorage->fetchSingleShipData($id);
        // var_dump($shiparray);die;
        if ($shiparray === null) {
            return null;
        }
        return $this->createShipFromData($shiparray);
    }

    private function createShipFromData(array $shipData): AbstractShip
    {
        if ($shipData['team'] == 'rebel') {
            $ship = new RebelShip($shipData['name']);
        } else {
            $ship = new Ship($shipData['name']);
            $ship->setJediFactor($shipData['jedi_factor']);
        }

        //$ship = new Ship($shipData['name']);
        $ship->setId($shipData['id']);
        $ship->setWeaponPower($shipData['weapon_power']);
        $ship->setStrength($shipData['strength']);
        $ship->setDescription($shipData['description']);
        $ship->setImage($shipData['image']);

        return $ship;
    }

    private function createFleetFromData($fleetData)
    {
        // if ($fleetData['team'] == 'rebel') {
        //     $fleet = new RebelShip($fleetData['name']);
        // } else {
        //     $fleet = new Ship($fleetData['name']);
        //     //$fleet->setJediFactor($fleetData['jedi_factor']);
        // }

        $fleet = new Fleet($fleetData['name']);

        $fleet->setId($fleetData['id']);
        $fleet->setTeam($fleetData['team']);
        $fleet->setQuantity($fleetData['sum(ship_fleets.quantity)']);

        return $fleet;
    }
}

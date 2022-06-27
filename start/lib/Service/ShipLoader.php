<?php 

namespace Service;

use Model\RebelShip;
use Model\Ship;
use Model\AbstractShip;

class ShipLoader
{

    private $shipStorage;

    public function __construct(ShipStorageInterface $shipStorage)
    {
       $this->shipStorage = $shipStorage;
    }

    public function getShips()
    {

        $shipsData = $this->shipStorage->fetchAllShipsData();
       
        $ships = array();
        foreach ($shipsData as $shipData){
            $ships[] = $this->createShipFromData($shipData);
        }

        return $ships;

        

    }

    public function findOneById($id)
    {
        $shiparray = $this->shipStorage->fetchSingleShipData($id);

        return $this->createShipFromData($shiparray);
    }

    private function createShipFromData(array $shipData)
    {
        if ($shipData['team'] == 'rebel'){
            $ship = new RebelShip($shipData['name']);
        }
        else{
            $ship = new Ship($shipData['name']);
            $ship->setJediFactor($shipData['jedi_factor']);
        }

        //$ship = new Ship($shipData['name']);
        $ship->setId($shipData['id']);
        $ship->setWeaponPower($shipData['weapon_power']);
        $ship->setStrength($shipData['strength']);

        return $ship;
    }


}

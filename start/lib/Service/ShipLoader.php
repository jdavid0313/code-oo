<?php 

namespace Service;

use Model\RebelShip;
use Model\Ship;
use Model\AbstractShip;
use Model\ShipCollection;
use Model\BountyHunterShip;

class ShipLoader
{

    private $shipStorage;

    public function __construct(ShipStorageInterface $shipStorage)
    {
       $this->shipStorage = $shipStorage;
    }

    public function getShips()
    {

        try{
            $shipsData = $this->shipStorage->fetchAllShipsData();
        }catch (\Exception $e){
            trigger_error('Exception!'.$e->getMessage());
            $shipsData = [];
        }


        $ships = array();
        foreach ($shipsData as $shipData){
            $ships[] = $this->createShipFromData($shipData);
        }

        //$ships[] = new BountyHunterShip('Slave 1');
        return new ShipCollection($ships);

        

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
        $ship->setDescription($shipData['description']);

        return $ship;
    }


}

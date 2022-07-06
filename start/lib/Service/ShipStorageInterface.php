<?php
namespace Service;

use Model\AbstractShip;

interface ShipStorageInterface
{
    public function fetchAllShipsData();

    public function fetchSingleShipData($id);

    public function updateShip(AbstractShip $ship): void;

    public function addShip(AbstractShip $ship): void;
}

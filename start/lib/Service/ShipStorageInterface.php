<?php
namespace Service;

use Model\AbstractShip;

interface ShipStorageInterface
{
    public function fetchAllShipsData();

    public function fetchSingleShipData($id);

    public function searchShipByName($name): ?array;

    public function fetchShipsByteam($team);

    public function updateShip(AbstractShip $ship): void;

    public function addShip(AbstractShip $ship): void;

    public function deleteShip(AbstractShip $ship): void;
}

<?php
namespace Service;
interface ShipStorageInterface
{
   public function fetchAllShipsData();

   public function fetchSingleShipData($id);
}

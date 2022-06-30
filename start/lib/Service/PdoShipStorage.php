<?php
namespace Service;
class PdoShipStorage implements ShipStorageInterface
{

    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function fetchAllShipsData()
    {
        $pdo = $this->pdo;
        $stmt = $pdo->prepare('SELECT * FROM ship');
        $stmt->execute();
        $shipsarray = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $shipsarray;
    }

    public function fetchSingleShipData($id): ?array
    {
        $pdo = $this->pdo;
        $stmt = $pdo->prepare('SELECT * FROM ship WHERE id = :id');
        $stmt->execute(array('id' => $id));
        $shiparray = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($shiparray === false){
            return null;
        }

        return $shiparray;
    }

    public function deleteSingleShipData()
    {

    }
}

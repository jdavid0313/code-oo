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

    public function updateShip($id, $shipName, $weaponPower, $jediFactor, $strength, $team, $description)
    {
        $pdo = $this->pdo;
        
        $query = 'UPDATE ship SET name = :shipName, weapon_power = :weaponPower, jedi_factor = :jediFactor, strength = :strength, team = :team, description = :description WHERE id = :id';
        
        $stmt = $pdo->prepare($query);

        $stmt->bindParam(':name', $shipName ); 
        $stmt->bindParam(':weaponPower', $weaponPower );      
        $stmt->bindParam(':jediFactor', $jediFactor );      
        $stmt->bindParam(':strength', $strength );      
        $stmt->bindParam(':team', $team );  
        $stmt->bindParam(':description', $description );
        $stmt->bindParam(':id', $id );      
        var_dump($stmt);die;
        $stmt->execute();
    }

    public function deleteSingleShipData()
    {

    }
}

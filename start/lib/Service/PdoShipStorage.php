<?php
namespace Service;

use Model\AbstractShip;

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

        if ($shiparray === false) {
            return null;
        }

        return $shiparray;
    }

    public function updateShip(AbstractShip $ship): void
    {
        $pdo = $this->pdo;

        $query = 'UPDATE ship SET name = :shipName, weapon_power = :weaponPower, jedi_factor = :jediFactor, strength = :strength, description = :description WHERE id = :id';

        $stmt = $pdo->prepare($query);

        $stmt->bindParam(':shipName', $ship->getName());
        $stmt->bindParam(':weaponPower', $ship->getWeaponPower());
        $stmt->bindParam(':jediFactor', $ship->getJediFactor());
        $stmt->bindParam(':strength', $ship->getStrength());
        $stmt->bindParam(':description', $ship->getDescription());
        $stmt->bindParam(':id', $ship->getId());

        $stmt->execute();
    }

    public function addShip(AbstractShip $ship): void
    {
        $query = 'INSERT INTO ship (name, team, weapon_power, jedi_factor, strength, description) VALUES (:shipName, :team, :weaponPower, :jediFactor, :strength, :description)';

        $statement = $this->pdo->prepare($query);

        $statement->bindParam(':shipName', $ship->getName());
        $statement->bindParam(':team', strtolower($ship->getType()));
        $statement->bindParam(':weaponPower', $ship->getWeaponPower());
        $statement->bindParam(':jediFactor', $ship->getJediFactor());
        $statement->bindParam(':strength', $ship->getStrength());
        $statement->bindParam(':description', $ship->getDescription());

        $statement->execute();
    }

    public function deleteShip(AbstractShip $ship): void
    {
        $query = 'DELETE FROM ship where id = :id';

        $stmt = $this->pdo->prepare($query);

        $stmt->bindParam(':id', $ship->getId());

        $stmt->execute();
    }
}

<?php

namespace Service;

use Model\Fleet;
use Model\ShipFleet;

class PdoFleetStorage implements FleetStorageInterface
{
    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function fetchFleets(): array
    {
        $query = 'SELECT fleets.id, fleets.name, ship_fleets.ship_id, fleets.team, sum(ship_fleets.quantity) quantity FROM fleets JOIN ship_fleets ON fleets.id = ship_fleets.fleet_id GROUP BY fleets.name;';
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        $shipFleetArray = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $shipFleetArray;
    }

    public function findTeams(): array
    {
        $query = 'SELECT
                f.team
            FROM
                fleets f
            GROUP BY
                f.team';

        $statement = $this->pdo->prepare($query);
        $statement->execute();

        $results = $statement->fetchAll();

        $teams = [];
        foreach ($results as $result) {
            $teams[] = $result['team'];
        }

        return $teams;
    }

    public function findFleetById($id): array
    {
        $query = 'SELECT * FROM fleets WHERE id = :id';

        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':id',$id);
        $stmt->execute();
        $results = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $results;
    }

    public function findFleetShipsByFleet(Fleet $fleet): array
    {
        $query = 'SELECT * FROM ship_fleets WHERE fleet_id = :fleetId';

        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':fleetId', $fleet->getId());
        $stmt->execute();
        $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $results;
    }

    public function fetchSingleFleetById($id): ?array
    {
        $query = 'SELECT fleets.id, ship.id ship_id, ship.name ship_name, fleets.name, fleets.team, sum(ship_fleets.quantity) quantity FROM fleets JOIN ship_fleets ON fleets.id = ship_fleets.fleet_id JOIN ship ON ship.id = ship_fleets.ship_id WHERE fleets.id = :id GROUP BY ship_name';
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $fleet = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        if ($fleet === []) {
            return null;
        }

        return $fleet;
    }

    public function deleteFleet(Fleet $fleet): void
    {
        $query = 'DELETE FROM ship_fleets WHERE fleet_id = :id';
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':id', $fleet->getId());
        $stmt->execute();

        $query = 'DELETE FROM fleets WHERE id = :id';
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':id', $fleet->getId());
        $stmt->execute();
    }

    public function deleteShipFleet(ShipFleet $fleetShip): void
    {
        $query = 'DELETE FROM ship_fleets WHERE fleet_id = :fleetId AND ship_id = :shipId';
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':fleetId', $fleetShip->getFleet()->getId());
        $stmt->bindValue('shipId', $fleetShip->getShip()->getId());
        $stmt->execute();
    }

    public function fetchShipInFleetByIds($shipId, $fleetId): array
    {
        $query = 'SELECT * from ship_fleets WHERE fleet_id = :fleet_id AND ship_id = :ship_id';
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':ship_id', $shipId);
        $stmt->bindValue(':fleet_id', $fleetId);
        $stmt->execute();
        $fleetShipData = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($fleetShipData === false) {
            $fleetShipData = null;
        }

        return $fleetShipData;
    }

    public function updateShipFleet(ShipFLeet $fleetShip): void
    {
        $query = 'UPDATE ship_fleets SET quantity = :quantity WHERE fleet_id = :fleetId AND ship_id = :shipId';
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':quantity',$fleetShip->getQuantity());
        $stmt->bindValue(':fleetId', $fleetShip->getFleet()->getId());
        $stmt->bindValue(':shipId', $fleetShip->getShip()->getId());
        $stmt->execute();
    }

    public function addShipFleet(ShipFleet $fleetShip): void
    {
        $query = 'INSERT INTO ship_fleets (fleet_id, ship_id, quantity) VALUES (:fleetId, :shipId, :quantity)';
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':fleetId', $fleetShip->getFleet()->getId());
        $stmt->bindValue(':shipId', $fleetShip->getShip()->getId());
        $stmt->bindValue(':quantity', $fleetShip->getQuantity());
        $stmt->execute();
    }

    public function addFleet(Fleet $fleet): Fleet
    {
        $query = 'INSERT INTO fleets (name, team) VALUES (:name, :team)';
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':name', $fleet->getName());
        $stmt->bindValue(':team', strtolower($fleet->getTeam()));
        $stmt->execute();

        $fleet = $this->getFleetIdFromName($fleet);

        return $fleet;

    }

    public function getFleetIdFromName(Fleet $fleet): Fleet
    {
        $query = 'SELECT id FROM fleets WHERE name = :name';
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':name', $fleet->getName());
        $stmt->execute();
        $results = $stmt->fetch(\PDO::FETCH_ASSOC);
        $fleet->setId($results['id']);

        return $fleet;
    }

}

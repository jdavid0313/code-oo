<?php

namespace Service;

class PdoFleetStorage implements FleetStorageInterface
{
    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function fetchFleets(): array
    {
        $query = 'SELECT fleets.id, fleets.name, fleets.team, sum(ship_fleets.quantity) quantity FROM fleets JOIN ship_fleets ON fleets.id = ship_fleets.fleet_id GROUP BY fleets.name;';
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        $fleetArray = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $fleetArray;
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

    public function findFleetNameById($id)
    {
        $query = 'SELECT fleets.name FROM fleets WHERE id = :id';

        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id',$id);
        $stmt->execute();
        $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $fleetName = [];
        foreach ($results as $result) {
            $fleetName[] = $result['name'];
        }

        return $fleetName;
    }

    public function fetchSingleFleetById($id): ?array
    {
        $query = 'SELECT fleets.id, ship.id ship_id, ship.name ship_name, fleets.name, fleets.team, sum(ship_fleets.quantity) quantity FROM fleets JOIN ship_fleets ON fleets.id = ship_fleets.fleet_id JOIN ship ON ship.id = ship_fleets.ship_id WHERE fleets.id = :id GROUP BY ship_name';
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $fleet = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        if ($fleet === []) {
            return null;
        }

        return $fleet;
    }

    public function deleteFleet($id)
    {
        $query = 'DELETE FROM ship_fleets WHERE fleet_id = :id';
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $query = 'DELETE FROM fleets WHERE id = :id';
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public function deleteShipFromFleet($fleetShip)
    {
        $query = 'DELETE FROM ship_fleets WHERE fleet_id = :fleetId AND ship_id = :shipId';
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':fleetId', $fleetShip->getId());
        $stmt->bindParam('shipId', $fleetShip->getShipId());
        $stmt->execute();
    }

    public function fetchShipInFleetById($shipId, $fleetId)
    {
        $query = 'SELECT fleets.id, ship.id ship_id, ship.name ship_name, fleets.name, fleets.team, ship_fleets.quantity quantity FROM fleets JOIN ship_fleets ON fleets.id = ship_fleets.fleet_id JOIN ship ON ship.id = ship_fleets.ship_id WHERE ship_fleets.ship_id = :ship_id AND fleets.id = :fleet_id';
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':ship_id', $shipId);
        $stmt->bindParam(':fleet_id', $fleetId);
        $stmt->execute();

        $fleetShip = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($fleetShip === false) {
            $fleetShip = null;
        }

        return $fleetShip;
    }

    public function updateShipInFleet($fleetShip)
    {
        $query = 'UPDATE ship_fleets SET quantity = :quantity WHERE fleet_id = :fleetId AND ship_id = :shipId';
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':quantity',$fleetShip->getQuantity());
        $stmt->bindParam(':fleetId', $fleetShip->getId());
        $stmt->bindParam(':shipId', $fleetShip->getShipId());
        $stmt->execute();
    }

    public function addShipToFleet($fleet)
    {
        $query = 'INSERT INTO ship_fleets (fleet_id, ship_id, quantity) VALUES (:fleetId, :shipId, :quantity)';
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':fleetId', $fleet->getId());
        $stmt->bindParam(':shipId', $fleet->getShipId());
        $stmt->bindParam(':quantity', $fleet->getQuantity());
        $stmt->execute();
    }

    public function addShipsToFleet($fleet)
    {
        foreach ($fleet->getShipId() as $ship):
            $query = 'INSERT INTO ship_fleets (fleet_id, ship_id, quantity) VALUES (:fleetId, :shipId, :quantity)';
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':fleetId', $fleet->getId());
            $stmt->bindParam(':shipId', $ship);
            $stmt->bindParam(':quantity', $fleet->getQuantity());
            $stmt->execute();
        endforeach;
    }

    public function addFleet($fleet)
    {
        $query = 'INSERT INTO fleets (name, team) VALUES (:name, :team)';
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':name', $fleet->getName());
        $stmt->bindParam(':team', strtolower($fleet->getTeam()));
        $stmt->execute();

        $fleet = $this->getIdFromName($fleet);
        $fleet->setQuantity(0);
        $this->addShipsToFleet($fleet);

    }

    private function getIdFromName($fleet)
    {
        $query = 'SELECT id FROM fleets WHERE name = :name';
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':name', $fleet->getName());
        $stmt->execute();
        $results = $stmt->fetch(\PDO::FETCH_ASSOC);
        $fleet->setId($results['id']);

        return $fleet;
    }

}

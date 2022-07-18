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
        $query = 'SELECT fleets.id, ship.name ship_name, fleets.name, fleets.team, ship_fleets.quantity FROM fleets JOIN ship_fleets ON fleets.id = ship_fleets.fleet_id JOIN ship ON ship.id = ship_fleets.ship_id WHERE fleets.id = :id';
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $fleet = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        if ($fleet === []) {
            return null;
        }

        return $fleet;
    }
}

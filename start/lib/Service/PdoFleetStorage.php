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
        $query = 'SELECT fleets.id, fleets.name, fleets.team, sum(ship_fleets.quantity) FROM fleets JOIN ship_fleets ON fleets.id = ship_fleets.fleet_id GROUP BY fleets.name;';
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        $fleetArray = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $fleetArray;
    }
}
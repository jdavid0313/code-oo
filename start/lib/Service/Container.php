<?php
namespace Service;

class Container
{
    private $configuration;
    private $pdo;
    private $shipLoader;
    private $fleetLoader;
    private $shipStorage;
    private $battleManager;
    private $fleetStorage;

    public function __construct(array $configuration)
    {
        $this->configuration = $configuration;
    }

    public function getPDO()
    {
        if ($this->pdo === null) {
            $this->pdo = new \PDO(
                $this->configuration['db_dsn'],
                $this->configuration['db_user'],
                $this->configuration['db_pass']
            );
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }
        return $this->pdo;
    }

    public function getShipLoader()
    {
        if ($this->shipLoader === null) {
            $this->shipLoader = new ShipLoader($this->getShipStorage());
        }

        return $this->shipLoader;
    }

    public function getFleetLoader()
    {
        if ($this->fleetLoader === null) {
            $fleetStorage = new PdoFleetStorage($this->getPDO());
            $this->fleetLoader = new FleetLoader($fleetStorage, $this->getShipLoader());
        }

        return $this->fleetLoader;
    }

    public function getFleetStorage()
    {
        if ($this->fleetStorage === null) {
            $this->fleetStorage = new PdoFleetStorage($this->getPDO());
        }

        return $this->fleetStorage;
    }

    public function getShipStorage()
    {
        if ($this->shipStorage === null) {
            $this->shipStorage = new PdoShipStorage($this->getPDO());
            //$this->shipStorage = new JsonFileShipStorage(__DIR__.'/../../resources/ships.json');

            //$this->shipStorage = new LoggableShipStorage($this->shipStorage);
        }

        return $this->shipStorage;
    }

    public function getBattleManager()
    {
        if ($this->battleManager === null) {
            $this->battleManager = new BattleManager();
        }

        return $this->battleManager;
    }
}

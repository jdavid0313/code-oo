<?php 


class ShipLoader{

    private $pdo;

    private $dbDsn;

    private $dbUser;

    private $dbPass;


    public function __construct(PDO $pdo)
    {
       $this->pdo = $pdo;
    }

    public function getShips()
    {

        $shipsData = $this->queryForShip();
       
        $ships = array();
        foreach ($shipsData as $shipData){
            $ships[] = $this->createShipFromData($shipData);
        }

        return $ships;

    }

    public function findOneById($id)
    {
        $pdo = $this->getPDO();
        $stmt = $pdo->prepare('SELECT * FROM ship WHERE id = :id');
        $stmt->execute(array('id' => $id));
        $shiparray = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$shiparray){
            return null;
        }

        return $this->createShipFromData($shiparray);
    }

    private function createShipFromData(array $shipData)
    {
        if ($shipData['team'] == 'rebel'){
            $ship = new RebelShip($shipData['name']);
        }
        else{
            $ship = new Ship($shipData['name']);
        }

        //$ship = new Ship($shipData['name']);
        $ship->setId($shipData['id']);
        $ship->setWeaponPower($shipData['weapon_power']);
        $ship->setJediFactor($shipData['jedi_factor']);
        $ship->setStrength($shipData['strength']);

        return $ship;

    }

    private function queryForShip()
    {

        $pdo = $this->getPDO();
        $stmt = $pdo->prepare('SELECT * FROM ship');
        $stmt->execute();
        $shipsarray = $stmt->fetchAll(PDO::FETCH_ASSOC);

        

        return $shipsarray;
    }

    private function getPDO()
    {
        return $this->pdo;
    }
}

<?php

namespace Service;

use Model\BattleResult;
use Model\AbstractShip;
use Model\Fleet;
use Model\ShipFleet;

class BattleManager{


    const TYPE_NORMAL = 'type_normal';
    const TYPE_NO_JEDI = 'no_jedi';
    const TYPE_ONLY_JEDI = 'only_jedi';

    public static function battleTypes()
    {
        return [
            'Normal' => BattleManager::TYPE_NORMAL,
            'No Jedi Powers' => BattleManager::TYPE_NO_JEDI,
            'Only Jedi Powers' => BattleManager::TYPE_ONLY_JEDI
        ];
    }

    public function battleFleet(Fleet $fleet1, Fleet $fleet2, $battleType)
    {
        $fleet1Ships = $fleet1->getShipFleets();
        $fleet2Ships = $fleet2->getShipFleets();

        $fleet1Health = 0;
        foreach ($fleet1Ships as $shipFleet) {
            $fleet1Health += $shipFleet->getShip()->getStrength() * $shipFleet->getQuantity();
        }

        $fleet2Health = 0;
        foreach ($fleet2Ships as $shipFleet) {
            $fleet2Health += $shipFleet->getShip()->getStrength() * $shipFleet->getQuantity();
        }

        do {
            $ship1 = $fleet1->getRandomShip();
            $ship2 = $fleet2->getRandomShip();

            $ship1OriginalHealth = $ship1->getQuantity();
            $ship2OriginalHealth = $ship2->getQuantity();

            $battleResult = $this->battle($ship1, $ship2, $battleType);

            //var_dump($battleResult->getWinningShip()->getShip()->getId());die;

            //var_dump($ship1->getShip()->getId() == $battleResult->getWinningShip()->getShip()->getId());die;
            if ($ship1->getShip()->getId() == $battleResult->getWinningShip()->getShip()->getId()) {
                $ship1 = $battleResult->getWinningShip();
                $ship2 = $battleResult->getLosingShip();
            } elseif ($ship2->getShip()->getId() == $battleResult->getWinningShip()->getShip()->getId()) {
                $ship1 = $battleResult->getLosingShip();
                $ship2 = $battleResult->getWinningShip();
            }

            $fleet1Health = $ship1OriginalHealth - $ship1->getShip()->getStrength();
            $fleet2Health = $ship2OriginalHealth - $ship2->getShip()->getStrength();

            if ($ship1->getShip()->getStrength() <= 0) {
                $fleet1->decrementShipFleet($ship1);
            }
            if ($ship2->getShip()->getStrength() <= 0) {
                $fleet2->decrementShipFleet($ship2);
            }

        } while ($fleet1Health > 0 && $fleet2Health > 0);

        if ($fleet1Health <= 0) {
            $battleResult->setLosingFleet($fleet1);
            $battleResult->setWinningFleet($fleet2);
        } else {
            $battleResult->setWinningFleet($fleet1);
            $battleResult->setLosingFleet($fleet2);
        }

        return $battleResult;
    // the battle is now over - one fleet has all of their ship_fleets destroyed

    // we have updated the ship_fleets above - now we need to save them to the db
    foreach ($fleet1->getShipFleets() as $sf):
        $this->fleetLoader->updateShipFleets($sf); // this method should loop over each ship_fleet and update the quantity for each
    endforeach;

    foreach ($fleet2->getShipFleets() as $sf):
        $this->fleetLoader->updateShipFleets($sf);
    endforeach;

    }

    public function battle(ShipFleet $ship1, ShipFleet $ship2, $battleType)
    {

        $ship1Health = $ship1->getShip()->getStrength();
        $ship2Health = $ship2->getShip()->getStrength();

        $ship1UsedJediPowers = false;
        $ship2UsedJediPowers = false;
        $i = 0;
        while ($ship1Health > 0 && $ship2Health > 0) {
            // first, see if we have a rare Jedi hero event!
            if ($battleType != self::TYPE_NO_JEDI && $this->didJediDestroyShipUsingTheForce($ship1)) {
                $ship2Health = 0;
                $ship1UsedJediPowers = true;

                break;
            }
            if ($battleType != self::TYPE_NO_JEDI && $this->didJediDestroyShipUsingTheForce($ship2)) {
                $ship1Health = 0;
                $ship2UsedJediPowers = true;

                break;
            }

            if ($battleType != self::TYPE_ONLY_JEDI){
                // now battle them normally
                $ship1Health = $ship1Health - $ship2->getShip()->getWeaponPower();
                $ship2Health = $ship2Health - $ship1->getShip()->getWeaponPower();
            }

            if ($i == 100){
                $ship1Health = 0;
                $ship2Health = 0;

            }
            $i++;
        }

        $ship1->getShip()->setStrength($ship1Health);
        $ship2->getShip()->setStrength($ship2Health);
        //var_dump($ship1->getStrength(), $ship2->getStrength() );die;

        if ($ship1Health <= 0 && $ship2Health <= 0) {
            // they destroyed each other
            $winningShip = null;
            $losingShip = null;
            $usedJediPowers = $ship1UsedJediPowers || $ship2UsedJediPowers;
        } elseif ($ship1Health <= 0) {
            $winningShip = $ship2;
            $losingShip = $ship1;
            $usedJediPowers = $ship2UsedJediPowers;
            //$losingShip->setQuantity($losingShip->getQuantity() - $ship1Quantity);
        } else {
            $winningShip = $ship1;
            $losingShip = $ship2;
            $usedJediPowers = $ship1UsedJediPowers;
            //$losingShip->setQuantity($losingShip->getQuantity() - $ship2Quantity);
        }

        return new BattleResult($usedJediPowers, $winningShip, $losingShip);

    }

    private function didJediDestroyShipUsingTheForce(ShipFleet $ship)
    {
        $jediHeroProbability = $ship->getShip()->getJediFactor() / 100;

        return mt_rand(1, 100) <= ($jediHeroProbability*100);
    }
}

<?php
namespace Service;
use Model\AbstractShip;
class ErrorHandling
{
    public static function errorCheckShip(AbstractShip $ship): array
    {
        $errors = [];
        if (empty(trim($ship->getName()))) {
            $errors[] = "Please enter ship name";
        }

        if (empty(trim($ship->getWeaponPower()))) {
            $errors[] = "Please enter weapon power";
        } elseif (is_numeric($ship->getWeaponPower()) === false || ($ship->getWeaponPower() < 0)) {
            $errors[] = "Invalid weapon power entered";
        }

        if (empty(trim($ship->getJediFactor()))) {
            $errors[] = "Please enter Jedi Factor";
        } elseif (is_numeric($ship->getJediFactor()) === false || ($ship->getJediFactor() < 0)) {
            $errors[] = "Invalid jedi factor entered";
        }

        if (empty(trim($ship->getStrength()))) {
            $errors[] = "Please enter ship strength";
        } elseif (is_numeric($ship->getStrength()) === false || ($ship->getStrength() < 0)) {
            $errors[] = "Invalid strength entered";
        }

        if (empty(trim($ship->getDescription()))) {
            $errors[] = "Please enter ship description";
        }

        return $errors;
    }
}

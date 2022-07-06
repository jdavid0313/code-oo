<?php

namespace Model;

class RebelShip extends AbstractShip
{
    use SettableJediFactorTrait;

    public function getType()
    {
        return AbstractShip::REBEL;
    }

    public function isFunctional()
    {
        return true;
    }

    public function getNameAndSpecs($shortformat = false)
    {
        $val = parent::getNameAndSpecs($shortformat);
        $val .= ' (Rebel)';

        return $val;
    }

    public function getJediFactor()
    {
        if ($this->jediFactor === 0) {
            $this->jediFactor = rand(10, 30);
        }

        // if ($this->getType() == 'Empire'){
        //     $this->jediFactor = 0;
        // }

        return $this->jediFactor;
    }
}

<?php

namespace Model;

trait SettableJediFactorTrait
{
    protected $jediFactor = 0;

    public function setJediFactor($jediFactor)
    {
        $this->jediFactor = $jediFactor;
    }

    // public function getJediFactor()
    // {
    //     if ($this->jediFactor === 0){
    //         $this->jediFactor = rand(10,30);
    //     }

    //     return $this->jediFactor;
    // }   

    public function getJediFactor()
    {

        return $this->jediFactor;
    }
}

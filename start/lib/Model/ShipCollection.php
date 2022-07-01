<?php

namespace Model;

class ShipCollection implements \ArrayAccess, \IteratorAggregate
{
    private $ships;

    public function __construct(array $ships)
    {
        $this->ships = $ships;
    }

    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->ships);
    }

    public function offsetGet($offset)
    {
        return $this->offset;
    }

    public function offsetSet($offset, $value)
    {
        $this->ships[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        unset($this->offset);
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->ships);
    }
}

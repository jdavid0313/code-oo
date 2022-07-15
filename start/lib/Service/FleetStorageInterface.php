<?php

namespace Service;

interface FleetStorageInterface
{
    public function fetchFleets(): array;

    public function findTeams(): array;
}

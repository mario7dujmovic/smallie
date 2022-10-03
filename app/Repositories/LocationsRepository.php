<?php

namespace App\Repositories;

class LocationsRepository extends AbstractRepository
{
    public function insertLocation($data)
    {
        return $this->getDb()::table('locations')->insertGetId($data);
    }
}

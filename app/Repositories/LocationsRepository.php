<?php

namespace App\Repositories;

class LocationsRepository extends AbstractRepository
{
    public function getLocation($id)
    {
        return $this->getDb()::table('locations')->where('id', $id)->first();
    }

    public function insertLocation($data)
    {
        return $this->getDb()::table('locations')->insertGetId($data);
    }
}

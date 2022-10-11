<?php

namespace App\Repositories;

class LocationsRepository extends AbstractRepository
{
    public function getLocation($id)
    {
        return $this->getDb()::table('locations')->where('id', $id)->first();
    }

    public function getLocationsByQueryString($queryString)
    {
        $query = $this->getDb()::table('locations');
        foreach($queryString as $key => $value) {
            $query->where($key, 'like', '%' . $value . '%');
        }
        return $query->get();
    }

    public function deleteLocation($id)
    {
        return $this->getDb()::table('locations')->where('id', $id)->delete();
    }

    public function insertLocation($data)
    {
        return $this->getDb()::table('locations')->insertGetId($data);
    }
}

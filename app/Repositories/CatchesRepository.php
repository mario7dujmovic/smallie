<?php

namespace App\Repositories;

class CatchesRepository extends AbstractRepository
{
    public function getCatch($id)
    {
        return $this->getDb()::table('catches')->where('id', $id)->first();
    }

    public function deleteCatch($id)
    {
        return $this->getDb()::table('catches')->where('id', $id)->delete();
    }

    public function insertCatches($data)
    {
        return $this->getDb()::table('catches')->insertGetId($data);
    }
}

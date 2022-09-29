<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class AbstractRepository
{
    private $db = null;

    public function getDb()
    {
        if($this->db === null)
        {
            $this->db = DB::class;
        }
        return $this->db;
    }

    public function setDb($db)
    {
        $this->db = $db;
    }
}

<?php

namespace App\Repositories;
class UserRepository extends AbstractRepository
{
    public function getUserByToken($api_key)
    {
        return $this->getDb()::table('api_keys')->select('user_id')->where('api_key', $api_key)->first();
    }

    public function getTokenEntry($api_key)
    {
        return $this->getDb()::table('api_keys')->where('api_key', $api_key)->first();
    }

    public function insertUserApiToken($data)
    {
        return $this->getDb()::table('api_keys')->insertGetId($data);
    }

    public function getUserByEmail($email)
    {
        return $this->getDb()::table('users')->where('email', $email)->first();
    }

    public function authenticateUser($email, $password)
    {
        return $this->getDb()::table('users')->where('email', '=', $email)->where('password', '=', $password)->first();
    }

    public function insertUser($data)
    {
        return $this->getDb()::table('users')->insertGetId($data);
    }
}

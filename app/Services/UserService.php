<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Exception;

class UserService
{
    private $userRepo = null;

    public function createUser($data)
    {
        if (!$this->isValidUserData($data)) throw new Exception("Something went wrong.");
        return $this->getUserRepo()->insertUser($data);
    }

    private function isValidUserData($data)
    {
        if ($this->isEmailValid($data['email']) && $this->isPasswordValid($data['password'])) return true;
    }

    /**
     * @return UserRepository
     */
    public function getUserRepo()
    {
        if ($this->userRepo == null) {
            $this->userRepo = new UserRepository();
        }
        return $this->userRepo;
    }

    /**
     * @param null $userRepo
     */
    public function setUserRepo($userRepo): void
    {
        $this->userRepo = $userRepo;
    }

    public function generateApiKey()
    {
        $key = bin2hex(random_bytes(40));
        if (!empty($this->getUserRepo()->getUserByToken($key))) $key = $this->generateApiKey();
        return $key;
    }

    private function isEmailValid($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        if (!empty($this->getUserRepo()->getUserByEmail($email))) {
            return false;
        }

        return true;
    }

    private function isPasswordValid($password)
    {
        $containsSmallLetter = preg_match('/[a-z]/', $password);
        $containsCapsLetter = preg_match('/[A-Z]/', $password);
        $containsDigit = preg_match('/\d/', $password);
        $containsSpecial = preg_match('/[^a-zA-Z\d]/', $password);
        return ($containsSmallLetter && $containsCapsLetter && $containsDigit && $containsSpecial && strlen($password) > 8);
    }
}

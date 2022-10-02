<?php

namespace App\Http\Controllers;

use App\Entities\Location;
use App\Services\UserService;

class LocationController extends Controller
{
    private ?Location $location = null;
    private $user = null;
    private ?UserService $userService = null;

    public function create()
    {
        $this->hydrateLocation($this->getData());
        // got to the point where the data hydrates right
        echo print_r($this->getLocation(), true);
    }

    public function hydrateLocation($data)
    {
        if (!isset($data->user_id)) $data->user_id = $this->getUser()->user_id;
        if (!isset($data->created_at)) $data->created_at = date('Y-m-d H:i:s');
        if (!isset($data->updated_at)) $data->updated_at = null;
        $this->getLocation()->setUserId($data->user_id);
        $this->getLocation()->setName($data->name);
        $this->getLocation()->setLatitude($data->latitude);
        $this->getLocation()->setLongitude($data->longitude);
        $this->getLocation()->setCreatedAt($data->created_at);
        $this->getLocation()->setUpdatedAt($data->updated_at);
    }

    /**
     * @return Location|null
     */
    public function getLocation(): ?Location
    {
        if ($this->location == null) {
            $this->location = new Location();
        }
        return $this->location;
    }

    /**
     * @return null
     */
    public function getUser()
    {
        if ($this->user == null) {
            $this->user = $this->getUserService()->getUserRepo()->getUserByToken($this->getRequest()->bearerToken());
        }
        return $this->user;
    }

    /**
     * @param null $user
     */
    public function setUser($user): void
    {
        $this->user = $user;
    }

    /**
     * @param Location|null $location
     */
    public function setLocation(?Location $location): void
    {
        $this->location = $location;
    }

    /**
     * @return UserService|null
     */
    public function getUserService(): ?UserService
    {
        if ($this->userService == null) {
            $this->userService = new UserService();
        }
        return $this->userService;
    }

    /**
     * @param UserService|null $userService
     */
    public function setUserService(?UserService $userService): void
    {
        $this->userService = $userService;
    }


}

<?php

namespace App\Http\Controllers;

use App\Entities\Location;
use App\Repositories\LocationsRepository;
use App\Services\LocationsService;
use App\Services\UserService;
use Exception;

class LocationsController extends Controller
{
    private ?Location $location = null;
    private $user = null;
    private ?UserService $userService = null;
    private ?LocationsRepository $locationsRepository = null;
    private ?LocationsService $locationsService = null;

    public function create()
    {
        try {
            $this->hydrateLocation($this->getData());
            $this->getLocationsService()->addLocation($this->getLocation());
            $code = 201;
            $message = $this->getLocation()->getArray();
        } catch (Exception $e) {
            $code = $e->getCode();
            $message = $e->getMessage();
            if ($code > 1000) { //this block of code handles database exceptions
                $message = "Database error";
                if ($code == 1045) {
                    $message = "Could not connect to the database.";
                }
                $code = 400;
            }
        }
        return response()->json($message, $code);
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

    /**
     * @return LocationsRepository|null
     */
    public function getLocationsRepository(): ?LocationsRepository
    {
        if ($this->locationsRepository == null) {
            $this->locationsRepository = new LocationsRepository();
        }
        return $this->locationsRepository;
    }

    /**
     * @param LocationsRepository|null $locationsRepository
     */
    public function setLocationsRepository(?LocationsRepository $locationsRepository): void
    {
        $this->locationsRepository = $locationsRepository;
    }

    /**
     * @return LocationsService|null
     */
    public function getLocationsService(): ?LocationsService
    {
        if ($this->locationsService == null) {
            $this->locationsService = new LocationsService($this->getLocationsRepository());
        }
        return $this->locationsService;
    }

    /**
     * @param LocationsService|null $locationsService
     */
    public function setLocationsService(?LocationsService $locationsService): void
    {
        $this->locationsService = $locationsService;
    }
}

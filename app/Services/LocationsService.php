<?php

namespace App\Services;

use App\Entities\Location;
use App\Repositories\LocationsRepository;

class LocationsService
{
    private ?LocationsRepository $locationsRepository = null;

    public function __construct(LocationsRepository $locationsRepository)
    {
        $this->locationsRepository = $locationsRepository;
    }

    public function getLocation($id)
    {
        return $this->getLocationsRepository()->getLocation($id);
    }

    public function getLocationsByQueryString($queryString)
    {
        return $this->getLocationsRepository()->getLocationsByQueryString($queryString);
    }

    public function deleteLocation($id)
    {
        return $this->getLocationsRepository()->deleteLocation($id);
    }

    public function addLocation(Location $location)
    {
        $dataArray = $this->createDataArray($location);
        return $this->getLocationsRepository()->insertLocation($dataArray);
    }

    private function createDataArray(Location $location)
    {
        return [
            'user_id' => $location->getUserId(),
            'latitude' => $location->getLatitude(),
            'longitude' => $location->getLongitude(),
            'name' => $location->getName(),
            'created_at' => $location->getCreatedAt(),
            'updated_at' => $location->getUpdatedAt()
        ];
    }

    /**
     * @return LocationsRepository|null
     */
    public function getLocationsRepository(): ?LocationsRepository
    {
        return $this->locationsRepository;
    }

    /**
     * @param LocationsRepository|null $locationsRepository
     */
    public function setLocationsRepository(?LocationsRepository $locationsRepository): void
    {
        $this->locationsRepository = $locationsRepository;
    }
}

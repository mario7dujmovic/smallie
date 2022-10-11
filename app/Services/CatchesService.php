<?php

namespace App\Services;

use App\Entities\CatchEntity;
use App\Repositories\CatchesRepository;

class CatchesService
{
    private ?CatchesRepository $catchesRepository = null;

    public function __construct(CatchesRepository $catchesRepository)
    {
        $this->catchesRepository = $catchesRepository;
    }

    public function getCatch($id)
    {
        return $this->getCatchesRepository()->getCatch($id);
    }

    public function deleteCatch($id)
    {
        return $this->getCatchesRepository()->deleteCatch($id);
    }

    public function insertCatches($catch)
    {
        $dataArray = $this->createDataArray($catch);
        return $this->getCatchesRepository()->insertCatches($dataArray);
    }

    /**
     * @return CatchesRepository|null
     */
    public function getCatchesRepository(): ?CatchesRepository
    {
        return $this->catchesRepository;
    }

    /**
     * @param CatchesRepository|null $catchesRepository
     */
    public function setCatchesRepository(?CatchesRepository $catchesRepository): void
    {
        $this->catchesRepository = $catchesRepository;
    }

    /**
     * @param CatchEntity $catch
     * @return array
     */
    private function createDataArray(CatchEntity $catch)
    {
        return [
            'user_id' => $catch->getUserId(),
            'weight' => $catch->getWeight(),
            'length' => $catch->getLength(),
            'name' => $catch->getName(),
            'location_id' => $catch->getLocationId(),
            'img_url' => $catch->getImgUrl(),
            'created_at' => $catch->getCreatedAt(),
            'updated_at' => $catch->getUpdatedAt()
        ];
    }
}

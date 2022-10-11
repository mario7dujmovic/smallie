<?php

namespace App\Entities;

class CatchEntity
{
    private $id = null;
    private $userId = null;
    private $name = null;
    private $weight = null;
    private $length = null;
    private $imgUrl = null;
    private $locationId = null;
    private $createdAt = null;
    private $updatedAt = null;

    /**
     * @return array
     */
    public function getArray()
    {
        return [
            'id' => $this->id,
            'user_id' => $this->userId,
            'name' => $this->name,
            'weight' => $this->weight,
            'length' => $this->length,
            'img_url' => $this->imgUrl,
            'location_id' => $this->locationId,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt
        ];
    }

    /**
     * @return null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param null $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return null
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param null $userId
     */
    public function setUserId($userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @return null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param null $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return null
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @param null $weight
     */
    public function setWeight($weight): void
    {
        $this->weight = $weight;
    }

    /**
     * @return null
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * @param null $length
     */
    public function setLength($length): void
    {
        $this->length = $length;
    }

    /**
     * @return null
     */
    public function getImgUrl()
    {
        return $this->imgUrl;
    }

    /**
     * @param null $imgUrl
     */
    public function setImgUrl($imgUrl): void
    {
        $this->imgUrl = $imgUrl;
    }

    /**
     * @return null
     */
    public function getLocationId()
    {
        return $this->locationId;
    }

    /**
     * @param null $locationId
     */
    public function setLocationId($locationId): void
    {
        $this->locationId = $locationId;
    }

    /**
     * @return null
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param null $createdAt
     */
    public function setCreatedAt($createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return null
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param null $updatedAt
     */
    public function setUpdatedAt($updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}

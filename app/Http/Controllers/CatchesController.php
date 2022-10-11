<?php

namespace App\Http\Controllers;

use App\Entities\CatchEntity;
use App\Repositories\CatchesRepository;
use App\Services\CatchesService;
use App\Services\UserService;
use Exception;

class CatchesController extends Controller
{
    private ?CatchEntity $catch = null;
    private $user = null;
    private ?UserService $userService = null;
    private ?CatchesRepository $catchesRepository = null;
    private ?CatchesService $catchesService = null;

    public function create()
    {
        try {
            $this->hydrateCatch($this->getData());
            $this->getCatchesService()->insertCatches($this->getCatch());
            $code = 201;
            $message = $this->getCatch()->getArray();
        } catch (Exception $e) {
            $code = $e->getCode();
            $message = $e->getMessage();
            if ($code > 1000 || $code == 0) { //this block of code handles database exceptions
                $message = "Database error";
                if ($code == 1045) {
                    $message = "Could not connect to the database.";
                }
                $code = 400;
            }
        }
        return response()->json($message, $code);
    }

    public function get($id)
    {
        try {
            $message = $this->getCatchesService()->getCatch($id);
            $code = 200;
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

    public function delete($id)
    {
        try {
            $this->getCatchesService()->deleteCatch($id);
            $message = null;
            $code = 204;
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

    public function hydrateCatch($data)
    {
        if (!isset($data->user_id)) $data->user_id = $this->getUser()->user_id;
        if (!isset($data->created_at)) $data->created_at = date('Y-m-d H:i:s');
        if (!isset($data->updated_at)) $data->updated_at = null;
        $this->getCatch()->setUserId($data->user_id);
        $this->getCatch()->setName($data->name);
        $this->getCatch()->setWeight($data->weight);
        $this->getCatch()->setLength($data->length);
        $this->getCatch()->setImgUrl($data->img_url);
        $this->getCatch()->setLocationId($data->location_id);
        $this->getCatch()->setCreatedAt($data->created_at);
        $this->getCatch()->setUpdatedAt($data->updated_at);
    }

    /**
     * @return CatchEntity|null
     */
    public function getCatch(): ?CatchEntity
    {
        if ($this->catch == null) {
            $this->catch = new CatchEntity();
        }
        return $this->catch;
    }

    /**
     * @param CatchEntity|null $catch
     */
    public function setCatch(?CatchEntity $catch): void
    {
        $this->catch = $catch;
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
     * @return CatchesService|null
     */
    public function getCatchesService(): ?CatchesService
    {
        if ($this->catchesService == null) {
            $this->catchesService = new CatchesService($this->getCatchesRepository());
        }
        return $this->catchesService;
    }

    /**
     * @param CatchesService|null $catchesService
     */
    public function setCatchesService(?CatchesService $catchesService): void
    {
        $this->catchesService = $catchesService;
    }

    /**
     * @return CatchesRepository|null
     */
    public function getCatchesRepository(): ?CatchesRepository
    {
        if ($this->catchesRepository == null) {
            $this->catchesRepository = new CatchesRepository();
        }
        return $this->catchesRepository;
    }

    /**
     * @param CatchesRepository|null $catchesRepository
     */
    public function setCatchesRepository(?CatchesRepository $catchesRepository): void
    {
        $this->catchesRepository = $catchesRepository;
    }

}

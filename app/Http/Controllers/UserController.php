<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Exception;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    private $userService = null;

    public function create()
    {
        try {
            $data['email'] = $this->getData()->email;
            $data['password'] = Hash::make($this->getData()->password);
            $data['first_name'] = $this->getData()->first_name;
            $data['last_name'] = $this->getData()->last_name;
            $data['created_at'] = date('Y-m-d H:i:s');
            $this->getUserService()->createUser($data);
            $message = "Success";
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

    public function authenticate()
    {
        try {
            $email = $this->getRequest()->getUser();
            $user = $this->getUserService()->getUserRepo()->getUserByEmail($email);
            if (empty($user)) {
                return response()->json("Something went wrong.", 400);
            }
            $password = Hash::check($this->getRequest()->getPassword(), $user->password);
            if ($password) {
                //generate API key and return
                $data['created_at'] = date('Y-m-d H:i:s');
                $data['expires'] = date('Y-m-d H:i:s', strtotime('+2 hours'));
                $user_id = $user->id;
                $data['user_id'] = $user_id;
                $data['api_key'] = $this->getUserService()->generateApiKey();
                $this->getUserService()->getUserRepo()->insertUserApiToken($data);
                $message = ['api_key' => $data['api_key'], 'expires' => $data['expires']];
                $code = 200;
            } else {
                $message = "Unable to authenticate";
                $code = 401;
            }
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

    /**
     * @return UserService
     */
    public function getUserService()
    {
        if ($this->userService == null) {
            $this->userService = new UserService();
        }
        return $this->userService;
    }

    /**
     * @param $userService
     * @return void
     */
    public function setUserService($userService): void
    {
        $this->userService = $userService;
    }
}

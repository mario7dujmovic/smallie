<?php

namespace App\Http\Middleware;

use App\Services\UserService;
use Closure;
use Illuminate\Http\Request;

class AuthMiddleware
{
    private $userService = null;

    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();
        if (empty($this->getUserService()->getUserRepo()->getUserByToken($token))) {
            return response()->json("Failed to authenticate.", 401);
        }
        $token = $this->getUserService()->getUserRepo()->getTokenEntry($token);
        if ($token->expires < date('Y-m-d H:i:s')) {
            return response()->json("Failed to authenticate.", 401);
        }
        return $next($request);
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
     * @param null $userService
     */
    public function setUserService($userService): void
    {
        $this->userService = $userService;
    }

}

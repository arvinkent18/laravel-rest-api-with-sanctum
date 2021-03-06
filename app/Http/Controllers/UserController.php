<?php

namespace App\Http\Controllers;

use App\Http\_Services\UserService;
use App\Http\Requests\LoginRequest;

use App\Http\Requests\RegisterRequest;
use App\Http\Resources\LoginResource;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{   
    protected $userService;

    /**
     * UserController Constructor
     * 
     * @param \App\Http\_Services\UserService  $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Register the user
     * 
     * @param \App\Http\Requests\RegisterRequest
     * @return \Illuminate\Http\Response
     */
    public function register(RegisterRequest $request) {
        return (new UserResource($this->userService->register($request->all())))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    /**
     * Login user
     * 
     * @param \App\Http\Requests\LoginRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function login(LoginRequest $request) {
        return (new LoginResource($this->userService->login($request->all())))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    /**
     * Logout the user
     */
    public function logout(Request $request) {
        if (auth()->check()){
            $request->user()->currentAccessToken()->delete();

            return [
                'message' => 'Logged out',
            ];
        }
    }
}

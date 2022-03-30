<?php

namespace App\Http\_Services;

use App\Http\_Repositories\UserRepository;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\UnauthorizedException;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Register the user
     * 
     * @param array  $data
     * @return User
     */
    public function register(array $data)
    {
        try {
            Log::info('Registering user.');

            return $this->userRepository->register($data);
        } catch (Exception $e) {
            return Log::debug(`Failed to register user due to: {$e->getMessage()}`);
        }
    }

    /**
     * Login the user
     * 
     * @param array  $data
     * @throws \Illuminate\Validation\UnauthorizedException
     * @return User
     */
    public function login(array $data)
    {
        try {
            Log::info('Logging in user.');

            $user = $this->userRepository->login($data);

            if ($user) {
                $token = $user->createToken(hash('sha256', Str::random(60)))->plainTextToken;
                $user['access_token'] = $token;

                return $user;
            }

            throw new UnauthorizedException('Email or Password invalid', 401);
        } catch (Exception $e) {
            return Log::debug(`Failed to login user due to: {$e->getMessage()}`);
        }
    }
}
<?php

namespace App\Http\_Services;

use App\Http\_Repositories\UserRepository;
use Exception;
use Illuminate\Support\Facades\Log;

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
            return Log::debug($e->getMessage());
        }
    }

    public function login(array $data)
    {

    }
}
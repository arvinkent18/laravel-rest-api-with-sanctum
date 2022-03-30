<?php

namespace App\Http\_Repositories;

use App\Models\User;

class UserRepository
{
    protected $_user;

    public function __construct(User $user)
    {
        $this->user = $user;    
    }

    /**
     * Register the user
     * 
     * @param array  $data
     * @return \App\Models\User
     */
    public function register(array $data)
    {
        return $this->user->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']), 
        ]);
    }

    public function login(array $data)
    {

    }
}
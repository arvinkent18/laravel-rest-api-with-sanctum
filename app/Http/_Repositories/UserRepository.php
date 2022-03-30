<?php

namespace App\Http\_Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

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

    /**
     * Login the user
     * 
     * @param array  $data
     * @return bool|User
     */
    public function login(array $data)
    {
        $user = $this->user->where('email', $data['email'])->first();
        
        if (!$user && !Hash::check($data['password'], $user->password)) return false;

        return $user;
    }

    /**
     * Show current logged user's products
     * 
     * @return \App\Models\Product
     */
    public function showMyProducts(int $id)
    {
        return $this->user->findOrFail($id)->products()->get();
    }
}
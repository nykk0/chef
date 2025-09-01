<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(array $data): User
    {
        $data['password'] = Hash::make($data['password']);
        return $this->userRepository->create($data);
    }

    public function update(User $user, array $data): User
    {
        if (!empty($data['nova_senha'])) {
            $data['password'] = Hash::make($data['nova_senha']);
        }

        unset($data['nova_senha'], $data['senha_atual'], $data['confirmar_senha']);

        return $this->userRepository->update($user, $data);
    }
}

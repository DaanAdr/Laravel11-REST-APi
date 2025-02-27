<?php

namespace Tests\Feature\ApiControllerTests\v1;

use App\Models\User;

class SharedFunctions
{
    public static function authenticate(): string
    {
        $user = User::create(['name' => 'Test', 'email' => 'test@test.com', 'password' => 'password']);
        return $user->createToken('TestToken')->plainTextToken;
    }
}
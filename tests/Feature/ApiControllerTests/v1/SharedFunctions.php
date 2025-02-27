<?php

namespace Tests\Feature\ApiControllerTests\v1;

use App\Models\User;
use App\Models\AgeRange;

class SharedFunctions
{
    public static function get_authenticated_header(): array
    {
        $user = User::create(['name' => 'Test', 'email' => 'test@test.com', 'password' => 'password']);
        $token =  $user->createToken('TestToken')->plainTextToken;

        return [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ];
    }

    public static function get_unauthenticated_header(): array
    {
        return [
            'Accept' => 'application/json'
        ];
    }

    public static function seed_one_age_range_to_database(): AgeRange
    {
        $seed_data = ['age_range' => '5-8'];
        return AgeRange::create($seed_data);
    }
}
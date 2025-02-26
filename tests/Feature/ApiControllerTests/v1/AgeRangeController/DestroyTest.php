<?php

namespace Tests\Feature\ApiControllerTests\v1\AgeRangeController;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\AgeRange;
use App\Models\User;

class DestroyTest extends TestCase
{
    use RefreshDatabase;

    public function test_destroy_removes_age_range_from_database()
    {
        // Arrange
        // Create new user and get token
        $user = User::create(['name' => 'Test', 'email' => 'test@test.com', 'password' => 'password']);
        $token = $user->createToken('TestToken')->plainTextToken;

        // Seed database with AgeRange objects
        $age_range_prop = 'age_range';
        $age_range_one = [$age_range_prop => '5-8'];
        $age_range = AgeRange::create($age_range_one);
        AgeRange::create([$age_range_prop => '9-13']);
        $id_to_delete = $age_range->id;     // Pick the ID of the newly created item, as RefreshDatabase doesn't reset the auto-increment

        // Act
        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ];

        $response = $this->delete("/api/v1/age_range/$id_to_delete", [], $headers);
        $responseContent = $response->getContent();
        $responseBool = filter_var($responseContent, FILTER_VALIDATE_BOOLEAN);

        // Assert
        $response->assertStatus(200);
        $this->assertDatabaseMissing('age_ranges', $age_range_one);
        $this->assertTrue($responseBool);
    }

    public function test_destory_with_incorrect_id_returns_404_not_found()
    {
        // Arrange
        // Create new user and get token
        $user = User::create(['name' => 'Test', 'email' => 'test@test.com', 'password' => 'password']);
        $token = $user->createToken('TestToken')->plainTextToken;

        // Seed database with AgeRange objects
        $age_range_prop = 'age_range';
        AgeRange::create([$age_range_prop => '5-8']);
        AgeRange::create([$age_range_prop => '9-13']);

        // Act
        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ];

        $response = $this->delete('api/v1/age_range/103', [], $headers);

        // Assert
        $response->assertStatus(404);
    }

    public function test_destory_without_token_returns_401_unauthorized()
    {
        // Act
        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->delete('api/v1/age_range/103', [], $headers);
        $responseContent = json_decode($response->getContent(), true);

        // Assert
        $response->assertStatus(401);
        $this->assertEquals(["message" => "Unauthenticated."], $responseContent);
    }
}

<?php

namespace Tests\Feature\ApiControllerTests\v1\AgeRangeController;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\AgeRange;
use App\Models\User;

class UpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_update_age_range_returns_200_ok()
    {
        // Arrange
        // Create new user and get token
        $user = User::create(['name' => 'Test', 'email' => 'test@test.com', 'password' => 'password']);
        $token = $user->createToken('TestToken')->plainTextToken;

        // Seed database with AgeRange objects
        $age_range_prop = 'age_range';
        $age_range = AgeRange::create([$age_range_prop => '99+']);

        // Create changes to update
        $id_to_update = $age_range->id;     // Pick the ID of the newly created item, as RefreshDatabase doesn't reset the auto-increment
        $new_data = [$age_range_prop => '66+'];

        // Act
        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ];

        $response = $this->patchJson("api/v1/age_range/$id_to_update", $new_data, $headers);
        $responseContent = $response->getContent();
        $responseBool = filter_var($responseContent, FILTER_VALIDATE_BOOLEAN);

        // Assert
        $response->assertStatus(200);
        $this->assertTrue($responseBool);
        $this->assertDatabaseHas("age_ranges", $new_data);
    }

    public function test_update_empty_age_range_return_422_unprocessable_content()
    {
        // Arrange
        // Create new user and get token
        $user = User::create(['name' => 'Test', 'email' => 'test@test.com', 'password' => 'password']);
        $token = $user->createToken('TestToken')->plainTextToken;

        // Seed database with AgeRange objects
        $age_range_prop = 'age_range';
        $age_range = AgeRange::create([$age_range_prop => '99+']);

        // Create changes to update
        $id_to_update = $age_range->id;     // Pick the ID of the newly created item, as RefreshDatabase doesn't reset the auto-increment
        $new_data = [$age_range_prop => ''];

        // Act
        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ];

        $response = $this->patchJson("api/v1/age_range/$id_to_update", $new_data, $headers);

        // Assert
        $response->assertStatus(422);
        $this->assertDatabaseMissing("age_ranges", $new_data);
    }

    public function test_update_without_token_returns_401_unauthorized()
    {
        // Arrange
        // Seed database with AgeRange objects
        $age_range_prop = 'age_range';
        $age_range = AgeRange::create([$age_range_prop => '99+']);

        // Create changes to update
        $id_to_update = $age_range->id;     // Pick the ID of the newly created item, as RefreshDatabase doesn't reset the auto-increment
        $new_data = [$age_range_prop => '66+'];

        // Act
        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->patchJson("api/v1/age_range/$id_to_update", $new_data, $headers);
        $responseContent = json_decode($response->getContent(), true);

        // Assert
        $response->assertStatus(401);
        $this->assertEquals(["message" => "Unauthenticated."], $responseContent);
    }
}

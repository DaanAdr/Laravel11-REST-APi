<?php

namespace Tests\Feature\ApiControllerTests\v1\AgeRangeController;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\ApiControllerTests\v1\SharedFunctions;
use Tests\TestCase;
use App\Models\AgeRange;

class DestroyTest extends TestCase
{
    use RefreshDatabase;

    public function test_destroy_removes_age_range_from_database()
    {
        // Arrange
        $token = SharedFunctions::authenticate();

        // Seed database with AgeRange objects
        $age_range_prop = 'age_range';
        $age_range_one = [$age_range_prop => '5-8'];
        $age_range = AgeRange::create($age_range_one);

        // Act
        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ];

        $response = $this->delete("/api/v1/age_range/$age_range->id", [], $headers);
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
        $token = SharedFunctions::authenticate();

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

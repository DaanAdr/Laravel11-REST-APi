<?php

namespace Tests\Feature\ApiControllerTests\v1\AgeRangeController;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\ApiControllerTests\v1\SharedFunctions;
use Tests\TestCase;

class DestroyTest extends TestCase
{
    use RefreshDatabase;

    public function test_destroy_removes_age_range_from_database()
    {
        // Arrange
        $age_range = SharedFunctions::seed_one_age_range_to_database();

        // Act
        $headers = SharedFunctions::get_authenticated_header();

        $response = $this->deleteJson("/api/v1/age_range/$age_range->id", [], $headers);
        $responseContent = $response->getContent();
        $responseBool = filter_var($responseContent, FILTER_VALIDATE_BOOLEAN);

        // Assert
        $response->assertStatus(200);
        $this->assertDatabaseMissing('age_ranges', $age_range->toArray());
        $this->assertTrue($responseBool);
    }

    public function test_destory_with_incorrect_id_returns_404_not_found()
    {
        // Act
        $headers = SharedFunctions::get_authenticated_header();

        $response = $this->deleteJson('api/v1/age_range/103', [], $headers);

        // Assert
        $response->assertStatus(404);
    }

    public function test_destory_without_token_returns_401_unauthorized()
    {
        // Act
        $headers = SharedFunctions::get_unauthenticated_header();

        $response = $this->deleteJson('api/v1/age_range/103', [], $headers);
        $responseContent = json_decode($response->getContent(), true);

        // Assert
        $response->assertStatus(401);
        $this->assertEquals(["message" => "Unauthenticated."], $responseContent);
    }
}

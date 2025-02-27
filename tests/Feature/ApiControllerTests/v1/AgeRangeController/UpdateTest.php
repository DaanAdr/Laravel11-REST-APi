<?php

namespace Tests\Feature\ApiControllerTests\v1\AgeRangeController;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\ApiControllerTests\v1\SharedFunctions;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_update_age_range_returns_200_ok()
    {
        // Arrange
        $age_range = SharedFunctions::seed_one_age_range_to_database();

        // Create changes to update
        $new_data = ['age_range' => '66+'];

        // Act
        $headers = SharedFunctions::get_authenticated_header();

        $response = $this->patchJson("api/v1/age_range/$age_range->id", $new_data, $headers);
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
        $age_range = SharedFunctions::seed_one_age_range_to_database();

        // Create changes to update
        $new_data = ['age_range' => ''];

        // Act
        $headers = SharedFunctions::get_authenticated_header();

        $response = $this->patchJson("api/v1/age_range/$age_range->id", $new_data, $headers);

        // Assert
        $response->assertStatus(422);
        $this->assertDatabaseMissing("age_ranges", $new_data);
    }

    public function test_update_without_token_returns_401_unauthorized()
    {
        // Arrange
        $age_range = SharedFunctions::seed_one_age_range_to_database();

        $new_data = ['age_range' => '66+'];

        // Act
        $headers = SharedFunctions::get_unauthenticated_header();

        $response = $this->patchJson("api/v1/age_range/$age_range->id", $new_data, $headers);
        $responseContent = json_decode($response->getContent(), true);

        // Assert
        $response->assertStatus(401);
        $this->assertEquals(["message" => "Unauthenticated."], $responseContent);
    }
}

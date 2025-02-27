<?php

namespace Tests\Feature\ApiControllerTests\v1\AgeRangeController;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\ApiControllerTests\v1\SharedFunctions;
use Tests\TestCase;

class StoreTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_creates_new_age_range()
    {
        // Arrange
        $age_range_prop = 'age_range';
        $data = [$age_range_prop => '10-20'];

        // Act
        $headers = SharedFunctions::get_authenticated_header();

        $response = $this->postJson('/api/v1/age_range', $data, $headers);
        $responseContent = json_decode($response->getContent(), true)['data'];

        // Assert
        $response->assertStatus(201);
        $this->assertEquals($data[$age_range_prop], $responseContent[$age_range_prop]);
        $this->assertDatabaseHas('age_ranges', $data);
    }

    public function test_store_with_empty_age_range_returns_422_unprocessable_content()
    {
        // Arrange
        $data = ['age_range' => ''];

        // Act
        $headers = SharedFunctions::get_authenticated_header();

        $response = $this->postJson('/api/v1/age_range', $data, $headers);
        $responseContent = json_decode($response->getContent(), true);

        // Assert
        $response->assertStatus(422);
        $this->assertDatabaseMissing('age_ranges', $data);
        $this->assertEquals('The age range field is required.', $responseContent['errors']['age_range'][0]);
    }

    public function test_store_without_token_returns_401_unauthorized()
    {
        // Arrange
        $data = ['age_range' => '55 - 99'];

        // Act
        $headers = SharedFunctions::get_unauthenticated_header();

        $response = $this->postJson('/api/v1/age_range', $data, $headers);
        $responseContent = json_decode($response->getContent(), true);

        // Assert
        $response->assertStatus(401);
        $this->assertEquals(['message' => 'Unauthenticated.'], $responseContent);
    }
}

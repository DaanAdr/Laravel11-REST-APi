<?php

namespace Tests\Feature;

use App\Models\AgeRange;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AgeRangeControllerTest extends TestCase
{
    use RefreshDatabase;        // Uses .env.testing database

    public function test_index_returns_all_age_ranges()
    {
        // Arrange
        $age_range_prop = 'age_range';
        $age_range_one = AgeRange::create([$age_range_prop => '5-8']);
        $age_range_two = AgeRange::create([$age_range_prop => '9-13']);

        //AgeRange::factory()->count(5)->create();

        // Act
        $response = $this->get('/api/v1/age_range');
        $responseContent = json_decode($response->getContent(), true);

        // Assert
        $response->assertStatus(200);
        $this->assertCount(2, $responseContent);
        $this->assertEquals($age_range_one[$age_range_prop], $responseContent[0][$age_range_prop]);
        $this->assertEquals($age_range_two[$age_range_prop], $responseContent[1][$age_range_prop]);
    }

    #region Store
    public function test_store_creates_new_age_range()
    {
        // Arrange
        $data = ['age_range' => '10-20'];

        // Act
        $response = $this->postJson('/api/v1/age_range', $data);

        // Assert
        $response->assertStatus(201)
                 ->assertJsonStructure(['id', 'age_range']);

        $this->assertDatabaseHas('age_ranges', $data);
    }

    public function test_store_with_empty_age_range_returns_422_unprocessable_content()
    {
        // Arrange
        $data = ['age_range' => ''];

        // Act
        $response = $this->postJson('/api/v1/age_range', $data);
        $responseContent = $response->getContent();

        // Assert
        $response->assertStatus(422);
        $this->assertDatabaseMissing('age_ranges', $data);
        $this->assertEquals('The age range field is required.', $$responseContent['errors']['age_range'][0]);
    }
    #endregion
}

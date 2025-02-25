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
        $age_range_prop = 'age_range';
        $data = [$age_range_prop => '10-20'];

        // Act
        $response = $this->postJson('/api/v1/age_range', $data);
        $responseContent = json_decode($response->getContent(), true);

        // Assert
        $response->assertStatus(201)
                 ->assertJsonStructure(['id', $age_range_prop]);

        $this->assertEquals($data[$age_range_prop], $responseContent[$age_range_prop]);

        $this->assertDatabaseHas('age_ranges', $data);
    }

    public function test_store_with_empty_age_range_returns_422_unprocessable_content()
    {
        // Arrange
        $data = ['age_range' => ''];

        // Act
        $response = $this->postJson('/api/v1/age_range', $data);
        $responseContent = json_decode($response->getContent() , true);

        // Assert
        $response->assertStatus(422);
        $this->assertDatabaseMissing('age_ranges', $data);
        $this->assertEquals('The age range field is required.', $responseContent['errors']['age_range'][0]);
    }
    #endregion

    #region Update
    public function test_update_age_range_returns_200_ok()
    {
        // Arrange
        $age_range_prop = 'age_range';
        $age_range = AgeRange::create([$age_range_prop => '99+']);

        $id_to_update = $age_range->id;     // Pick the ID of the newly created item, as RefreshDatabase doesn't reset the auto-increment
        $new_data = [$age_range_prop => '66+'];

        // Act
        $response = $this->patchJson("api/v1/age_range/$id_to_update", $new_data);
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
        $age_range_prop = 'age_range';
        $age_range = AgeRange::create([$age_range_prop => '99+']);

        $id_to_update = $age_range->id;     // Pick the ID of the newly created item, as RefreshDatabase doesn't reset the auto-increment
        $new_data = [$age_range_prop => ''];

        // Act
        $response = $this->patchJson("api/v1/age_range/$id_to_update", $new_data);
        // Assert
        $response->assertStatus(422);
        $this->assertDatabaseMissing("age_ranges", $new_data);
    }
    #endregion

    #region Destroy
    public function test_destroy_removes_age_range_from_database()
    {
        // Arrange
        $age_range_prop = 'age_range';
        $age_range_one = [$age_range_prop => '5-8'];
        $age_range = AgeRange::create($age_range_one);
        AgeRange::create([$age_range_prop => '9-13']);
        $id_to_delete = $age_range->id;     // Pick the ID of the newly created item, as RefreshDatabase doesn't reset the auto-increment

        // Act
        $response = $this->delete("/api/v1/age_range/$id_to_delete");
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
        $age_range_prop = 'age_range';
        AgeRange::create([$age_range_prop => '5-8']);
        AgeRange::create([$age_range_prop => '9-13']);

        // Act
        $response = $this->delete('api/v1/age_range/103');

        // Assert
        $response->assertStatus(404);
    }
    #endregion
}

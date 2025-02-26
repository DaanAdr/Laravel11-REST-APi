<?php

namespace Tests\Feature;

use App\Models\AgeRange;
use Auth;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class AgeRangeControllerTest extends TestCase
{
    use RefreshDatabase;        // Uses .env.testing database
    private $unauthenticated_response = ["message" => "Unauthenticated."];

    #region Index
    public function test_index_returns_all_age_ranges()
    {
        // Arrange
        // Create new user and get token
        $user = User::create(['name' => 'Test', 'email' => 'test@test.com', 'password' => 'password']);
        $token = $user->createToken('TestToken')->plainTextToken;

        // Seed database with AgeRange objects
        $age_range_prop = 'age_range';
        $age_range_one = AgeRange::create([$age_range_prop => '5-8']);
        $age_range_two = AgeRange::create([$age_range_prop => '9-13']);

        // Act
        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ];

        // Call the endpoint to test
        $response = $this->get('/api/v1/age_range', $headers);
        $responseContent = json_decode($response->getContent(), true);

        // Assert
        $response->assertStatus(200);
        $this->assertCount(2, $responseContent);
        $this->assertEquals($age_range_one[$age_range_prop], $responseContent[0][$age_range_prop]);
        $this->assertEquals($age_range_two[$age_range_prop], $responseContent[1][$age_range_prop]);
    }

    public function test_index_without_token_returns_401_unauthorized()
    {
        // Act
        $headers = [
            'Accept' => 'application/json'
        ];

        // Call the endpoint to test
        $response = $this->get('/api/v1/age_range', $headers);
        $responseContent = json_decode($response->getContent(), true);

        // Assert
        $response->assertStatus(401);
        $this->assertEquals($this->unauthenticated_response, $responseContent);
    }
    #endregion

    #region Store
    public function test_store_creates_new_age_range()
    {
        // Arrange
        // Create new user and get token
        $user = User::create(['name' => 'Test', 'email' => 'test@test.com', 'password' => 'password']);
        $token = $user->createToken('TestToken')->plainTextToken;

        $age_range_prop = 'age_range';
        $data = [$age_range_prop => '10-20'];

        // Act
        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ];

        $response = $this->postJson('/api/v1/age_range', $data, $headers);
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
        // Create new user and get token
        $user = User::create(['name' => 'Test', 'email' => 'test@test.com', 'password' => 'password']);
        $token = $user->createToken('TestToken')->plainTextToken;

        $data = ['age_range' => ''];

        // Act
        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ];

        $response = $this->postJson('/api/v1/age_range', $data, $headers);
        $responseContent = json_decode($response->getContent() , true);

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
        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->postJson('/api/v1/age_range', $data, $headers);
        $responseContent = json_decode($response->getContent() , true);

        // Assert
        $response->assertStatus(401);
        $this->assertEquals($this->unauthenticated_response, $responseContent);
    }
    #endregion

    #region Update
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
        $this->assertEquals($this->unauthenticated_response, $responseContent);
    }
    #endregion

    #region Destroy
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
        $this->assertEquals($this->unauthenticated_response, $responseContent);
    }
    #endregion
}

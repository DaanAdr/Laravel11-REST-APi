<?php

namespace Tests\Feature\ApiControllerTests\v1\AgeRangeController;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\ApiControllerTests\v1\SharedFunctions;
use Tests\TestCase;
use App\Models\AgeRange;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_all_age_ranges()
    {
        // Arrange
        // Seed database with AgeRange objects
        $age_range_prop = 'age_range';
        $age_range_one = AgeRange::create([$age_range_prop => '5-8']);
        $age_range_two = AgeRange::create([$age_range_prop => '9-13']);

        // Act
        $headers = SharedFunctions::get_authenticated_header();

        // Call the endpoint to test
        $response = $this->get('/api/v1/age_range', $headers);
        $responseContent = json_decode($response->getContent(), true)['data'];

        // Assert
        $response->assertStatus(200);
        $this->assertCount(2, $responseContent);
        $this->assertEquals($age_range_one[$age_range_prop], $responseContent[0][$age_range_prop]);
        $this->assertEquals($age_range_two[$age_range_prop], $responseContent[1][$age_range_prop]);
    }

    public function test_index_without_token_returns_401_unauthorized()
    {
        // Act
        $headers = SharedFunctions::get_unauthenticated_header();

        // Call the endpoint to test
        $response = $this->get('/api/v1/age_range', $headers);
        $responseContent = json_decode($response->getContent(), true);

        // Assert
        $response->assertStatus(401);
        $this->assertEquals(["message" => "Unauthenticated."], $responseContent);
    }
}

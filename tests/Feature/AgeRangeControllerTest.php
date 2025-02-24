<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AgeRangeControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function test_index_returns_all_age_ranges()
    {
        $response = $this->get('/api/v1/age_range');

        $response->assertStatus(200);
    }

    public function test_store_creates_new_age_range()
    {
        $data = ['age_range' => '10-20'];

        $response = $this->postJson('/api/v1/age_range', $data);

        $response->assertStatus(201)
                 ->assertJsonFragment($data);

        $this->assertDatabaseHas('age_ranges', $data);

        $getty = $this->getJson('/api/v1/age_range');
    }
}

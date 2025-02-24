<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AgeRangeControllerTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_index_returns_all_age_ranges()
    {
        $response = $this->get('/api/v1/age_range');

        $response->assertStatus(200);
    }
}

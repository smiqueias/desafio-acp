<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_api_list_all_products()
    {

        $response = $this->get('/api/v1/products');

        $response->assertStatus(200);
    }
}

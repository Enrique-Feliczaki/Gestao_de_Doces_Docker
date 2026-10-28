<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_rota_inicial_retornar_status_200(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
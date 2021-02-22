<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DocumentacaoTest extends TestCase
{
    public function test_rota_Inicial()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}

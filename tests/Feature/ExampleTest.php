<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_show_error_on_server()
    {
        $response = $this->get('/');

        $response->assertNotFound();
    }
}

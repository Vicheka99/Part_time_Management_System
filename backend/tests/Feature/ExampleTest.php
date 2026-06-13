<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\View;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_dashboard_requires_authentication(): void
    {
        $response = $this->get('/');

        $response->assertRedirect(route('login'));
    }

    public function test_controller_index_views_exist(): void
    {
        $this->assertTrue(View::exists('index'));
        $this->assertTrue(View::exists('course.index'));
        $this->assertTrue(View::exists('student.index'));
        $this->assertTrue(View::exists('teacher.index'));
    }
}

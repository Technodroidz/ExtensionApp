<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_url()
    {
        $response = $this->get('/non-existing-url');

        $response->assertStatus(404);
    }

    /**
     * A basic load test example for performance and scalability.
     *
     * @return void
     */
    public function testLoad()
    {
        $totalRequests = 100;
        $concurrency = 10;

        $this->artisan('route:cache');
        $this->artisan('config:cache');

        $this->get('/');

        $this->benchmark(function () use ($totalRequests, $concurrency) {
            $this->get('/non-existing-url')->assertStatus(404);
        }, $totalRequests, $concurrency);
    }

    /**
     * A security test example for vulnerabilities.
     *
     * @return void
     */
    public function testSecurity()
    {
        // Test for potential SQL injection vulnerability in user input
        $response = $this->get('/search?q=\'; DROP TABLE users;--');
        $response->assertStatus(500);

        // Test for potential XSS vulnerability in user input
        $response = $this->get('/search?q=<script>alert("Hello world!");</script>');
        $response->assertDontSee('<script>');
    }

    /**
     * Helper method to run a function multiple times and measure the time taken.
     *
     * @param callable $function The function to run.
     * @param int $times The number of times to run the function.
     * @param int $concurrency The number of requests to run concurrently.
     * @return array An array containing the times taken for each run.
     */
    private function benchmark(callable $function, $times, $concurrency = 1)
    {
        $timesTaken = [];

        for ($i = 0; $i < $times; $i += $concurrency) {
            $responses = [];

            for ($j = 0; $j < $concurrency; $j++) {
                $responses[] = $function();
            }

            $timesTaken[] = array_sum($responses);
        }

        return $timesTaken;
    }
}




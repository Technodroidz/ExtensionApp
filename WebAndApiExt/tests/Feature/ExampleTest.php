<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_example()
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
     * Helper method to run a function multiple times and measure the time taken.
     *
     * @param callable $function The function to run.
     * @param int $times The number of times to run the function.
     * @return array An array containing the times taken for each run.
     */
    private function benchmark(callable $function, $times)
    {
        $timesTaken = [];

        for ($i = 0; $i < $times; $i++) {
            $startTime = microtime(true);
            $function();
            $timesTaken[] = microtime(true) - $startTime;
        }

        return $timesTaken;
    }
}



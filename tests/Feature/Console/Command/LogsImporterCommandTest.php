<?php

namespace Tests\Feature\Console\Command;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LogsImporterCommandTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testImportCommand(): void
    {
        $this->artisan('logs:import ' . env('LOGS_FILE_PATH'))
            ->assertExitCode(0);
    }
}

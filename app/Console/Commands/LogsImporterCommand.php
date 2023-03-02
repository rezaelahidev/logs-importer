<?php

namespace App\Console\Commands;

use App\Jobs\ImportLog;
use App\Utils\LogParserHelper;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class LogsImporterCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'logs:import
                            {file : The file path to import action}
                            {--queue :  Whether the job should be queued}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import a logs.txt file into the database after parsed data';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $logFile = $this->argument('file');

        if (!file_exists($logFile)) {
            throw new \Exception('Log file was not found!', 404);
        }

        $logsContent = File::get($logFile);
        $rows = LogParserHelper::getColumns($logsContent);

        $bar = $this->output->createProgressBar(count($rows));

        foreach ($rows as $row) {

            ImportLog::dispatch($row);

            $bar->advance();
        }

        $bar->finish();

        $this->info("\nInsertd Data of services logs.\n");
    }
}

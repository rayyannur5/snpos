<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;

class DatabaseDumpCommand extends Command
{
    protected $signature = 'db:dump {filename?}';
    protected $description = 'Dump the current database to a .sql file';

    public function handle()
    {
        $dbConnection = Config::get('database.connections.' . Config::get('database.default'));

        $username = $dbConnection['username'];
        $password = $dbConnection['password'];
        $database = $dbConnection['database'];
        $host     = $dbConnection['host'];
        $port     = $dbConnection['port'];

        $filename = $this->argument('filename') ?? 'backup_' . date('Y-m-d_H-i-s') . '.sql';
        $path     = storage_path('backup/' . $filename);

        $command = sprintf(
            'mysqldump -h%s -P%s -u%s -p%s %s > %s',
            $host,
            $port,
            $username,
            $password,
            $database,
            $path
        );

        system($command);

        $this->info("Database dumped to: {$path}");
    }
}

<?php

declare(strict_types=1);

namespace Tilabs\LaravelContent\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ClearContentCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'content:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear the cache sqlite files.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        collect(Storage::disk('content_cache')->files())->filter(function (string $file) {
            return preg_match('/^sushi-tilabs.*\.sqlite$/', $file);
        })->each(function (string $file) {
            Storage::disk('content_cache')->delete($file);
        });

        $this->info('Content cache cleared!');
    }
}

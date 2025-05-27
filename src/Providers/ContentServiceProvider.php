<?php

declare(strict_types=1);

namespace Tilabs\LaravelContent\Providers;

use Illuminate\Support\ServiceProvider;
use Tilabs\LaravelContent\Commands\ClearContentCache;

final class ContentServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/content.php', 'content'
        );

        config([
            'filesystems.disks.content' => [
                'driver' => 'local',
                'root' => base_path(config('content.directory')),
                'throw' => false,
            ],
            'filesystems.disks.content_cache' => [
                'driver' => 'local',
                'root' => storage_path('framework/cache'),
                'throw' => false,
            ]]);
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/content.php' => config_path('content.php'),

        ]);

        if ($this->app->runningInConsole()) {
            $this->commands([
                ClearContentCache::class,
            ]);
        }
    }
}

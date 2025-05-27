<?php

declare(strict_types=1);

namespace Tilabs\LaravelContent\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Stringable;

class SlugGenerator
{
    public static function handle(string $path): string
    {
        $slug = Str::of($path)

            ->replace('\\', '/')

            ->replaceMatches('/\.md$/i', '')

            ->explode('/')

            ->reject(fn (string|Stringable $segment) => Str::lower((string) $segment) === 'index')

            ->map(fn (string|Stringable $segment) => Str::of($segment)
                ->replaceMatches('/^(?:\d{4}-\d{2}-\d{2}-|\d+-)/', '')
                ->slug()
            )

            ->implode(config('content.slug_directory_separator', '_'));

        return $slug;
    }
}

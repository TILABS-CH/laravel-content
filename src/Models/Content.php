<?php

declare(strict_types=1);

namespace Tilabs\LaravelContent\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\AsStringable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\LazyCollection;
use Tilabs\LaravelContent\Markdown\ContentParser;

class Content extends Model
{
    use \Sushi\Sushi;

    protected $casts = [
        'content' => AsStringable::class,
        'title' => AsStringable::class,
        'tags' => 'array',
        'published' => 'boolean',
    ];

    public function getRows(): array
    {
        $parser = new ContentParser;

        return LazyCollection::make((Storage::disk('content')->allFiles()))->map(function ($path) use ($parser) {
            $parser->file($path)->parse();

            return [
                'title' => $parser->title(),
                'slug' => $parser->slug(),
                'published' => $parser->published(),
                'content' => $parser->content(),
                'tags' => $parser->tags(),
            ];
        })->toArray();
    }

    protected function sushiShouldCache(): bool
    {
        return config('content.cache', true);
    }

    protected function afterMigrate(Blueprint $table): void
    {
        $table->index('id');
        $table->index('slug');
    }

    #[Scope]
    protected function published(Builder $query): void
    {
        $query->where('published', true);
    }

    #[Scope]
    protected function drafted(Builder $query): void
    {
        $query->where('published', false);
    }
}

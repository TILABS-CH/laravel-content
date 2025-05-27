<?php

declare(strict_types=1);

namespace Tilabs\LaravelContent\Markdown;

use Illuminate\Support\Facades\Storage;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\FrontMatter\FrontMatterExtension;
use League\CommonMark\Extension\FrontMatter\Output\RenderedContentWithFrontMatter;
use League\CommonMark\Extension\HeadingPermalink\HeadingPermalinkExtension;
use League\CommonMark\MarkdownConverter;
use League\CommonMark\Output\RenderedContent;
use Tilabs\LaravelContent\Services\SlugGenerator;

class ContentParser
{
    protected string $disk = 'content';

    protected string $path;

    protected string $file;

    protected MarkdownConverter $converter;

    protected RenderedContent $result;

    public function __construct()
    {
        $environment = new Environment([
            'heading_permalink' => [
                'symbol' => config('content.heading_permalink_symbol', ''),
            ],
        ]);

        $environment->addExtension(new CommonMarkCoreExtension);
        $environment->addExtension(new FrontMatterExtension);
        $environment->addExtension(new HeadingPermalinkExtension);

        $this->converter = new MarkdownConverter($environment);
    }

    public function file(string $path): ContentParser
    {
        $this->path = $path;
        $this->file = Storage::disk($this->disk)->get($this->path);

        return $this;
    }

    public function parse(): ContentParser
    {
        $this->result = $this->converter->convert($this->file);

        return $this;
    }

    protected function front_matter(): array
    {
        if ($this->result instanceof RenderedContentWithFrontMatter) {
            return $this->result->getFrontMatter();
        }

        return [];
    }

    public function content(): string
    {
        return $this->result->getContent();
    }

    public function title(): string
    {
        return $this->front_matter()['title'] ?? '';
    }

    public function slug(): string
    {
        return SlugGenerator::handle($this->path);
    }

    public function tags(): string
    {
        return json_encode($this->front_matter()['tags'] ?? []);
    }

    public function published(): bool
    {
        return $this->front_matter()['published'] ?? false;
    }
}

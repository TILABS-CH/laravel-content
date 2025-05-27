# Laravel Content by Tilabs

> ⚡️ Generate markdown based Blog Posts with ease. Inspired by @nuxt/content and Caleb Porzio.

[![License: MIT](https://img.shields.io/badge/License-MIT-blue.svg)](LICENSE)

## Why this package

I personally use this package in a lot of cms based websites. This is only a very rough version, but I will improve it over time.

**Requirements**

|                                                         | Version |
| ------------------------------------------------------- | ------- |
| PHP                                                     | ^8.2    |
| [Laravel](https://laravel.com)                          | ^12.0   |
| [Sushi by Caleb Porzio](https://github.com/calebporzio) | ^2.5    |
| [League Commonmark](https://league.com)                 | ^2.6    |

## Installation & Usage

```bash
composer require tilabs/laravel-content
```

### Publish the configuration

```bash
php artisan vendor:publish --tag=laravel-content-config
```

### Write content

> Place your Markdown files inside `/content`

Create Markdown files anywhere under the configured content directory.

```bash

touch content/Hello World.md

```

Front-matter drives titles, tags, and publication status.

```
---
title: "Hello World"
tags: [introduction, laravel, cms]
published: true
---

# Hello World

This is my first post.
Headings get automatic IDs and permalinks.
```

> Files without a published key will automatically be drafted

**Slug rules**

- Directories are flattened and joined by the configured separator ("\_" by default).
- Numbers or dates at the start of a segment are stripped (2025-05-27-, 01-, etc.).
- Files named index.md are ignored in the slug
- Example file tree → slug mapping:

```
content/
├── News/
│ └── 2025-05-27-Laravel-Content.md → news_laravel-content
└── 01-getting-started/index.md → getting-started
```

### Query content in code

> If you cannot see your changes right away, jump to the next chapter

You can now query the markdown content like an Eloquent Model thanks to Sushi. Content already has `published` and `drafted` scopes to filter for Content.

```php
use Tilabs\LaravelContent\Models\Content;

// all published posts
$posts = Content::published()->get();

// a single post by slug
$post = Content::where('slug', 'news_laravel-content')->firstOrFail();
```

### Refreshing Content

Whenever you rename, add, or delete Markdown files in production, clear the Sushi-based cache:

```bash
php artisan content:clear
```

During local development you can disable caching ('cache' => false) and the model will refresh on every request.

## License

Laravel Deploy is open‑sourced software licensed under the **MIT license**.

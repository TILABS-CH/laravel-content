<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Content Directory
    |--------------------------------------------------------------------------
    |
    | This file is for configuring the content settings for your application.
    | Here you can specify the directory where your content files are stored.
    |
    */

    'directory' => 'content',

    /*
    |--------------------------------------------------------------------------
    | Content Cache
    |--------------------------------------------------------------------------
    |
    | This will determine whether the content should be cached.
    | It is highly recommended to enable this.
    |
    */

    'cache' => true,

    /*
    |--------------------------------------------------------------------------
    | Slug Directory Separator
    |--------------------------------------------------------------------------
    |
    | This will change the separator symbol used in the content slug.
    | The default is an underscore (_), but you can change it to any character.
    |
    | However, do not use a slash (/) as it breaks Route Model Binding.
    |
    */

    'slug_directory_separator' => '_',

    /*
    |--------------------------------------------------------------------------
    | Heading Permalink Symbol
    |--------------------------------------------------------------------------
    |
    | This will change the symbol used for heading permalinks.
    | The default is an empty string, but you can change it to any character.
    |
    */

    'heading_permalink_symbol' => '',
];

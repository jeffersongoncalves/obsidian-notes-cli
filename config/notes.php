<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default vault
    |--------------------------------------------------------------------------
    |
    | Used when --vault isn't passed. Falls back to the OBSIDIAN_VAULT env var.
    |
    */

    'vault' => env('OBSIDIAN_VAULT'),

    /*
    |--------------------------------------------------------------------------
    | Defaults for a vault without a .claude-notes.json
    |--------------------------------------------------------------------------
    |
    | A vault's own .claude-notes.json (at its root) always wins over these.
    | Placeholders in folder_pattern: {project} {date} {slug}.
    |
    */

    'folder_pattern' => 'Claude Notes/{project}/{date}-{slug}.md',

    'frontmatter_defaults' => [
        'source' => 'claude-code',
        'tags' => [],
    ],

    'bridge_port' => 27124,

];

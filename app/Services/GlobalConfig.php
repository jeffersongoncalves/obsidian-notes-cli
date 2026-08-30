<?php

namespace App\Services;

class GlobalConfig
{
    public static function path(): string
    {
        $home = getenv('HOME') ?: getenv('USERPROFILE');

        return rtrim($home, '/\\').'/.obsidian-notes-cli/config.json';
    }

    public static function vault(): ?string
    {
        $file = self::path();

        if (! is_file($file)) {
            return null;
        }

        $data = json_decode(file_get_contents($file), true) ?? [];

        return $data['vault'] ?? null;
    }

    public static function setVault(string $vault): void
    {
        $file = self::path();

        @mkdir(dirname($file), 0755, recursive: true);

        file_put_contents($file, json_encode(['vault' => $vault], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)."\n");
    }
}

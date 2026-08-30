<?php

namespace App\DTOs;

class NoteConfig
{
    public function __construct(
        public readonly string $vaultPath,
        public readonly string $folderPattern,
        public readonly array $frontmatterDefaults,
        public readonly int $bridgePort,
    ) {}

    public static function forVault(string $vaultPath): self
    {
        $vaultPath = rtrim($vaultPath, '/\\');
        $overrides = [];

        $configFile = $vaultPath.'/.claude-notes.json';

        if (is_file($configFile)) {
            $overrides = json_decode(file_get_contents($configFile), true) ?? [];
        }

        return new self(
            vaultPath: $vaultPath,
            folderPattern: $overrides['folderPattern'] ?? config('notes.folder_pattern'),
            frontmatterDefaults: $overrides['frontmatterDefaults'] ?? config('notes.frontmatter_defaults'),
            bridgePort: $overrides['bridgePort'] ?? config('notes.bridge_port'),
        );
    }
}

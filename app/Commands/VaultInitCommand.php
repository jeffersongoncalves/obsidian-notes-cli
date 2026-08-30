<?php

namespace App\Commands;

use App\Services\GlobalConfig;
use LaravelZero\Framework\Commands\Command;

class VaultInitCommand extends Command
{
    protected $signature = 'vault:init {path : Path to the Obsidian vault}
        {--no-default : Do not save this vault as the default (skips vault:config)}';

    protected $description = 'Scaffold .claude-notes.json and the base notes folder in a vault';

    public function handle(): int
    {
        $vault = rtrim($this->argument('path'), '/\\');

        if (! is_dir($vault)) {
            $this->components->error("Vault path does not exist: {$vault}");

            return self::FAILURE;
        }

        $configFile = $vault.'/.claude-notes.json';

        if (is_file($configFile)) {
            $this->components->warn('.claude-notes.json already exists, leaving it untouched.');
        } else {
            file_put_contents($configFile, json_encode([
                'folderPattern' => config('notes.folder_pattern'),
                'frontmatterDefaults' => config('notes.frontmatter_defaults'),
                'bridgePort' => config('notes.bridge_port'),
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)."\n");

            @mkdir($vault.'/Claude Notes', 0755, recursive: true);

            $this->components->info("Vault initialized at {$vault}");
        }

        if (! $this->option('no-default')) {
            GlobalConfig::setVault($vault);
            $this->components->info("Default vault saved: {$vault}");
        }

        return self::SUCCESS;
    }
}

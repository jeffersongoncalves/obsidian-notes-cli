<?php

namespace App\Commands;

use App\Services\GlobalConfig;
use LaravelZero\Framework\Commands\Command;

class VaultConfigCommand extends Command
{
    protected $signature = 'vault:config {path? : Vault path to save as the default (omit to show the current default)}';

    protected $description = 'Save a default vault path so --vault / OBSIDIAN_VAULT can be skipped';

    public function handle(): int
    {
        $path = $this->argument('path');

        if (! $path) {
            $current = GlobalConfig::vault();

            if (! $current) {
                $this->components->warn('No default vault configured. Run: vault:config <path>');

                return self::SUCCESS;
            }

            $this->components->info("Default vault: {$current}");

            return self::SUCCESS;
        }

        $path = rtrim($path, '/\\');

        if (! is_dir($path)) {
            $this->components->error("Vault path does not exist: {$path}");

            return self::FAILURE;
        }

        GlobalConfig::setVault($path);

        $this->components->info("Default vault saved: {$path}");

        return self::SUCCESS;
    }
}

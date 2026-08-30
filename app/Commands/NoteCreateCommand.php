<?php

namespace App\Commands;

use App\DTOs\NoteConfig;
use App\Services\BridgeClient;
use App\Services\NoteWriterService;
use LaravelZero\Framework\Commands\Command;

class NoteCreateCommand extends Command
{
    protected $signature = 'note:create
        {--project= : Project/repo the note belongs to}
        {--title= : Note title}
        {--tags=* : Tags to attach to the note}
        {--vault= : Vault path, defaults to OBSIDIAN_VAULT / notes.vault config}';

    protected $description = 'Write a Markdown note (piped via stdin) into an Obsidian vault';

    public function handle(NoteWriterService $writer, BridgeClient $bridge): int
    {
        $vault = $this->option('vault') ?: config('notes.vault');
        $project = $this->option('project');
        $title = $this->option('title');

        if (! $vault) {
            $this->components->error('No vault path given. Pass --vault or set OBSIDIAN_VAULT.');

            return self::FAILURE;
        }

        if (! is_dir($vault)) {
            $this->components->error("Vault path does not exist: {$vault}");

            return self::FAILURE;
        }

        if (! $project || ! $title) {
            $this->components->error('Both --project and --title are required.');

            return self::FAILURE;
        }

        $body = trim(stream_get_contents(STDIN) ?: '');

        $config = NoteConfig::forVault($vault);
        $result = $writer->write($config, $project, $title, $this->option('tags'), $body);

        $bridge->notify($config, $result['path'], $result['frontmatter'], $body);

        $this->components->info("Note written to {$result['path']}");

        return self::SUCCESS;
    }
}

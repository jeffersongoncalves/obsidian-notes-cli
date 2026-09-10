<?php

namespace App\Commands;

use App\Services\FrontmatterParser;
use LaravelZero\Framework\Commands\Command;

class NoteReadCommand extends Command
{
    protected $signature = 'note:read {path : Path to the note file}';

    protected $description = 'Print a note\'s content without its YAML frontmatter';

    public function handle(): int
    {
        $path = $this->argument('path');

        if (! is_file($path)) {
            $this->components->error("Note not found: {$path}");

            return self::FAILURE;
        }

        $this->output->write(FrontmatterParser::stripBody(file_get_contents($path)));

        return self::SUCCESS;
    }
}

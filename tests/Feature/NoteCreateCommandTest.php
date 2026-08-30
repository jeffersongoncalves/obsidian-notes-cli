<?php

use App\Services\FrontmatterParser;

function removeDirectory(string $dir): void
{
    if (! is_dir($dir)) {
        return;
    }

    foreach (scandir($dir) as $item) {
        if ($item === '.' || $item === '..') {
            continue;
        }

        $path = $dir.DIRECTORY_SEPARATOR.$item;
        is_dir($path) ? removeDirectory($path) : unlink($path);
    }

    rmdir($dir);
}

beforeEach(function () {
    $this->vault = sys_get_temp_dir().'/obsidian-notes-cli-test-'.uniqid();
    mkdir($this->vault, 0755, recursive: true);
});

afterEach(function () {
    removeDirectory($this->vault);
});

it('writes a note with frontmatter into the vault', function () {
    $this->artisan('note:create', [
        '--project' => 'my-project',
        '--title' => 'Decision: use SQLite',
        '--tags' => ['architecture', 'decision'],
        '--vault' => $this->vault,
    ])->assertSuccessful();

    $path = $this->vault.'/Claude Notes/my-project/'.now()->toDateString().'-decision-use-sqlite.md';

    expect($path)->toBeFile();

    $frontmatter = FrontmatterParser::parse(file_get_contents($path));

    expect($frontmatter)
        ->source->toBe('claude-code')
        ->project->toBe('my-project')
        ->title->toBe('Decision: use SQLite');
});

it('requires project and title', function () {
    $this->artisan('note:create', ['--vault' => $this->vault])
        ->assertFailed();
});

it('fails for a vault path that does not exist', function () {
    $this->artisan('note:create', [
        '--project' => 'x',
        '--title' => 'y',
        '--vault' => $this->vault.'/does-not-exist',
    ])->assertFailed();
});

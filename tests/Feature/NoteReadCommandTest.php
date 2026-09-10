<?php

beforeEach(function () {
    $this->vault = sys_get_temp_dir().'/obsidian-notes-cli-test-'.uniqid();
    mkdir($this->vault, 0755, recursive: true);
});

afterEach(function () {
    removeDirectory($this->vault);
});

it('prints the note body without frontmatter', function () {
    $path = $this->vault.'/note.md';
    file_put_contents($path, "---\nsource: claude-code\ntitle: Decision: use SQLite\n---\n\nThe actual body.\n");

    $this->artisan('note:read', ['path' => $path])
        ->expectsOutputToContain('The actual body.')
        ->assertSuccessful();
});

it('fails for a path that does not exist', function () {
    $this->artisan('note:read', ['path' => $this->vault.'/missing.md'])
        ->assertFailed();
});

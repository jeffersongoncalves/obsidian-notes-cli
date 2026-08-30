<?php

use App\Services\GlobalConfig;

beforeEach(function () {
    $this->home = sys_get_temp_dir().'/obsidian-notes-cli-home-'.uniqid();
    mkdir($this->home, 0755, recursive: true);
    $this->originalHome = getenv('HOME');
    $this->originalUserProfile = getenv('USERPROFILE');
    putenv("HOME={$this->home}");
    putenv("USERPROFILE={$this->home}");

    $this->vault = sys_get_temp_dir().'/obsidian-notes-cli-vault-'.uniqid();
    mkdir($this->vault, 0755, recursive: true);
});

afterEach(function () {
    putenv($this->originalHome === false ? 'HOME' : "HOME={$this->originalHome}");
    putenv($this->originalUserProfile === false ? 'USERPROFILE' : "USERPROFILE={$this->originalUserProfile}");
    removeDirectory($this->home);
    removeDirectory($this->vault);
});

it('saves the vault as the default after init', function () {
    $this->artisan('vault:init', ['path' => $this->vault])->assertSuccessful();

    expect(GlobalConfig::vault())->toBe($this->vault);
});

it('skips saving the default when --no-default is passed', function () {
    $this->artisan('vault:init', ['path' => $this->vault, '--no-default' => true])->assertSuccessful();

    expect(GlobalConfig::vault())->toBeNull();
});

it('still saves the default when .claude-notes.json already exists', function () {
    file_put_contents($this->vault.'/.claude-notes.json', '{}');

    $this->artisan('vault:init', ['path' => $this->vault])->assertSuccessful();

    expect(GlobalConfig::vault())->toBe($this->vault);
});

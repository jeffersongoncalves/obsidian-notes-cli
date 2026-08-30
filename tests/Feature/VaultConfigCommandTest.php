<?php

use App\Services\GlobalConfig;

beforeEach(function () {
    $this->home = sys_get_temp_dir().'/obsidian-notes-cli-home-'.uniqid();
    mkdir($this->home, 0755, recursive: true);
    $this->originalHome = getenv('HOME');
    $this->originalUserProfile = getenv('USERPROFILE');
    putenv("HOME={$this->home}");
    putenv("USERPROFILE={$this->home}");
});

afterEach(function () {
    putenv($this->originalHome === false ? 'HOME' : "HOME={$this->originalHome}");
    putenv($this->originalUserProfile === false ? 'USERPROFILE' : "USERPROFILE={$this->originalUserProfile}");
    removeDirectory($this->home);
});

it('shows no default vault when none is saved', function () {
    $this->artisan('vault:config')->assertSuccessful();

    expect(GlobalConfig::vault())->toBeNull();
});

it('saves and shows a default vault path', function () {
    $vault = sys_get_temp_dir().'/obsidian-notes-cli-vault-'.uniqid();
    mkdir($vault, 0755, recursive: true);

    $this->artisan('vault:config', ['path' => $vault])->assertSuccessful();

    expect(GlobalConfig::vault())->toBe($vault);

    $this->artisan('vault:config')->assertSuccessful();

    removeDirectory($vault);
});

it('fails for a vault path that does not exist', function () {
    $this->artisan('vault:config', ['path' => $this->home.'/does-not-exist'])
        ->assertFailed();
});

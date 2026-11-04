# Changelog

All notable changes to this project will be documented in this file.

## [1.1.0] - 2026-11-04

### Bug Fixes

- Pin PHP floor to 8.3 for Laravel Zero 13

### CI/CD

- Pass release version input through env
- Standardize dependabot config
- Standardize tests workflow
- Remove run-tests.yml (replaced by tests.yml)
- Standardize tests workflow
- Auto-merge dependabot github-actions minor/patch

### Dependencies

- **deps:** Bump orhun/git-cliff-action in the actions-deps group
- **deps:** Bump shivammathur/setup-php (#17)
- **deps:** Bump stefanzweifel/git-auto-commit-action (#20)

### Documentation

- Point tests badge to tests.yml

### Miscellaneous Tasks

- **deps-dev:** Bump phpstan/phpstan
- **deps-dev:** Bump phpstan/phpstan
- **deps-dev:** Bump phpstan/phpstan

### Other

- Bump the all-composer group with 4 updates

Bumps the all-composer group with 4 updates: [jeffersongoncalves/laravel-zero-self-update](https://github.com/jeffersongoncalves/laravel-zero-self-update), [laravel-zero/framework](https://github.com/laravel-zero/framework), [laravel/pint](https://github.com/laravel/pint) and [phpstan/phpstan](https://github.com/phpstan/phpstan-phar-composer-source).


Updates `jeffersongoncalves/laravel-zero-self-update` from 1.0.1 to 1.1.0
- [Release notes](https://github.com/jeffersongoncalves/laravel-zero-self-update/releases)
- [Changelog](https://github.com/jeffersongoncalves/laravel-zero-self-update/blob/main/CHANGELOG.md)
- [Commits](https://github.com/jeffersongoncalves/laravel-zero-self-update/compare/v1.0.1...v1.1.0)

Updates `laravel-zero/framework` from 12.1.0 to 13.0.0
- [Release notes](https://github.com/laravel-zero/framework/releases)
- [Changelog](https://github.com/laravel-zero/framework/blob/13.x/CHANGELOG.md)
- [Commits](https://github.com/laravel-zero/framework/compare/v12.1.0...v13.0.0)

Updates `laravel/pint` from 1.30.5 to 1.32.1
- [Release notes](https://github.com/laravel/pint/releases)
- [Changelog](https://github.com/laravel/pint/blob/main/CHANGELOG.md)
- [Commits](https://github.com/laravel/pint/compare/v1.30.5...v1.32.1)

Updates `phpstan/phpstan` from 2.2.10 to 2.2.13
- [Commits](https://github.com/phpstan/phpstan-phar-composer-source/commits)

---
updated-dependencies:
- dependency-name: jeffersongoncalves/laravel-zero-self-update
  dependency-version: 1.1.0
  dependency-type: direct:development
  update-type: version-update:semver-minor
  dependency-group: all-composer
- dependency-name: laravel-zero/framework
  dependency-version: 13.0.0
  dependency-type: direct:development
  update-type: version-update:semver-major
  dependency-group: all-composer
- dependency-name: laravel/pint
  dependency-version: 1.32.1
  dependency-type: direct:development
  update-type: version-update:semver-minor
  dependency-group: all-composer
- dependency-name: phpstan/phpstan
  dependency-version: 2.2.13
  dependency-type: direct:development
  update-type: version-update:semver-patch
  dependency-group: all-composer
...

Signed-off-by: dependabot[bot] <support@github.com>
- Auto-assign issues and pull requests

Co-Authored-By: Claude Opus 5.5 <noreply@anthropic.com>

## [1.0.6] - 2026-09-10

### Features

- Add note:read command to strip frontmatter (#6)

## [1.0.5] - 2026-09-08

### Bug Fixes

- **ci:** Publish release as draft until PHAR asset is attached
- **ci:** Use the correct resolve-version output in the publish step

### Documentation

- Add Buy Me a Coffee sponsor link

### Miscellaneous Tasks

- Add GitHub Sponsors to FUNDING.yml

## [1.0.4] - 2026-08-30

### Other

- Init now saves the vault as the default

## [1.0.3] - 2026-08-30

### Other

- Expand README: full command reference, contract details, Windows build note
- Add vault:config command to persist a default vault path

## [1.0.2] - 2026-08-30

### Other

- Move guzzlehttp/guzzle to require-dev

The compiled phar bundles every dependency regardless of require vs
require-dev (release.yml never runs composer with --no-dev) -- require
stays runtime-only (php), matching the rest of the *-cli ecosystem.

## [1.0.1] - 2026-08-30

### Other

- Fix CI hang: drop --parallel from pest (paratest hung indefinitely on the runner, unnecessary for 3 tests)
- Touch release.yml to force GitHub Actions to index it
- Remove reindex-trigger comment

## [1.0.0] - 2026-08-30

### Other

- Initial commit: Obsidian Notes CLI

Laravel Zero CLI that writes structured Markdown notes with Obsidian-ready
frontmatter into a vault. Part of a 3-repo integration with the
obsidian-claude-notes Obsidian plugin and the claude-code-obsidian-notes
Claude Code plugin.
- Add dependabot config (composer + github-actions, weekly grouped)
- Add portfolio banner to README
- Fix CI: drop empty Unit testsuite, restrict test matrix to PHP 8.4

Unit testsuite pointed at tests/Unit, which git doesn't track once empty --
fresh CI checkouts had no directory there and paratest failed outright.



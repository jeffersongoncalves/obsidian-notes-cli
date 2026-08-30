# Changelog

All notable changes to this project will be documented in this file.

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



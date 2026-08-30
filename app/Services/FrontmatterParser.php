<?php

namespace App\Services;

class FrontmatterParser
{
    /**
     * Parses the flat `key: value` frontmatter block written by NoteWriterService.
     * Not a general YAML parser — only handles what this CLI itself writes.
     */
    public static function parse(string $content): array
    {
        if (! preg_match('/^---\n(.*?)\n---/s', $content, $matches)) {
            return [];
        }

        $frontmatter = [];

        foreach (explode("\n", $matches[1]) as $line) {
            if (! str_contains($line, ':')) {
                continue;
            }

            [$key, $value] = explode(':', $line, 2);
            $frontmatter[trim($key)] = trim($value);
        }

        return $frontmatter;
    }
}

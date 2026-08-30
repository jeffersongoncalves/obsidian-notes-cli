<?php

namespace App\Services;

use App\DTOs\NoteConfig;
use Illuminate\Support\Str;

class NoteWriterService
{
    /**
     * @return array{path: string, frontmatter: array}
     */
    public function write(NoteConfig $config, string $project, string $title, array $tags, string $body): array
    {
        $relativePath = strtr($config->folderPattern, [
            '{project}' => Str::slug($project),
            '{date}' => now()->toDateString(),
            '{slug}' => Str::slug($title),
        ]);

        $path = $config->vaultPath.DIRECTORY_SEPARATOR.str_replace('/', DIRECTORY_SEPARATOR, $relativePath);

        $created = $this->existingCreatedAt($path) ?? now()->toIso8601String();

        $frontmatter = array_merge($config->frontmatterDefaults, [
            'project' => $project,
            'title' => $title,
            'tags' => array_values(array_unique([...($config->frontmatterDefaults['tags'] ?? []), ...$tags])),
            'created' => $created,
            'updated' => now()->toIso8601String(),
        ]);

        @mkdir(dirname($path), 0755, recursive: true);
        file_put_contents($path, $this->render($frontmatter, $body));

        return ['path' => $path, 'frontmatter' => $frontmatter];
    }

    private function existingCreatedAt(string $path): ?string
    {
        if (! is_file($path)) {
            return null;
        }

        return FrontmatterParser::parse(file_get_contents($path))['created'] ?? null;
    }

    private function render(array $frontmatter, string $body): string
    {
        $lines = ['---'];

        foreach ($frontmatter as $key => $value) {
            $lines[] = is_array($value)
                ? "{$key}: [".implode(', ', $value).']'
                : "{$key}: {$value}";
        }

        $lines[] = '---';
        $lines[] = '';
        $lines[] = $body;

        return implode("\n", $lines)."\n";
    }
}

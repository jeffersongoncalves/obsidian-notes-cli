<?php

namespace App\Services;

use App\DTOs\NoteConfig;
use GuzzleHttp\Client;
use Throwable;

class BridgeClient
{
    public function __construct(private readonly Client $http = new Client) {}

    /**
     * Best-effort push to the Obsidian plugin's local bridge so its sidebar refreshes
     * instantly. The file on disk is already the source of truth — if the bridge is
     * off or Obsidian isn't running, Obsidian still picks up the change natively on
     * next focus, so any failure here is silently ignored.
     */
    public function notify(NoteConfig $config, string $path, array $frontmatter, string $body): void
    {
        try {
            $this->http->post("http://127.0.0.1:{$config->bridgePort}/notes", [
                'json' => ['path' => $path, 'frontmatter' => $frontmatter, 'content' => $body],
                'timeout' => 1,
                'connect_timeout' => 0.5,
            ]);
        } catch (Throwable) {
        }
    }
}

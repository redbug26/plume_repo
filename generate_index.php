<?php

/**
 * generate_index.php
 * Generates a Markdown index combining short stories and blog posts.
 * - Stories use the file modification date.
 * - Blog posts use the frontmatter date (if available).
 * - Stories are listed briefly; blog posts include full content.
 */

$githubBaseUrl = 'https://raw.githubusercontent.com/swzzl-com/gutenmark/refs/heads/master/';

$storiesDir = __DIR__ . '/stories';
$blogDir = __DIR__ . '/blog';
$outputFile = __DIR__ . '/index.md';

// --- Parse frontmatter (YAML-style) ---
function parseFrontMatter($content)
{
    if (preg_match('/^---(.*?)---/s', $content, $matches)) {
        $yaml = trim($matches[1]);
        $data = [];
        foreach (explode("\n", $yaml) as $line) {
            if (strpos($line, ':') !== false) {
                [$key, $value] = explode(':', $line, 2);
                $data[trim($key)] = trim(trim($value), '"\'');
            }
        }
        return $data;
    }
    return [];
}

// --- Collect Markdown files ---
function collectFiles($dir, $type)
{
    global $githubBaseUrl;

    $files = glob("$dir/*.md");
    $items = [];

    foreach ($files as $file) {
        $content = file_get_contents($file);
        $meta = parseFrontMatter($content);
        $title = $meta['title'] ?? basename($file);
        $author = $meta['author'] ?? 'Unknown';

        // For stories, use file modification time
        $date = ($type === 'story')
            ? date('Y-m-d', filemtime($file))
            : ($meta['date'] ?? date('Y-m-d', filemtime($file)));

        if ($type === 'blog') {
            // For blog posts, extract body without frontmatter
            $body = preg_replace('/^---.*?---/s', '', $content, 1);
            $body = trim($body);
        } else if ($type === 'story') { // use the frontmatter to generate a summary

            $title = $meta['title'] ?? 'Untitled Story';
            $author = $meta['author'] ?? 'Unknown Author';

            $body = '';
            $body = "Title: $title\n";
            $body .= "Author: $author\n";
            $body .= "Date: $date\n\n";

            // Remove frontmatter   

            $body .= preg_replace('/^---.*?---/s', '', $content, 1);
            $body = trim($body);
            // Extract first paragraph as summary
            if (preg_match('/^(.*?)(\n\n|$)/s', $body, $paraMatch)) {
                $body = trim($paraMatch[1]);
            } else {
                $body = '';
            }
        }

        // convertit path vers github

        $relativePath = str_replace(__DIR__ . '/', '', $file);
        $file = "$githubBaseUrl/$relativePath";

        $items[] = [
            'type' => $type,
            'path' => $file,
            'title' => $title,
            'author' => $author,
            'date' => $date,
            'body' => trim($body),
        ];
    }

    return $items;
}

// --- Collect stories and blog posts ---
$stories = collectFiles($storiesDir, 'story');
$posts = collectFiles($blogDir, 'blog');
$all = array_merge($stories, $posts);

// --- Sort by date descending ---
usort($all, fn($a, $b) => strcmp($b['date'], $a['date']));

// --- Generate index.md ---
$md = "# 🪶 Plume Index\n\n";
$md .= "_Last updated on " . date('Y-m-d H:i') . "_\n\n";

foreach ($all as $item) {
    if ($item['type'] === 'story') {
        $md .= "## 📖 New book: [{$item['title']}]({$item['path']})\n";
        $md .= "_{$item['author']}_ — {$item['date']}\n\n";
        $md .= "{$item['body']}\n\n---\n\n";
    } else {
        $md .= "## 📰 News: {$item['title']}\n";
        $md .= "_{$item['author']}_ — {$item['date']}\n\n";
        $md .= "{$item['body']}\n\n---\n\n";
    }
}

file_put_contents($outputFile, $md);
echo "✅ index.md generated successfully: $outputFile\n";

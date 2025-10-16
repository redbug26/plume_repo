#!/usr/bin/env php
<?php
/**
 * convert_gutenberg_to_md.php
 *
 * Convertit un ou plusieurs fichiers texte du Projet Gutenberg en Markdown
 * avec en-tête YAML pour l’application Plume.
 */

if ($argc < 2) {
    fwrite(STDERR, "Usage: php convert_gutenberg_to_md.php <fichiers.txt>\n");
    exit(1);
}

function extractGutenbergText($text)
{
    // Supprime les entêtes et pieds de page
    $text = preg_replace('/^.*\*\*\* START OF.*?\*\*\*/ism', '', $text);
    $text = preg_replace('/\*\*\* END OF.*?\*\*\*.*$/ism', '', $text);

    // Nettoyage des caractères de contrôle
    $text = str_replace("\r", '', $text);

    // Sépare les paragraphes sur les doubles retours à la ligne
    $paragraphs = preg_split("/\n\s*\n/", trim($text));

    // Supprime les retours à la ligne internes dans chaque paragraphe
    foreach ($paragraphs as &$p) {
        // Supprime les coupures de ligne et espaces multiples
        $p = preg_replace("/\s*\n\s*/", " ", trim($p));
        $p = preg_replace("/ {2,}/", " ", $p);
    }

    return implode("\n\n", $paragraphs);
}

function extractMetadata($text)
{
    $meta = [
        'title' => null,
        'author' => null,
        'language' => null,
        'release_date' => null
    ];

    if (preg_match('/Title:\s*(.+)/i', $text, $m)) $meta['title'] = trim($m[1]);
    if (preg_match('/Author:\s*(.+)/i', $text, $m)) $meta['author'] = trim($m[1]);
    if (preg_match('/Language:\s*(.+)/i', $text, $m)) $meta['language'] = trim($m[1]);
    if (preg_match('/Release Date:\s*(.+)/i', $text, $m)) $meta['release_date'] = trim($m[1]);

    return $meta;
}

function convertToMarkdown($text)
{
    // Italique et tirets
    $text = preg_replace("/_([^_]+)_/", "*$1*", $text);
    $text = str_replace("--", "—", $text);

    // Retire les espaces excédentaires
    $text = preg_replace("/\n{3,}/", "\n\n", $text);
    return trim($text);
}

function generateYAML($meta, $wordCount)
{
    $yaml = "---\n";
    $yaml .= "title: \"" . ($meta['title'] ?? 'Untitled') . "\"\n";
    $yaml .= "author: \"" . ($meta['author'] ?? 'Unknown') . "\"\n";
    if (!empty($meta['language'])) $yaml .= "language: \"" . $meta['language'] . "\"\n";
    if (!empty($meta['release_date'])) $yaml .= "release_date: \"" . $meta['release_date'] . "\"\n";
    $yaml .= "word_count: $wordCount\n";
    $yaml .= "---\n\n";
    return $yaml;
}

foreach (array_slice($argv, 1) as $pattern) {
    foreach (glob($pattern) as $file) {
        echo "⏳ Conversion de $file...\n";
        $text = file_get_contents($file);

        $meta = extractMetadata($text);
        $body = extractGutenbergText($text);
        $mdBody = convertToMarkdown($body);
        $wordCount = str_word_count($mdBody);

        $yaml = generateYAML($meta, $wordCount);
        $md = $yaml . $mdBody;

        $outputFile = preg_replace('/\.txt$/', '.md', $file);
        file_put_contents($outputFile, $md);
        echo "✅ Fichier généré : $outputFile\n";
    }
}
?>
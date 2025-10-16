#!/usr/bin/env php
<?php
/**
 * update_wordcount.php
 * 
 * Utilisation :
 *   php update_wordcount.php "nouvelles/*.md"
 * 
 * Pour chaque fichier correspondant au wildcard :
 *  - lit le contenu YAML (entre --- ... ---)
 *  - calcule le nombre de words du reste du texte
 *  - met à jour ou ajoute le champ "words" dans le YAML
 */

if ($argc < 2) {
    fwrite(STDERR, "Usage: php update_wordcount.php \"pattern\"\n");
    exit(1);
}

$pattern = $argv[1];
$files = glob($pattern, GLOB_BRACE);
if (empty($files)) {
    fwrite(STDERR, "Aucun fichier trouvé pour le motif : $pattern\n");
    exit(1);
}

foreach ($files as $file) {
    $content = file_get_contents($file);
    if ($content === false) {
        fwrite(STDERR, "Impossible de lire $file\n");
        continue;
    }

    // Détection du YAML (--- ... ---)
    if (preg_match('/^---(.*?)---(.*)$/s', $content, $matches)) {
        $yaml = trim($matches[1]);
        $body = trim($matches[2]);
    } else {
        // Pas de YAML → on le crée
        $yaml = '';
        $body = trim($content);
    }

    // Calcul du nombre de words
    $wordCount = str_word_count(strip_tags($body));

    // Mise à jour ou ajout du champ "words"
    if (preg_match('/^words\s*:\s*\d+/m', $yaml)) {
        $yaml = preg_replace('/^words\s*:\s*\d+/m', "words: $wordCount", $yaml);
    } else {
        $yaml .= "\n" . "words: $wordCount";
        $yaml = trim($yaml);
    }

    // Reconstruction du fichier
    $newContent = "---\n$yaml\n---\n\n$body\n";

    if (file_put_contents($file, $newContent) === false) {
        fwrite(STDERR, "Erreur lors de l’écriture de $file\n");
    } else {
        echo "✅ $file : $wordCount words\n";
    }
}

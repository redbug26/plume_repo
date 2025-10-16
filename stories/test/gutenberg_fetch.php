<?php

/**
 * Télécharge une centaine de nouvelles françaises du domaine public depuis Project Gutenberg
 * et les regroupe en un fichier ZIP sans aucune modification du contenu.
 *
 * Usage :
 *   php gutenberg_fr.php
 */

$ids = [
    // Guy de Maupassant — Contes et nouvelles complets
    3090,
    17395,
    46838,
    24029,
    24030,
    24031,
    24032,
    // Alphonse Daudet — Lettres de mon moulin
    12822,
    45817,
    14931,
    // Émile Zola — Nouvelles
    16801,
    22952,
    24452,
    // Prosper Mérimée
    2450,
    3478,
    1937,
    1731,
    // Balzac
    1355,
    17495,
    19123,
    17743,
    1933,
    // Théophile Gautier
    25529,
    18384,
    25033,
    // Charles Nodier
    16562,
    28037,
    31142,
    // Anatole France
    18268,
    18459,
    22843,
    // Jules Renard
    15073,
    18341,
    // Villiers de l’Isle-Adam
    25992,
    23337,
    22926,
    // Marcel Schwob
    17439,
    17440,
    // Alphonse Allais
    15659,
    16233,
    21964,
    // Octave Mirbeau
    17928,
    22388,
    18527,
    // Paul Arène
    19000,
    20170,
    // Catulle Mendès
    18724,
    18833,
    // Joris-Karl Huysmans
    17455,
    17456,
    // Gustave Flaubert
    14281,
    16688,
    13815,
    // Henri de Régnier
    17547,
    19618,
    // Gérard de Nerval
    20242,
    20243,
    // Jules Claretie
    20507,
    22362,
    // Paul Bourget
    20521,
    21973,
    // Édouard Rod
    20459,
    20460,
    // George Sand
    16598,
    18592,
    18859,
    // Maurice Level
    18796,
    18800,
    // Jean Lorrain
    18927,
    18928,
    // Marcel Proust (premiers textes)
    23875,
    24165,
];

$outputDir = __DIR__ . '/gutenberg_fr';
$zipFile = __DIR__ . '/gutenberg_francaises.zip';

if (!is_dir($outputDir)) mkdir($outputDir);

function downloadText($id, $outputDir)
{
    $urls = [
        "https://www.gutenberg.org/files/$id/$id-0.txt",
        "https://www.gutenberg.org/files/$id/$id.txt",
        "https://www.gutenberg.org/cache/epub/$id/pg$id.txt"
    ];
    foreach ($urls as $url) {
        echo "→ Téléchargement de $url...\n";
        $content = @file_get_contents($url);
        if ($content && strlen($content) > 5000) {
            $path = "$outputDir/$id.txt";
            file_put_contents($path, $content);
            echo "   ✔ Enregistré : $path\n";
            return $path;
        }
    }
    echo "   ✖ Échec pour $id\n";
    return null;
}

// Téléchargement de tous les textes
$textFiles = [];
foreach ($ids as $id) {
    $path = downloadText($id, $outputDir);
    if ($path) $textFiles[] = $path;
}

// Création du ZIP
$zip = new ZipArchive();
if ($zip->open($zipFile, ZipArchive::CREATE | ZipArchive::OVERWRITE)) {
    foreach ($textFiles as $file) {
        $zip->addFile($file, basename($file));
    }
    $zip->close();
    echo "\n📦 Archive créée : $zipFile (" . count($textFiles) . " fichiers)\n";
} else {
    echo "❌ Impossible de créer l’archive ZIP.\n";
}

echo "\nTerminé.\n";

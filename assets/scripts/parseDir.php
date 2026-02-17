<?php
/**
 * Parcourt un répertoire et concatène le contenu des fichiers dans un seul fichier,
 * avec possibilité de filtrer les noms de fichiers par motif (glob).
 *
 * Usage :
 * php parseDir.php <repertoire> <motif> <fichier_sortie>
 *
 * Exemple :
 * php parseDir.php ./src/Repository/ "*Repository.php" ./resultat.txt
 * php parseDir.php ./src/Domain/Criteria/ "*Criteria.php" ./resultat.txt
 */

if ($argc < 4) {
    echo "Usage: php {$argv[0]} <repertoire> <motif> <fichier_sortie>\n";
    exit(1);
}

$dir        = './../.'.$argv[1];
$pattern    = $argv[2];
$outputFile = $argv[3];

if (!is_dir($dir)) {
    echo "Erreur : $dir n'est pas un répertoire valide.\n";
    exit(1);
}

$handle = fopen($outputFile, 'w');
if (!$handle) {
    echo "Impossible d'ouvrir le fichier de sortie : $outputFile\n";
    exit(1);
}

// Utilisation de glob pour appliquer le motif
$files = glob($dir . DIRECTORY_SEPARATOR . $pattern);

foreach ($files as $filePath) {
    if (!is_file($filePath)) {
        continue;
    }

    $file = basename($filePath);
    $content = file_get_contents($filePath);
    if ($content === false) {
        echo "Impossible de lire le fichier : $filePath\n";
        continue;
    }

    fwrite($handle, "=== $file ===\n");
    fwrite($handle, $content . "\n\n");
}

fclose($handle);

echo "Concaténation terminée. Résultat dans : $outputFile\n";

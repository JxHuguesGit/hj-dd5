<?php
$baseDir = __DIR__ . '/../../src'; // racine de ton projet
$outputFile = __DIR__ . '/sortieAnalyseUse.txt'; // fichier de sortie

$iterator = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($baseDir)
);

$lines = [];
foreach ($iterator as $file) {
    if (!$file->isFile() || $file->getExtension() !== 'php') {
        continue;
    }

    $content = file_get_contents($file->getPathname());

    // Récupère tous les use statements
    preg_match_all('/^use\s+([^\s;]+);/m', $content, $matches);
    $uses = $matches[1];

    foreach ($uses as $use) {
        $shortName = substr($use, strrpos($use, '\\') + 1);

        // Vérifie si le nom apparaît dans le code (après la ligne use)
        $afterUse = preg_replace('/^use\s+[^\s;]+;/m', '', $content);

        if (strpos($afterUse, $shortName) === false) {
            $lines[] = "Fichier: {$file->getPathname()}\n";
            $lines[] = "  Use non utilisé: $use\n\n";
        }
    }
}

file_put_contents($outputFile, implode(PHP_EOL, $lines));

echo "Fichiers listés dans $outputFile\n";

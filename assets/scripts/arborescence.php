<?php
$root = __DIR__ . '/../../src'; // racine à parcourir
$outputFile = __DIR__ . '/files.txt'; // fichier de sortie

$iterator = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($root, RecursiveDirectoryIterator::SKIP_DOTS)
);

$lines = [];
foreach ($iterator as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        // Chemin relatif à la racine
        $relativePath = str_replace($root, '', $file->getPathname()); // Normaliser séparateurs en backslash
        $namespacePath = '\\src' . str_replace('/', '\\', $relativePath);
        $lines[] = $namespacePath;
    }
}

file_put_contents($outputFile, implode(PHP_EOL, $lines));

echo "Fichiers listés dans $outputFile\n";
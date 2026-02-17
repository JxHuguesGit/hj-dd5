<?php

// Récupération des arguments
$args = $argv;
array_shift($args); // remove script name

$showDirs = false;
$showFiles = false;
$pathArg = null;

// Analyse des arguments
foreach ($args as $arg) {
    if ($arg === '-d') {
        $showDirs = true;
    } elseif ($arg === '-f') {
        $showFiles = true;
    } else {
        // C'est un chemin
        $pathArg = $arg;
    }
}

// Si aucune option n'est fournie → fichiers par défaut
if (!$showDirs && !$showFiles) {
    $showFiles = true;
}

// Détermination du répertoire racine
$baseRoot = realpath(__DIR__ . '/../../src');
$root = $baseRoot;

if ($pathArg !== null) {
    $candidate = realpath($baseRoot . '/' . $pathArg);
    if ($candidate === false || !is_dir($candidate)) {
        echo "Erreur : le répertoire '$pathArg' n'existe pas dans src/\n";
        exit(1);
    }
    $root = $candidate;
}

$outputFile = __DIR__ . '/files.txt';

// Itérateur
$directoryIterator = new RecursiveDirectoryIterator($root, RecursiveDirectoryIterator::SKIP_DOTS);
$iterator = new RecursiveIteratorIterator($directoryIterator, RecursiveIteratorIterator::SELF_FIRST);

$lines = [];

foreach ($iterator as $item) {

    $relativePath = str_replace($baseRoot, '', $item->getPathname());
    $relativePath = ltrim($relativePath, DIRECTORY_SEPARATOR);

    // Affichage des répertoires
    if ($showDirs && $item->isDir()) {
        $lines[] = '[DIR]  ' . $relativePath;
    }

    // Affichage des fichiers PHP
    if ($showFiles && $item->isFile() && $item->getExtension() === 'php') {
        $lines[] = '[FILE] ' . $relativePath;
    }
}

file_put_contents($outputFile, implode(PHP_EOL, $lines));

echo "Résultat écrit dans $outputFile\n";

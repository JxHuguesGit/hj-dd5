#!/usr/bin/env php
<?php

$root = realpath(__DIR__ . '/../../src');
$outputFile = __DIR__ . '/unusedClasses.txt';

if (!$root || !is_dir($root)) {
    die("Répertoire src introuvable.\n");
}

echo "Analyse en cours...\n";

// ------------------------------------------------------------
// 1. Récupérer toutes les classes déclarées dans le projet
// ------------------------------------------------------------
$classes = []; // [className => filePath]

$iterator = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($root, RecursiveDirectoryIterator::SKIP_DOTS)
);

foreach ($iterator as $file) {
    if (!$file->isFile() || $file->getExtension() !== 'php') {
        continue;
    }

    $content = file_get_contents($file->getRealPath());

    // Extraction namespace
    $namespace = '';
    if (preg_match('/namespace\s+([^;]+);/', $content, $m)) {
        $namespace = trim($m[1]);
    }

    // Extraction classes
    if (preg_match_all('/class\s+([A-Za-z0-9_]+)/', $content, $matches)) {
        foreach ($matches[1] as $className) {
            $fullName = $namespace ? "$namespace\\$className" : $className;
            $classes[$fullName] = $file->getRealPath();
        }
    }
}

// ------------------------------------------------------------
// 2. Scanner tous les fichiers pour voir si les classes sont utilisées
// ------------------------------------------------------------
$usage = array_fill_keys(array_keys($classes), false);

foreach ($iterator as $file) {
    if (!$file->isFile() || $file->getExtension() !== 'php') {
        continue;
    }

    $content = file_get_contents($file->getRealPath());

    // Namespace du fichier scanné
    $fileNamespace = '';
    if (preg_match('/namespace\s+([^;]+);/', $content, $m)) {
        $fileNamespace = trim($m[1]);
    }

    foreach ($classes as $class => $path) {

        // On ignore le fichier où la classe est déclarée
        if ($path === $file->getRealPath()) {
            continue;
        }

        $short = basename(str_replace('\\', '/', $class));
        $classNamespace = substr($class, 0, strrpos($class, '\\'));

        // Recherche d'utilisation
        if (
            strpos($content, $class) !== false || // usage complet
            preg_match('/use\s+' . preg_quote($class, '/') . '\s*;/', $content) ||
            preg_match('/new\s+' . preg_quote($short, '/') . '\b/', $content) ||
            preg_match('/extends\s+' . preg_quote($short, '/') . '\b/', $content) ||
            preg_match('/implements\s+.*\b' . preg_quote($short, '/') . '\b/', $content) ||
            preg_match('/\b' . preg_quote($short, '/') . '::class\b/', $content) ||
            preg_match('/\b' . preg_quote($class, '/') . '::class\b/', $content)
        ) {
            $usage[$class] = true;
            continue;
        }

        // 🔥 NOUVEAU : appel statique dans le même namespace
        if ($fileNamespace === $classNamespace && preg_match('/\b' . preg_quote($short, '/') . '::/', $content)) {
            $usage[$class] = true;
            continue;
        }
    }
}

// ------------------------------------------------------------
// 3. Extraire les classes non utilisées
// ------------------------------------------------------------
$unused = array_filter($usage, fn($used) => !$used);

$out = [];
$out[] = "=== Classes non utilisées ===";
$out[] = "";

foreach ($unused as $class => $used) {
    $out[] = "$class  -->  {$classes[$class]}";
}

file_put_contents($outputFile, implode(PHP_EOL, $out));

echo "Analyse terminée. Résultat dans $outputFile\n";
echo "Nombre de classes non utilisées : " . count($unused) . "\n";

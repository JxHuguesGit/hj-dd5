<?php

$root = realpath(__DIR__ . '/../../src'); // point de départ du scan
$outputFile = __DIR__ . '/repository_usage_report.txt';

$ignoredDirs = [
    'Repository',
    'RepositoryInterface',
    'Reader',
];

$ignoredFiles = [
    'RepositoryFactory.php',
    'ReaderFactory.php',
];

$results = [];

$iterator = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($root, RecursiveDirectoryIterator::SKIP_DOTS)
);

foreach ($iterator as $file) {
    if (!$file->isFile()) {
        continue;
    }

    $filePath = $file->getPathname();
    $fileName = $file->getFilename();

    // Ignorer les fichiers spécifiques
    if (in_array($fileName, $ignoredFiles, true)) {
        continue;
    }

    // Ignorer les dossiers Repository* et Reader*
    foreach ($ignoredDirs as $ignored) {
        if (str_contains($filePath, DIRECTORY_SEPARATOR . $ignored . DIRECTORY_SEPARATOR)) {
            continue 2;
        }
    }

    // Lire le contenu
    $content = file_get_contents($filePath);

    // Chercher "Repository" dans le contenu
    if (preg_match('/\b[A-Za-z0-9_]*Repository\b/', $content, $matches)) {
        $results[] = [
            'file' => $filePath,
            'match' => $matches[0],
        ];
    }
}

// Génération du rapport
$report = "=== Repository Usage Report ===\n\n";

if (empty($results)) {
    $report .= "Aucune utilisation suspecte de Repository trouvée.\n";
} else {
    foreach ($results as $entry) {
        $report .= "- {$entry['file']} → {$entry['match']}\n";
    }
}

file_put_contents($outputFile, $report);

echo "Analyse terminée. Rapport généré dans : $outputFile\n";

#!/usr/bin/env php
<?php

/**
 * Ligne de script à saisir pour lancer l'analyse :
 * php assets/scripts/analyseConstantes.php -json -excluded -nb 10
 */
$baseDir     = realpath(__DIR__ . '/../../src');
$constantDir = $baseDir . '/Constant';
$outputFile  = __DIR__ . '/analyseConstante.txt';

if (!$baseDir || !is_dir($constantDir)) {
    die("Arborescence invalide.\n");
}

// ---------------------
// Paramètres
// ---------------------
$jsonOutput   = in_array('-json', $argv);
$excludedMode = in_array('-excluded', $argv);

// Nombre de fichiers à afficher
$nbFiles = 20;
foreach ($argv as $i => $arg) {
    if ($arg === '-nb' && isset($argv[$i + 1]) && is_numeric($argv[$i + 1])) {
        $nbFiles = (int)$argv[$i + 1];
    }
}

$excludedFiles = [];
if ($excludedMode) {
    $excludedPath = __DIR__ . '/excludedFiles.txt';
    if (file_exists($excludedPath)) {
        $excludedFiles = array_map('trim', file($excludedPath));
        $excludedFiles = array_filter($excludedFiles);
    }
}

// ---------------------
// 1. Collecte des constantes
// ---------------------
$constants = []; // "Class::CONST" => valeur
foreach (glob($constantDir . '/*.php') as $file) {
    $content = file_get_contents($file);
    preg_match('/class\s+(\w+)/', $content, $classMatch);
    if (!$classMatch) {
        continue;
    }
    $className = $classMatch[1];

    preg_match_all('/public\s+const\s+([A-Z0-9_]+)\s*=\s*([^;]+);/', $content, $matches, PREG_SET_ORDER);
    foreach ($matches as $m) {
        $key = $className . '::' . $m[1];
        $raw = trim($m[2]);
        if (preg_match('/^[\'"](.+)[\'"]$/', $raw, $vm)) {
            $constants[$key] = stripslashes($vm[1]);
        } else {
            $constants[$key] = null;
        }
    }
}

// ---------------------
// 2. Scan des fichiers
// ---------------------
$filesData = [];
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($baseDir));

foreach ($iterator as $file) {
    if (!$file->isFile() || $file->getExtension() !== 'php') {
        continue;
    }

    $path = str_replace('\\', '/', $file->getRealPath());
    $constDirNormalized = str_replace('\\', '/', $constantDir);

    // Skip Constant dir
    if (str_starts_with($path, $constDirNormalized)) {
        continue;
    }

    // Chemin relatif pour exclusion et sortie
    $relativePath = './' . str_replace('\\', '/', substr($path, strlen(dirname($baseDir)) + 1));
    if ($excludedMode && in_array($relativePath, $excludedFiles, true)) {
        continue;
    }

    $lines = file($path);

    $fileData = [
        'name' => $relativePath,
        'stringsWithConstant' => [],
        'stringsWithoutConstant' => [],
        'count' => 0,
    ];

    foreach ($lines as $lineNumber => $line) {
        // Chaînes littérales
        if (preg_match_all('/([\'"])(.*?)(?<!\\\\)\1/', $line, $stringMatches)) {
            foreach ($stringMatches[2] as $s) {
                $s = stripslashes($s);
                if ($s === '') {
                    continue;
                }

                $fileData['count']++;

                $foundConst = null;
                foreach ($constants as $cName => $cValue) {
                    if ($cValue !== null && $cValue === $s) {
                        $foundConst = $cName;
                        break;
                    }
                }

                if ($foundConst) {
                    if (!isset($fileData['stringsWithConstant'][$s])) {
                        $fileData['stringsWithConstant'][$s] = ['line' => 'L:' . ($lineNumber + 1), 'const' => $foundConst];
                    }
                } else {
                    if (!isset($fileData['stringsWithoutConstant'][$s])) {
                        $fileData['stringsWithoutConstant'][$s] = 'L:' . ($lineNumber + 1);
                    }
                }
            }
        }
    }

    $filesData[$relativePath] = $fileData;
}

// ---------------------
// 3. Top fichiers les plus "sales" par refactorScore
// ---------------------
foreach ($filesData as &$f) {
    $f['refactorScore'] = count($f['stringsWithConstant']) + count($f['stringsWithoutConstant']);
}
unset($f);

// Trier par refactorScore décroissant
usort($filesData, fn($a, $b) => $b['refactorScore'] <=> $a['refactorScore']);

// Limiter au top N fichiers
$topFiles = array_slice($filesData, 0, $nbFiles, true);

// ---------------------
// 4. Tri des chaînes par numéro de ligne
// ---------------------
foreach ($topFiles as &$f) {
    // Tri stringsWithConstant par ligne
    if (!empty($f['stringsWithConstant'])) {
        uasort($f['stringsWithConstant'], function($a, $b) {
            $lineA = (int) str_replace('L:', '', $a['line']);
            $lineB = (int) str_replace('L:', '', $b['line']);
            return $lineA <=> $lineB;
        });
    }

    // Tri stringsWithoutConstant par ligne
    if (!empty($f['stringsWithoutConstant'])) {
        uasort($f['stringsWithoutConstant'], function($a, $b) {
            $lineA = (int) str_replace('L:', '', $a);
            $lineB = (int) str_replace('L:', '', $b);
            return $lineA <=> $lineB;
        });
    }

    $f['refactorScore'] = count($f['stringsWithConstant']) + count($f['stringsWithoutConstant']);
}
unset($f);


// ---------------------
// 5. Rapport
// ---------------------
if ($jsonOutput) {
    file_put_contents($outputFile, json_encode($topFiles, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
} else {
    $out = [];
    foreach ($topFiles as $data) {
        $out[] = "=== Fichier: {$data['name']} === (Total chaînes: {$data['count']}, Score refactoring: {$data['refactorScore']})";

        if ($data['stringsWithConstant']) {
            $out[] = "  -> Strings avec constante";
            foreach ($data['stringsWithConstant'] as $str => $info) {
                $out[] = "      $str ({$info['line']}, {$info['const']})";
            }
        } else {
            $out[] = "  -> Strings avec constante (aucune)";
        }

        if ($data['stringsWithoutConstant']) {
            $out[] = "  -> Strings sans constante";
            foreach ($data['stringsWithoutConstant'] as $str => $line) {
                $out[] = "      $str ($line)";
            }
        } else {
            $out[] = "  -> Strings sans constante (aucune)";
        }

        $out[] = "";
    }

    file_put_contents($outputFile, implode(PHP_EOL, $out));
}

echo "Analyse terminée : {$outputFile}\n";
echo "Nombre de fichiers dans le compte-rendu : {$nbFiles}\n";
if ($excludedMode) {
    echo "Fichiers exclus : " . count($excludedFiles) . "\n";
}

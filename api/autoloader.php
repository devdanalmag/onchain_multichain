<?php

spl_autoload_register(function ($class_name) {
    // Resolve base path to core directory relative to this autoloader
    $baseCore = realpath(__DIR__ . '/../core');

    // Candidate paths to check (Models and Controllers)
    $candidates = [];
    if ($baseCore) {
        $candidates[] = $baseCore . DIRECTORY_SEPARATOR . 'Models' . DIRECTORY_SEPARATOR . $class_name . '.php';
        $candidates[] = $baseCore . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . $class_name . '.php';
    }

    // Fallbacks in case of unusual execution context
    $fallbacks = [
        realpath(__DIR__ . '/../../core/Models/' . $class_name . '.php'),
        realpath(__DIR__ . '/../../core/Controllers/' . $class_name . '.php'),
    ];

    foreach (array_merge($candidates, $fallbacks) as $path) {
        if ($path && file_exists($path)) {
            require_once $path;
            return;
        }
    }
});

?>
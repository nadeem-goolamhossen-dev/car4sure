<?php

/**
 * Returns the importmap for this application.
 *
 * - "path" is a path inside the asset mapper system. Use the
 *     "debug:asset-map" command to see the full list of paths.
 *
 * - "entrypoint" (JavaScript only) set to true for any module that will
 *     be used as an "entrypoint" (and passed to the importmap() Twig function).
 *
 * The "importmap:require" command can be used to add new entries to this file.
 */
return [
    'app' => [
        'path' => './assets/app.js',
        'entrypoint' => true,
    ],
    '@hotwired/stimulus' => [
        'version' => '3.2.2',
    ],
    '@symfony/stimulus-bundle' => [
        'path' => './vendor/symfony/stimulus-bundle/assets/dist/loader.js',
    ],
    '@hotwired/turbo' => [
        'version' => '7.3.0',
    ],
    'bootstrap' => [
        'version' => '5.3.3',
    ],
    'bootstrap/js/dist/alert' => [
        'version' => '5.3.3',
    ],
    'bootstrap/dist/css/bootstrap.min.css' => [
        'version' => '5.3.3',
        'type' => 'css',
    ],
    'jquery' => [
        'version' => '3.7.1',
    ],
    'bootstrap/js/dist/collapse' => [
        'version' => '5.3.3',
    ],
    'bootstrap/js/dist/dropdown' => [
        'version' => '5.3.3',
    ],
    'bootstrap/js/dist/tab' => [
        'version' => '5.3.3',
    ],
    'bootstrap/js/dist/modal' => [
        'version' => '5.3.3',
    ],
    '@fortawesome/fontawesome-free/css/all.css' => [
        'version' => '6.5.1',
        'type' => 'css',
    ],
    '@fortawesome/fontawesome-free/css/v4-shims.css' => [
        'version' => '6.5.1',
        'type' => 'css',
    ],
    '@popperjs/core' => [
        'version' => '2.11.8',
    ],
    'typeahead.js' => [
        'version' => '0.11.1',
    ],
];

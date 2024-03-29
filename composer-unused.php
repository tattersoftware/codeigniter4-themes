<?php

declare(strict_types=1);

use ComposerUnused\ComposerUnused\Configuration\Configuration;
use ComposerUnused\ComposerUnused\Configuration\NamedFilter;
use ComposerUnused\ComposerUnused\Configuration\PatternFilter;
use Webmozart\Glob\Glob;

return static fn (Configuration $config): Configuration => $config
    ->setAdditionalFilesFor('codeigniter4/framework', [
        ...Glob::glob(__DIR__ . '/vendor/codeigniter4/framework/system/Helpers/*.php'),
    ])
    ->setAdditionalFilesFor('tatter/preferences', [
        __DIR__ . '/vendor/tatter/preferences/src/Helpers/preferences_helper.php',
    ]);

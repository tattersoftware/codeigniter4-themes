<?php

namespace Tatter\Themes;

use CodeIgniter\Files\FileCollection;
use Tatter\Assets\Asset;
use Tatter\Assets\Bundle;
use Tatter\Themes\Entities\Theme;

/**
 * Theme Assets Bundle
 *
 * Provides theme-related assets.
 */
final class ThemeBundle extends Bundle
{
    public static function createFromTheme(Theme $theme): self
    {
        $config = Asset::config();

        if ($config->useCache) {
            // Use the hash of these items for the cache key
            $key = 'assets-theme' . $theme->id;

            // If there's a cached version then return it
            if ($bundle = cache($key)) {
                return $bundle;
            }
        }

        $bundle = new self();

        // Resolve the directory for the active theme
        $root      = rtrim(config('Assets')->directory, '/ ') . '/';
        $directory = $root . trim($theme->path, '/ ');

        // Locate all CSS and JSS files in the them path
        $files = (new FileCollection())
            ->addDirectory($directory)
            ->retainPattern('#(.*)\.css$|(.*)\.js$#i'); // limit to .css and .js files

        // Create an Asset from each relative path and add it to the Bundle
        foreach ($files as $file) {
            $relativePath = str_replace($root, '', $file);
            $bundle->add(Asset::createFromPath($relativePath));
        }

        if (isset($key)) {
            cache()->save($key, $bundle);
        }

        return $bundle;
    }
}

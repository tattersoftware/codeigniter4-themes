<?php

use Tatter\Themes\Entities\Theme;
use Tatter\Themes\Models\ThemeModel;

/**
 * Themes Helper
 */
if (! function_exists('theme')) {
    /**
     * Returns the current Theme.
     *
     * @throws RuntimeException
     */
    function theme(): Theme
    {
        if (! $name = preference('theme')) {
            throw new RuntimeException('Unable to determine the theme.');
        }

        if ($theme = model(ThemeModel::class)->where('name', $name)->first()) {
            return $theme;
        }

        throw new RuntimeException('Unable to locate the theme: ' . $name);
    }
}

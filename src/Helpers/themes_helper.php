<?php

use Tatter\Themes\Entities\Theme;
use Tatter\Themes\Models\ThemeModel;

/**
 * Themes Helper
 */
if (! function_exists('theme')) {
    /**
     * Returns the current Theme.
     */
    function theme(): Theme
    {
        return model(ThemeModel::class)->find((int) service('settings')->theme);
    }
}

if (! function_exists('themes_form')) {
    /**
     * Generates a form to select a theme.
     *
     * @param string   $class    Optional class to apply to the select field
     * @param int|null $selected ID of the current selection
     * @param bool     $auto     Whether the form should submit on change
     *
     * @deprecated Use the View directly
     */
    function themes_form(string $class = '', ?int $selected = null, bool $auto = false): string
    {
        return view('Tatter\Themes\Views\form', [
            'class'    => $class,
            'selected' => $selected,
            'auto'     => $auto,
        ]);
    }
}

if (! function_exists('themes_select')) {
    /**
     * Generates a select field using the current & available themes.
     *
     * @param string   $class    Optional class to apply to the element
     * @param int|null $selected ID of the current selection
     * @param bool     $auto     Whether the form should submit on change
     *
     * @deprecated Use the View directly
     */
    function themes_select(string $class = '', ?int $selected = null, bool $auto = false): string
    {
        return view('Tatter\Themes\Views\select', [
            'class'    => $class,
            'selected' => $selected,
            'auto'     => $auto,
        ]);
    }
}

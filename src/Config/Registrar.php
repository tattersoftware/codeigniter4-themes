<?php

namespace Tatter\Themes\Config;

class Registrar
{
    /**
     * Adds the default theme to Preferences.
     *
     * @return array<string,string>
     */
    public static function Preferences(): array
    {
        return [
            'theme' => 'Default',
        ];
    }
}

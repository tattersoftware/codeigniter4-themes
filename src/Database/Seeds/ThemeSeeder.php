<?php

namespace Tatter\Themes\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Tatter\Settings\Models\SettingModel;
use Tatter\Themes\Models\ThemeModel;

class ThemeSeeder extends Seeder
{
    /**
     * Checks for and creates the setting and default theme.
     */
    public function run()
    {
        // Check for theme setting
        $settings = model(SettingModel::class);
        if (! $settings->where('name', 'theme')->first()) { // @phpstan-ignore-line
            // No setting - add the template (compatible with Settings v1 & v2)
            $settings->insert([
                'name'      => 'theme',
                'datatype'  => 'int',
                'summary'   => 'Site display theme',
                'content'   => '1',
                'scope'     => 'user',
                'protected' => 0,
            ]);
        }

        // Check for default theme
        $themes = model(ThemeModel::class);
        if (! $themes->first()) {
            // No default theme - create one
            $themes->insert([
                'name'        => 'Default',
                'path'        => 'themes/default',
                'description' => 'Default theme',
            ]);
        }
    }
}

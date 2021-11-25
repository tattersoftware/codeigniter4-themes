<?php

namespace Tatter\Themes\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Tatter\Themes\Models\ThemeModel;

class ThemeSeeder extends Seeder
{
    /**
     * Checks for and creates the Default theme.
     */
    public function run()
    {
        $themes = model(ThemeModel::class);

        if (! $themes->first()) {
            $themes->insert([
                'name'        => 'Default',
                'path'        => 'themes/default',
                'description' => 'Default theme',
            ]);
        }
    }
}

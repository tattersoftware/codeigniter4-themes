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
		if (! model(SettingModel::class)->where('name', 'theme')->first())
		{
			// No setting - add the template (compatible with Settings v1 & v2)
			model(SettingModel::class)->insert([
				'name'      => 'theme',
				'datatype'  => 'int',
				'summary'   => 'Site display theme',
				'content'   => '1',
				'scope'     => 'user',
				'protected' => 0,
			]);
		}

		// Check for default theme
		if (! model(ThemeModel::class)->first())
		{
			// No default theme - create one
			model(ThemeModel::class)->insert([
				'name'        => 'Default',
				'path'        => 'themes/default',
				'description' => 'Default theme',
			]);
		}
	}
}

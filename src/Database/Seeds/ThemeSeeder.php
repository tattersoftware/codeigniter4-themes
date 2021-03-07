<?php namespace Tatter\Themes\Database\Seeds;

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
			// No setting - add the template
			model(SettingModel::class)->insert([
				'name'       => 'theme',
				'scope'      => 'user',
				'content'    => '1',
				'protected'  => 0,
				'summary'    => 'Site display theme',
			]);			
		}
		
		// Check for default theme
		if (! model(ThemeModel::class)->first())
		{
			// No default theme - create one
			model(ThemeModel::class)->insert([
				'name'         => 'Default',
				'path'         => 'themes/default',
				'description'  => 'Default theme',
			]);
		}
	}
}

<?php namespace Tatter\Themes\Database\Seeds;

use Tatter\Settings\Models\SettingModel;
use Tatter\Themes\Models\ThemeModel;

class ThemeSeeder extends \CodeIgniter\Database\Seeder
{
	public function run()
	{
		// Check for theme setting
		$settings = new SettingModel();
		$theme = $settings->where('name', 'theme')->first();
		if (empty($theme)):
			// No setting - add the template
			$row = [
				'name'       => 'theme',
				'scope'      => 'user',
				'content'    => '1',
				'protected'  => 0,
				'summary'    => 'Site display theme',
			];

			$settings->save($row);			
		endif;
		
		// Check for default theme
		$themes = new ThemeModel();
		$theme = $themes->first();
		if (empty($theme)):
			// No default theme - create one
			$row = [
				'name'         => 'Default',
				'path'         => 'themes/default',
				'description'  => 'Default theme',
			];
			$themes->save($row);
		endif;
	}
}
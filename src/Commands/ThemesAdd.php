<?php namespace Tatter\Themes\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use Tatter\Themes\Models\ThemeModel;

class ThemesAdd extends BaseCommand
{
    protected $group       = 'Themes';
    protected $name        = 'themes:add';
    protected $description = "Adds a new theme to the database.";
    
	protected $usage     = "themes:add [name] [path] [description]";
	protected $arguments = [
		'name'        => "The name of the theme (e.g. 'Dark Night')",
		'path'        => "The path of the theme relative to public/ (e.g. 'themes/dark')",
		'description' => "A brief description of the theme (e.g. 'A stormy theme fitting for night')",
	];

	public function run(array $params = [])
    {
		$themes = new ThemeModel();
		
		// Consume or prompt for a theme name
		$name = array_shift($params);
		if (empty($name))
			$name = CLI::prompt('Name of the theme', null, 'required');
		
		// Consume or prompt for the path
		$path = array_shift($params);
		if (empty($path))
			$path = CLI::prompt('Path to the theme (relative to public/)', null, 'required');
		
		// Verify theme path
		if (! is_dir(FCPATH . $path)):
			CLI::write('Warning! Directory not found: ' . FCPATH . $path, 'yellow');
			CLI::write('Be sure to add the directory and files before using the theme', 'yellow');
		endif;
	
		// consume or prompt for description
		$description = array_shift($params);
		if (empty($description))
			$description = CLI::prompt('Description');
		
		// build the row
		$theme = [
			'name'        => $name,
			'path'        => $path,
			'description' => $description,
		];

		try
		{
			$themes->save($theme);
		}
		catch (\Exception $e)
		{
			$this->showError($e);
		}
		
		$this->call('themes:list');
	}
}

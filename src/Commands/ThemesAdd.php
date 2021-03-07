<?php namespace Tatter\Themes\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use Tatter\Themes\Models\ThemeModel;
use RuntimeException;
use Throwable;

class ThemesAdd extends BaseCommand
{
    protected $group       = 'Themes';
    protected $name        = 'themes:add';
    protected $description = "Adds a new theme to the database.";
    
	protected $usage     = "themes:add [name] [path] [description] [dark]";
	protected $arguments = [
		'name'        => "The name of the theme (e.g. 'Dark Night')",
		'path'        => "The path of the theme relative to public/ (e.g. 'themes/dark')",
		'description' => "A brief description of the theme (e.g. 'A stormy theme fitting for night')",
	];

	public function run(array $params = [])
    {
		$themes = new ThemeModel();
		
		// Consume or prompt for a theme name
		if (! $name = array_shift($params))
		{
			$name = CLI::prompt('Name of the theme', null, 'required');
		}
		
		// Consume or prompt for the path
		if (! $path = array_shift($params))
		{
			$path = CLI::prompt('Path to the theme (relative to public/)', null, 'required');
		}
		
		// Verify theme path
		if (! is_dir(FCPATH . $path))
		{
			CLI::write('Warning! Directory not found: ' . FCPATH . $path, 'yellow');
			CLI::write('Be sure to add the directory and files before using the theme', 'yellow');
		}
	
		// Consume or prompt for description
		if (! $description = array_shift($params))
		{
			$description = CLI::prompt('Description');
		}

		// Consume or prompt for dark status	
		if (! $dark = array_shift($params))
		{
			$dark = CLI::prompt('Dark theme?', ['n','y']);
		}

		// Try to create the record
		$result = model(ThemeModel::class)->save([
			'name'        => $name,
			'path'        => $path,
			'description' => $description,
			'dark'        => ($dark=='y'),
		]);

		if (! $result)
		{
			$this->showError(new RuntimeException(implode(' ', model(ThemeModel::class)->error())));
			return;
		}

		$this->call('themes:list');
	}
}

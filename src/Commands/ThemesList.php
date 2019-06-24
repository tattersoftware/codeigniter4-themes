<?php namespace Tatter\Themes\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class ThemesList extends BaseCommand
{
    protected $group       = 'Themes';
    protected $name        = 'themes:list';
    protected $description = 'Lists available themes from the database.';

    public function run(array $params)
    {
		$db = db_connect();
		
		CLI::write(" AVAILABLE THEMES ", 'white', 'black');
		
		// get all themes
		$rows = $db->table('themes')->select('name, path, description, dark, created_at')
			->where('deleted_at IS NULL')
			->orderBy('name', 'asc')
			->get()->getResultArray();

		if (empty($rows)):
			CLI::write( CLI::color("No available themes.", 'yellow') );
		else:
			$thead = ['Name', 'Path', 'Description', 'Dark?', 'Created'];
			CLI::table($rows, $thead);
		endif;
	}
}

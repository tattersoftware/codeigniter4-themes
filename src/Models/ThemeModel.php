<?php namespace Tatter\Themes\Models;

use CodeIgniter\Model;
use Tatter\Themes\Entities\Theme;

class ThemeModel extends Model
{
	protected $table      = 'themes';
	protected $primaryKey = 'id';
	protected $returnType = Theme::class;

	protected $useTimestamps  = true;
	protected $useSoftDeletes = true;
	protected $skipValidation = false;

	protected $allowedFields = [
		'name',
		'path',
		'description',
		'dark'
	];

	protected $validationRules = [
		'name' => 'required|max_length[255]',
		'path' => 'required|max_length[255]',
	];
}

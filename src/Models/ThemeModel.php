<?php namespace Tatter\Themes\Models;

use CodeIgniter\Model;

class ThemeModel extends Model
{
	protected $table      = 'themes';
	protected $primaryKey = 'id';

	protected $returnType = 'object';
	protected $useSoftDeletes = true;

	protected $allowedFields = ['name', 'path', 'description'];

	protected $useTimestamps = true;

	protected $validationRules    = [
		'name'     => 'required|max_length[255]',
		'path'     => 'required|max_length[255]',
	];
	protected $validationMessages = [];
	protected $skipValidation     = false;
}

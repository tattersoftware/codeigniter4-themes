<?php

namespace Tatter\Themes\Entities;

use CodeIgniter\Entity;

class Theme extends Entity
{
	protected $dates = [
		'created_at',
		'updated_at',
		'deleted_at',
	];
	protected $casts = [
		'dark' => 'bool',
	];
}

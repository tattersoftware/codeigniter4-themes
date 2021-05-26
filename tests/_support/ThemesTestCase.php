<?php namespace Tests\Support;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use Tatter\Themes\Database\Seeds\ThemeSeeder;

class ThemesTestCase extends CIUnitTestCase
{
	use DatabaseTestTrait;

	/**
	 * @var string|array|null
	 */
	protected $namespace = null;

	/**
	 * @var string|array
	 */
	protected $seed = ThemeSeeder::class;

	/**
	 * Initializes the helper.
	 */
	public static function setUpBeforeClass(): void
	{
		parent::setUpBeforeClass();

		helper('themes');
	}
}

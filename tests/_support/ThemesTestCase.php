<?php namespace Tests\Support;

use CodeIgniter\Test\CIUnitTestCase;
use Tatter\Themes\Database\Seeds\ThemeSeeder;

class ThemesTestCase extends CIUnitTestCase
{
	use \CodeIgniter\Test\DatabaseTestTrait;

	/**
	 * The namespace(s) to help us find the migration classes.
	 * Empty is equivalent to running `spark migrate -all`.
	 * Note that running "all" runs migrations in date order,
	 * but specifying namespaces runs them in namespace order (then date)
	 *
	 * @var string|array|null
	 */
	protected $namespace = null;

	/**
	 * The seed file(s) used for all tests within this test case.
	 * Should be fully-namespaced or relative to $basePath
	 *
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

	protected function setUp(): void
	{
		parent::setUp();
	}
}

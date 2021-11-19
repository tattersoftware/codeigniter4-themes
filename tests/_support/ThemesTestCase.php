<?php

namespace Tests\Support;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use Tatter\Themes\Database\Seeds\ThemeSeeder;

/**
 * @internal
 */
abstract class ThemesTestCase extends CIUnitTestCase
{
    use DatabaseTestTrait;

    /**
     * @var array|string|null
     */
    protected $namespace;

    /**
     * @var array|string
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

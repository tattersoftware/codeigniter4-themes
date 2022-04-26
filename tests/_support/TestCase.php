<?php

namespace Tests\Support;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use Tatter\Assets\Asset;
use Tatter\Assets\Config\Assets as AssetsConfig;
use Tatter\Themes\Database\Seeds\ThemeSeeder;

/**
 * @internal
 */
abstract class TestCase extends CIUnitTestCase
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

    protected AssetsConfig $config;

    /**
     * Initializes the helpers.
     */
    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        helper(['auth', 'preferences', 'settings', 'themes']);
    }

    /**
     * Configures Assets for testing.
     *
     * @see https://github.com/tattersoftware/codeigniter4-assets/blob/386302d8128092afdb6ab8568d8f262ba067f0d3/tests/_support/AssetsTestCase.php
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->config                = config(AssetsConfig::class);
        $this->config->directory     = SUPPORTPATH;
        $this->config->useTimestamps = false; // These make testing much harder

        Asset::useConfig($this->config);
    }
}

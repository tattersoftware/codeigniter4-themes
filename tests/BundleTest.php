<?php

use Tatter\Themes\Models\ThemeModel;
use Tatter\Themes\ThemeBundle;
use Tests\Support\TestCase;

/**
 * @internal
 */
final class BundleTest extends TestCase
{
    public function testUsesDefault()
    {
        $theme  = theme();
        $bundle = ThemeBundle::createFromTheme($theme);

        $result = $bundle->getAssets();

        $this->assertCount(2, $result);
        $this->assertTrue($result[0]->isHead());
        $this->assertFalse($result[1]->isHead());
        $this->assertStringContainsString('apple.css', $result[0]);
        $this->assertStringContainsString('banana.js', $result[1]);
    }

    public function testUsesCache()
    {
        $key = 'assets-theme1';

        $this->config->useCache = true;
        $this->assertEmpty(cache()->getCacheInfo());

        // Place a fake bundle in the cache
        cache()->save($key, new ThemeBundle());

        $result = ThemeBundle::createFromTheme(theme());

        $this->assertSame('', (string) $result);
    }

    public function testSavesToCache()
    {
        $this->config->useCache = true;
        $this->assertEmpty(cache()->getCacheInfo());

        ThemeBundle::createFromTheme(theme());

        $this->assertNotEmpty(cache()->getCacheInfo());
    }

    public function testFailsNoDirectory()
    {
        $theme = fake(ThemeModel::class);

        $this->expectException('UnexpectedValueException');
        $this->expectExceptionMessage('Theme directory does not exist: ');

        ThemeBundle::createFromTheme($theme);
    }
}

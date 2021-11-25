<?php

use Tatter\Themes\Entities\Theme;
use Tatter\Themes\Models\ThemeModel;
use Tests\Support\TestCase;

/**
 * @internal
 */
final class HelperTest extends TestCase
{
    public function testReturnsTheme()
    {
        $result = theme();

        $this->assertInstanceOf(Theme::class, $result);
        $this->assertSame(1, $result->id);
    }

    public function testUsesSetting()
    {
        // Create a new Theme and set it as the current
        $theme = fake(ThemeModel::class);
        preference('theme', $theme->name);

        $result = theme();

        $this->assertSame($theme->id, $result->id);
    }

    public function testFailsNoTheme()
    {
        config('Preferences')->theme = null;

        $this->expectException('RuntimeException');
        $this->expectExceptionMessage('Unable to determine the theme.');

        theme();
    }

    public function testFailsUnknownTheme()
    {
        config('Preferences')->theme = 'happenstance';

        $this->expectException('RuntimeException');
        $this->expectExceptionMessage('Unable to locate the theme: happenstance');

        theme();
    }
}

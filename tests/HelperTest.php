<?php

use Tatter\Themes\Entities\Theme;
use Tatter\Themes\Models\ThemeModel;
use Tests\Support\ThemesTestCase;

/**
 * @internal
 */
final class HelperTest extends ThemesTestCase
{
    public function testThemeReturnsTheme()
    {
        $result = theme();

        $this->assertInstanceOf(Theme::class, $result);
        $this->assertSame(1, $result->id);
    }

    public function testThemeUsesSetting()
    {
        // Create a new Theme
        $theme = fake(ThemeModel::class);

        // Set it as the default
        service('settings')->theme = $theme->id;

        $result = theme();

        $this->assertSame($theme->id, $result->id);
    }
}

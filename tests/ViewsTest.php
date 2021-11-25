<?php

use Tatter\Themes\Entities\Theme;
use Tatter\Themes\Models\ThemeModel;
use Tests\Support\TestCase;

/**
 * @internal
 */
final class ViewsTest extends TestCase
{
    public function testSelectHasCurrentTheme()
    {
        $result = view('Tatter\Themes\Views\select');

        $this->assertStringContainsString(theme()->name, $result);
    }

    public function testSelectHasAllThemes()
    {
        // Create a new Theme
        $theme = fake(ThemeModel::class);

        $result = view('Tatter\Themes\Views\select');

        $this->assertStringContainsString(theme()->name, $result);
        $this->assertStringContainsString($theme->name, $result);
    }

    public function testSelectAppliesClass()
    {
        $expected = 'foobar';

        $result = view('Tatter\Themes\Views\select', [
            'class' => $expected,
        ]);

        $this->assertStringContainsString($expected, $result);
    }
}

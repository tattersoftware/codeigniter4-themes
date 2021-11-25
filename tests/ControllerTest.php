<?php

use CodeIgniter\Test\ControllerTestTrait;
use Tatter\Themes\Controllers\Themes;
use Tatter\Themes\Models\ThemeModel;
use Tests\Support\TestCase;

/**
 * @internal
 */
final class ControllerTest extends TestCase
{
    use ControllerTestTrait;

    protected $migrateOnce = true;
    protected $seedOnce    = true;

    protected function setUp(): void
    {
        parent::setUp();

        $this->controller(Themes::class);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $_REQUEST = [];
        $_SESSION = [];
    }

    public function testSelectEmpty()
    {
        $result = $this->execute('select');

        $result->assertRedirect();
        $result->assertSessionHas('errors', ['No theme selected.']);
        $result->assertSessionMissing('settings-theme');
    }

    public function testSelectMissing()
    {
        $_REQUEST['theme'] = 'foobar';

        $result = $this->execute('select');

        $result->assertRedirect();
        $result->assertSessionHas('errors', ['Could not find theme: foobar.']);
        $result->assertSessionMissing('settings-theme');
    }

    public function testSelectSuccess()
    {
        // Create a new random Theme
        $theme = fake(ThemeModel::class);

        $_REQUEST['theme'] = $theme->name;

        $result = $this->execute('select');

        $result->assertRedirect();
        $result->assertSessionHas('success', 'User theme changed to ' . $theme->name . '.');
        $result->assertSame($theme->name, preference('theme'));
    }
}

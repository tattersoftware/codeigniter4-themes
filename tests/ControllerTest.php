<?php

use CodeIgniter\Test\ControllerTestTrait;
use Tatter\Themes\Controllers\Themes;
use Tests\Support\ThemesTestCase;

final class ControllerTest extends ThemesTestCase
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

	public function testSelectInvalid()
	{
		$_REQUEST['theme'] = 'banana';

		$result = $this->execute('select');

		$result->assertRedirect();
		$result->assertSessionHas('errors', ['Invalid theme selected.']);
		$result->assertSessionMissing('settings-theme');
	}

	public function testSelectMissing()
	{
		$_REQUEST['theme'] = '42';

		$result = $this->execute('select');

		$result->assertRedirect();
		$result->assertSessionHas('errors', ['Could not find theme #42.']);
		$result->assertSessionMissing('settings-theme');
	}

	public function testSelectSuccess()
	{
		$_REQUEST['theme'] = '1';

		$result = $this->execute('select');

		$result->assertRedirect();
		$result->assertSessionHas('success', 'User theme changed to Default.');
		$result->assertSessionHas('settings-theme', 1);
	}
}

/*
		// Validate the input
		if (! $themeId = $this->request->getVar('theme'))
		{
			return redirect()->back()->withInput()->with('errors', ['No theme selected.']);		
		}

		if (! is_numeric($themeId))
		{
			return redirect()->back()->withInput()->with('errors', ['Invalid theme selected.']);
		}

		// Look up the theme
		if (! $theme = model(ThemeModel::class)->find($themeId))
		{
			return redirect()->back()->withInput()->with('errors', ['Could not find theme #' . $themeId]);
		}

		// Update the setting and send back
		service('settings')->theme = $theme->id;

		return redirect()->back()->with('success', 'User theme changed to ' . $theme->name);
	}
*/

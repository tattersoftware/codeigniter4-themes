<?php

use CodeIgniter\Test\ControllerTestTrait;
use Tatter\Themes\Controllers\Themes;
use Tests\Support\ThemesTestCase;

/**
 * @internal
 */
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

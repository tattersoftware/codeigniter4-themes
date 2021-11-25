<?php

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Test\FilterTestTrait;
use Tatter\Themes\Filters\ThemesFilter;
use Tatter\Themes\Models\ThemeModel;
use Tests\Support\TestCase;

/**
 * @internal
 */
final class FilterTest extends TestCase
{
    use FilterTestTrait;

    /**
     * @var string
     */
    private $body = <<<'EOD'
        <html>
        <head>
        	<title>Test</title>
        </head>
        <body>
        	<h1>Hello</h1>
        </body>
        </html>
        EOD;

    protected function setUp(): void
    {
        parent::setUp();

        $this->response->setBody($this->body);
        $this->response->setHeader('Content-Type', 'text/html');
    }

    public function testUsesPreference()
    {
        $expected = <<<'EOD'
            <html>
            <head>
            	<title>Test</title>
            <link href="http://example.com/assets/themes/default/apple.css" rel="stylesheet" type="text/css" />
            </head>
            <body>
            	<h1>Hello</h1>
            <script src="http://example.com/assets/themes/default/banana.js" type="text/javascript"></script>
            </body>
            </html>
            EOD;

        $caller = $this->getFilterCaller(ThemesFilter::class, 'after');
        $result = $caller();

        $this->assertInstanceOf(ResponseInterface::class, $result);
        $this->assertSame($expected, $result->getBody());
    }

    public function testUsesParameter()
    {
        $theme = fake(ThemeModel::class, [
            'path' => 'themes/vegetable',
        ]);

        $caller = $this->getFilterCaller(ThemesFilter::class, 'after');
        $result = $caller([$theme->name]);

        $this->assertInstanceOf(ResponseInterface::class, $result);
        $this->assertStringContainsString('celery.js', $result->getBody());
    }

    public function testAcceptsMultiple()
    {
        $theme = fake(ThemeModel::class, [
            'path' => 'themes/vegetable',
        ]);

        $caller = $this->getFilterCaller(ThemesFilter::class, 'after');
        $result = $caller(['Default', $theme->name]);

        $this->assertInstanceOf(ResponseInterface::class, $result);
        $this->assertStringContainsString('banana.js', $result->getBody());
        $this->assertStringContainsString('celery.js', $result->getBody());
    }

    public function testEmptyTags()
    {
        $theme = fake(ThemeModel::class, [
            'path' => 'themes/empty',
        ]);

        $caller = $this->getFilterCaller(ThemesFilter::class, 'after');

        $this->assertNull($caller([$theme->name]));
    }

    public function testEmptyBody()
    {
        $this->response->setBody('');
        $caller = $this->getFilterCaller(ThemesFilter::class, 'after');

        $this->assertNull($caller());
    }

    public function testRedirect()
    {
        $this->response = redirect('');
        $caller         = $this->getFilterCaller(ThemesFilter::class, 'after');

        $this->assertNull($caller());
    }

    public function testWrongContentType()
    {
        $this->response->setHeader('Content-Type', 'application/json');
        $caller = $this->getFilterCaller(ThemesFilter::class, 'after');

        $this->assertNull($caller());
    }

    public function testUnknownThrows()
    {
        $this->expectException('RuntimeException');
        $this->expectExceptionMessage('Unable to locate the theme: Bump');

        $caller = $this->getFilterCaller(ThemesFilter::class, 'after');
        $result = $caller(['Bump']);
    }
}

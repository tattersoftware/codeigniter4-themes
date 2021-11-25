<?php

namespace Tatter\Themes\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use RuntimeException;
use Tatter\Themes\Models\ThemeModel;
use Tatter\Themes\ThemeBundle;

/**
 * Assets Filter
 *
 * Injects Asset tags for the current route into
 * the response body HTML.
 */
class ThemesFilter implements FilterInterface
{
    /**
     * @codeCoverageIgnore
     *
     * @param mixed|null $arguments
     */
    public function before(RequestInterface $request, $arguments = null)
    {
    }

    /**
     * Gathers theme-specific assets and adds their tags to the response.
     *
     * @param string[]|null $arguments The theme name(s); if none given then the current preference will be used.
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null): ?ResponseInterface
    {
        // Ignore irrelevent responses
        if ($response instanceof RedirectResponse || empty($response->getBody())) {
            return null;
        }

        // Check CLI separately for coverage
        if (is_cli() && ENVIRONMENT !== 'testing') {
            return null; // @codeCoverageIgnore
        }

        // Only run on HTML content
        if (strpos($response->getHeaderLine('Content-Type'), 'html') === false) {
            return null;
        }

        // If no theme was provided then load the current
        if (empty($arguments)) {
            helper(['preferences', 'settings', 'themes']);
            $themes = [theme()];
        }
        // Otherwise look them up by name
        else {
            $themes = [];

            foreach ($arguments as $name) {
                if ($theme = model(ThemeModel::class)->where('name', $name)->first()) {
                    $themes[] = $theme;
                } else {
                    throw new RuntimeException('Unable to locate the theme: ' . $name);
                }
            }
        }

        // Build the tag blocks
        $headTags = [];
        $bodyTags = [];

        foreach ($themes as $theme) {
            $bundle = ThemeBundle::createFromTheme($theme);

            $headTags[] = $bundle->head();
            $bodyTags[] = $bundle->body();
        }

        $headTags = implode(PHP_EOL, $headTags);
        $bodyTags = implode(PHP_EOL, $bodyTags);

        // Short circuit?
        if ($headTags === '' && $bodyTags === '') {
            return null;
        }

        $body = $response->getBody();

        // Add any head content right before the closing head tag
        if ($headTags) {
            $body = str_replace('</head>', $headTags . PHP_EOL . '</head>', $body);
        }
        // Add any body content right before the closing body tag
        if ($bodyTags) {
            $body = str_replace('</body>', $bodyTags . PHP_EOL . '</body>', $body);
        }

        // Use the new body and return the updated Response
        return $response->setBody($body);
    }
}

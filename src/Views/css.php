<?php
// Initialize
helper('filesystem');
$settings = service('settings');
$themes = new \Tatter\Themes\Models\ThemeModel();

// Get the user or default theme
$themeId = $settings->theme;
$theme = $themes->find($themeId);
if (empty($theme))
	return;

// Verify theme path
$theme->path = rtrim($theme->path, '/') . '/';
$directory = FCPATH . $theme->path;
if (! is_dir($directory))
	return;

// Check theme path (and subdirectories) for CSS files
if ($items = directory_map($directory)):
	foreach ($items as $item):
		// make sure the extensions match
		if (strtolower(pathinfo($item, PATHINFO_EXTENSION)) == 'css'):
			// use last modified time for version control
			$version = filemtime($directory . $item);
			$url = base_url($theme->path . $item) . "?v=" . $version;
			echo link_tag($url) . PHP_EOL;
		endif;
	endforeach;
endif;

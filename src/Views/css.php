<?php
// Initialize
helper('themes');
$extension = 'css';
$settings = service('settings');

// Get the user or default theme
$theme = theme();
if (empty($theme))
	return;

// Verify theme path
$theme->path = rtrim($theme->path, '/') . '/';
$directory = FCPATH . $theme->path;
if (! is_dir($directory))
	return;

// Check theme path (and subdirectories) for matching files
$DirectoryIterator = new RecursiveDirectoryIterator($directory);
$IteratorIterator = new RecursiveIteratorIterator($DirectoryIterator);
$RegexIterator = new RegexIterator($IteratorIterator, '/^.+\.' . $extension . '$/i', RecursiveRegexIterator::GET_MATCH);

// Output a tag for each match
foreach ($RegexIterator as $match):
	// Use last modified time for version control
	$file = reset($match);
	$version = filemtime($file);
	
	// Get the web-relative path
	$path = str_replace(FCPATH, '', $file);
	$url = base_url($path) . "?v=" . $version;
	echo link_tag($url) . PHP_EOL;
endforeach;

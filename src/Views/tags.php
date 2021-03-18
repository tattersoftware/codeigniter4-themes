<?php

/**
 * Tags View
 *
 * Consolidated code for JS & CSS
 * views. This is a temporary view
 * and will be removed in the next
 * major version, do not rely on it.
 *
 * @internal
 */

// Load the helper
helper('themes');

// Get the user or default theme
if (! $theme = theme())
{
	throw new RuntimeException('Unable to load a theme.');
}

// Verify theme path
$directory = FCPATH . rtrim($theme->path, '/') . '/';
if (! is_dir($directory))
{
	throw new RuntimeException('Invalid theme directory: ' . $directory);
}

// Check theme path (and subdirectories) for matching files
$DirectoryIterator = new RecursiveDirectoryIterator($directory);
$IteratorIterator  = new RecursiveIteratorIterator($DirectoryIterator);
$RegexIterator     = new RegexIterator($IteratorIterator, '/^.+\.' . $extension . '$/i', RecursiveRegexIterator::GET_MATCH);

// Output a tag for each match
foreach ($RegexIterator as $match)
{
	// Use last modified time for version control
	$file    = reset($match);
	$version = filemtime($file);

	// Get the web-relative path
	$url = base_url(str_replace(FCPATH, '', $file)) . '?v=' . $version;

	echo $extension === 'js' ? script_tag($url) : link_tag($url);
	echo PHP_EOL;
}

# Tatter\Themes
Lightweight theme manager for CodeIgniter 4

[![](https://github.com/tattersoftware/codeigniter4-themes/workflows/PHPUnit/badge.svg)](https://github.com/tattersoftware/codeigniter4-themes/actions/workflows/test.yml)
[![](https://github.com/tattersoftware/codeigniter4-themes/workflows/PHPStan/badge.svg)](https://github.com/tattersoftware/codeigniter4-themes/actions/workflows/analyze.yml)
[![](https://github.com/tattersoftware/codeigniter4-themes/workflows/Deptrac/badge.svg)](https://github.com/tattersoftware/codeigniter4-themes/actions/workflows/inspect.yml)
[![Coverage Status](https://coveralls.io/repos/github/tattersoftware/codeigniter4-themes/badge.svg?branch=develop)](https://coveralls.io/github/organization/name?branch=develop)

## Quick Start

1. Install with Composer: `> composer require tatter/themes`
2. Update the database: `> php spark migrate -all`
3. Seed the database: `> php spark db:seed "Tatter\Themes\Database\Seeds\ThemeSeeder"`
5. Place theme files in **public/assets/themes/default** 
5. Add theme files to your page, e.g.: `echo view('\Tatter\Themes\Views\css)`

## Features

Provides convenient theme file organization and display for CodeIgniter 4

## Installation

Install easily via Composer to take advantage of CodeIgniter 4's autoloading capabilities
and always be up-to-date:
* `> composer require tatter/themes`

Or, install manually by downloading the source files and adding the directory to
`app/Config/Autoload.php`.

Once the files are downloaded and included in the autoload, run any library migrations
to ensure the database is setup correctly:
* `> php spark migrate -all`

You will also need to seed the database with a default theme:
* `> php spark db:seed "Tatter\Themes\Database\Seeds\ThemeSeeder"`

## Usage

The library comes with two CLI commands, `themes:list` and `themes:add` to help load themes
into the database. The `Preferences` library handles default theme settings and allows users
to select their own theme. Theme files all go into a directory relative to **public/**, as
defined by a theme's `path`. E.g.

* public/themes/default/styles.css
* public/themes/default/script.js
* public/themes/dark/header.css
* public/themes/dark/fonts.css
* public/themes/perky/Perky.CSS

Theme assets are loaded dynamically by outputting the corresponding view, typically in the
head tag for CSS and the footer for JS. E.g.:

```html
<head>
	<meta charset="utf-8">
	<title>My Site</title>
	...
	<?= view('\Tatter\Themes\Views\css) ?>
</head>
```

The library checks the current theme setting then scans all files (including subdirectories)
for assets of the corresponding type and outputs them in an appropriate tag.

## Theme Settings

The library comes with some basic support for allowing users to select a theme. Load the
helper to access the main function: `helper('themes')`. Then use one of the view files:
* **Tatter\Themes\Views\form** for a ready-to-use theme dropdown.
* **Tatter\Themes\Views\select** for a dropdown to include within your own form.

These views functions can take optional parameters for setting the class and other behavior:
* `class` An optional class to apply to the select field
* `selected` A theme option to preselect (defaults to the user's/current theme)
* `auto` Whether the form should submit automatically on change (default: true)

For example, to add a Bootstrap-styled form to your user account page:
```html
<h2>User Settings</h2>

<h3>Theme</h3>
<?= view('Tatter\Themes\Views\form', ['class' => 'custom-select', 'selected' => theme()->id]) ?>
```

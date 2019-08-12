# Tatter\Themes
Lightweight theme manager for CodeIgniter 4

## Quick Start

1. Install with Composer: `> composer require tatter/themes`
2. Update the database: `> php spark migrate -all`
3. Seed the database: `> php spark db:seed \\Tatter\\Themes\\Database\\Seeds\\ThemeSeeder`
5. Place theme files in **public/themes/default** 
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

**Pro Tip:** You can add the spark command to your composer.json to ensure your database is
always current with the latest release:
```
{
	...
    "scripts": {
        "post-update-cmd": [
            "@composer dump-autoload",
            "php spark migrate -all"
        ]
    },
	...
```

You will also need to seed the database with a default theme:
* `> php spark db:seed \\Tatter\\Themes\\Database\\Seeds\\ThemeSeeder`

## Usage

The library comes with two CLI commands, `themes:list` and `themes:add` to help load themes
into the database. The Settings library handles default theme settings, and allows users
to select their own theme. Theme files all go into a directory relative to **public/**, as
defined by a theme's `path`. E.g.

* public/themes/default/styles.css
* public/themes/default/script.js
* public/themes/dark/header.css
* public/themes/dark/fonts.css
* public/themes/perky/Perky.CSS

Theme assets are loaded dynamically by outputting the corresponding view, typically in the
head tag for CSS and the footer for JS. E.g.:

```
<head>
	<meta charset="utf-8">
	<title>My Site</title>
	...
	<?= view('\Tatter\Themes\Views\css) ?>
</head>
```

The library checks the user's theme setting then scans all files (including subdirectories)
for assets of the corresponding type and outputs them in an appropriate tag.

## UI

The library comes with some basic support for allowing users to select a theme. Load the
helper to access the functions: `helper('themes')`. Then call `themes_form()` for a
ready-to-use theme dropdown, or `themes_select()` to include the dropdown within your own
form. These functions can take optional parameters for setting the class and other
behavior (see [the helper file](src/helpers/themes_helper.php)).

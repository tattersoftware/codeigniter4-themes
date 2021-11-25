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

## Dependencies

`Themes` relies heavily on these libraries; be sure you are familiar with their own
requirements and installation process.
* [Tatter\Assets](https://github.com/tattersoftware/codeigniter4-assets) handles asset discovery and HTML tag injection
* [Tatter\Preferences](https://github.com/tattersoftware/codeigniter4-preferences) allows for user- or session-specific theme changing 
* [CodeIgniter\Settings](https://github.com/codeigniter4/settings) (a dependency of `Preferences`) loads and stores theme preferences into persistent storage

If you plan on allowing users to change their own themes then you will also need to include
an authentication library the provides `codeigniter4/authentication-implementation` (no other
configuration necessary).

> Read more about CodeIgniter Authentication in the [User Guide](https://codeigniter.com/user_guide/extending/authentication.html).

## Usage

*This library assumes you already have the asset files (CSS and JavaScript) used by your themes.*

Themes are managed via the database and configured for your application using Filters.

### Managing Themes

Theme files all go into a directory relative to the config property `$directory` from
`Tatter\Assets` (default is **public/assets/**), as defined by a theme's `path`. E.g.

* public/assets/themes/default/styles.css
* public/assets/themes/default/script.js
* public/assets/themes/dark/header.css
* public/assets/themes/dark/fonts.css
* public/assets/themes/perky/Perky.CSS

Each theme is an entry in the database `themes` table with the following properties:

* `name`: A short, unique name used for theme lookup and display, e.g. "Aquatic Journey"
* `path`: The path (relative to the `Assets` directory) to the publicly-available theme files, e.g. "themes/aquatic/"
* `description` (optional): A brief description of this theme's features, mostly useful for allowing user selection, e.g. "A blue theme with deep hues and liquid borders"
* `dark`: Whether this theme is dark (light text, dark backgrounds) or not, e.g. `true`

You may use the supplied model (`Tatter\Themes\Models\ThemeModel`) to create new themes or
return entities (`Tatter\Themes\Entities\Theme`). The library comes with the `ThemeSeeder`
which will create an initial "Default" theme for you at **public/assets/themes/default/**.
There is also a `themes:add` Spark command to guide you through loading themes from CLI.

### Selecting a Theme

The current theme is determined as follows:

1. Is there an authenticated user? Check `Preferences` for that user's theme preference
2. No authenticated user? Check the Session for a theme preference
3. Neither of above? Check `Settings` for a stored persistent theme
4. None of the above? Fall back on the config file: `config('Preferences')->theme` (default value "Default")

Likewise, you can set the current theme using the corresponding methods (in priority order):

1. `preference('theme', $themeName)` (with authenticated user)
2. `preference('theme', $themeName)` (without authenticated user)
3. `setting('Preferences.theme, $themeName)`
4. Create or edit **app/Config/Preferences.php** and add: `public $theme = 'theme_name';`

To assist with methods 1 & 2 this library comes with a tiny module to display a form and
process user input. You can add the form to an existing page with the Form View:
```php
<div class="form">
	<?= view('Tatter\Themes\Views\form') ?>
</div>
```

...or add the preconfigured `<select>` field to an existing form:

```php
<form name="user-settings" action="<?= site_url('users/settings') ?>" method="post">
	Display name:
	<input type="text" name="name">

	Page theme:
	<?= view('Tatter\Themes\Views\select') ?>

	<input type="submit" value="submit">
</form>
```

You can pass these additional parameters to the view:
* `$class`: A CSS class to apply to the `<select>` field. Default: *none*
* `$auto`: Whether the form should submit as soon as the select field is changed. Default: `true`
* `$selected`: The theme to show as currently chosen in the select field: Default: current theme

### Applying Themes

Once your files are in place and your theme is defined in the database you need to apply the
theme to your application routes using [Filters](https://codeigniter4.github.io/CodeIgniter4/incoming/filters.html).
This library activates the `ThemesFilter` for you on installation (assuming module discovery
is enabled, which is the default) under the alias `themes`. In simple cases you will want to
apply the filter to your entire site via **app/Config/Filters.php**:

```php
    /**
     * List of filter aliases that are always
     * applied before and after every request.
     *
     * @var array
     */
    public $globals = [
        'before' => [
            // 'honeypot',
            // 'csrf',
            // 'invalidchars',
        ],
        'after' => [
            'themes',
        ],
    ];
```

For more nuanced use, pass the filter to your route definitions in **app/Config/Routes.php**:
```php
$routes->add('shop/(:segment)', 'ShopController::index', ['filter' => 'themes']);
```

`ThemesFilter` will apply the current theme by default, but you may specify a theme or themes
by name to use those instead:
```php
$routes->add('heroes/(:segment)', 'HeroController::$1', ['filter' => 'themes:Heroic']);
```

## Additional Components

### CLI

The library comes with two CLI commands, `themes:list` and `themes:add` to ease working
with themes in the database.

### Helper

The Theme Helper is loaded automatically when you apply `ThemeFilter`, but should you need
to load it manually include it your controllers or boot config: `helper('themes')`.

This provides a helper function to return the current theme as a `Theme` entity:
```php
$theme = theme();
echo 'Current theme is ' . $theme->name . ': "' . $theme->description . '"';
```

# Upgrade Guide

## Version 1 to 2
***

> Note: This is a complete refactor! Please be sure to read the docs carefully before upgrading.

* Uses `Tatter\Assets` for handling its files, so the root folder for theme paths is now `config('Assets')->directory` (default: `FCPATH . 'assets/'`)
* Uses `Tatter\Preferences` for managing persistent settings which strongly recommends `codeigniter4/authentication-implementation`
* Asset injection is now handled by the `ThemesFilter`; remove any references to the tag views and read the docs to set up the filter
* Theme settings now track based on the theme name instead of its ID so pay attention to naming

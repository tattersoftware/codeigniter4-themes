# Upgrade Guide

## Version 1 to 2
***

* Now uses `Tatter\Assets` for handling its files, so the root folder for theme paths is now `config('Assets')->directory` (default: `FCPATH . 'assets/'`)
* Switches to `Tatter\Preferences` for managing persistent settings which strongly recommends `codeigniter4/authentication-implementation`

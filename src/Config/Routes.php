<?php

namespace Tatter\Themes\Config;

$routes ??= service('routes');

$routes->post('themes/select', '\Tatter\Themes\Controllers\Themes::select');

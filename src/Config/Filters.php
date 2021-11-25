<?php

namespace Tatter\Themes\Config;

use Config\Filters;
use Tatter\Themes\Filters\ThemesFilter;

/**
 * @var Filters $filters
 */
$filters->aliases['themes'] = ThemesFilter::class;

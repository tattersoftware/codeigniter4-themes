<?php

if (! function_exists('theme'))
{
	// return a theme object for the current theme
	function theme()
	{
		// get the current theme
		$themes = new \Tatter\Themes\Models\ThemeModel();
		$themeId = service('settings')->theme;
		return $themes->find($themeId);
	}
}

if (! function_exists('themes_form'))
{
	// generates a form to select a theme
	function themes_form($selectClass = ''): string
	{
		// get the current theme
		$themes = new \Tatter\Themes\Models\ThemeModel();
		$themeId = service('settings')->theme;
		
		// build the form
		$buffer  = "<form name='theme-select' action='" . site_url('themes/select') . "' method='post'>" . PHP_EOL;
		$buffer .= themes_select($selectClass, $themeId, true);
		$buffer .= "</form>" . PHP_EOL;
		
		return $buffer;
	}
}

if (! function_exists('themes_select'))
{
	// generates a select field using the current & available themes
	function themes_select($class = '', $current = null, $autoSubmit = false): string
	{
		$themes = new \Tatter\Themes\Models\ThemeModel();
		
		$buffer = "<select name='theme' class='{$class}'";
		if ($autoSubmit)
			$buffer .= " onchange='this.form.submit();'";
		$buffer .= '>' . PHP_EOL;

		foreach ($themes->findAll() as $theme):
			$selected = ($theme->id == $current) ? 'selected':'';
			$buffer .= "<option value='{$theme->id}' {$selected}>{$theme->name}</option>" . PHP_EOL;
		endforeach;
		
		$buffer .= "</select>" . PHP_EOL;
		
		return $buffer;
	}
}

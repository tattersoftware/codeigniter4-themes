<?php namespace Tatter\Themes\Controllers;

use CodeIgniter\Controller;
use Tatter\Themes\Models\ThemeModel;

class Themes extends Controller
{	
	public function select()
	{
		// Validate the input
		$themeId = $this->request->getPost('theme');
		if (! is_numeric($themeId))
			return redirect()->back()->withInput()->with('errors', ['Invalid theme selected.']);

		// Verify the theme
		$themes = new ThemeModel();
		$theme = $themes->find($themeId);
		if (empty($theme))
			return redirect()->back()->withInput()->with('errors', ["Could not find theme #{$themeId}."]);
		
		// Set the theme
		service('settings')->theme = $themeId;
		
		// Send to home		
		return redirect()->back()->with('success', "User theme changed to {$theme->name}");
	}
}

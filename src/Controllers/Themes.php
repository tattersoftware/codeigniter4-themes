<?php

namespace Tatter\Themes\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RedirectResponse;
use Tatter\Themes\Models\ThemeModel;

class Themes extends Controller
{
    /**
     * Receives request input with a variable
     * named "theme" (the target theme ID) to
     * update the user's current theme setting.
     */
    public function select(): RedirectResponse
    {
        // Validate the input
        if (! $themeId = $this->request->getVar('theme')) {
            return redirect()->back()->withInput()->with('errors', ['No theme selected.']);
        }

        if (! is_numeric($themeId)) {
            return redirect()->back()->withInput()->with('errors', ['Invalid theme selected.']);
        }

        // Look up the theme
        if (! $theme = model(ThemeModel::class)->find($themeId)) {
            return redirect()->back()->withInput()->with('errors', ['Could not find theme #' . $themeId . '.']);
        }

        // Update the setting and send back
        service('settings')->theme = $theme->id;

        return redirect()->back()->with('success', 'User theme changed to ' . $theme->name . '.');
    }
}

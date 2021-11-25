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
     * update the user's current theme preference.
     */
    public function select(): RedirectResponse
    {
        // Validate the input
        if (! $name = $this->request->getVar('theme')) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', ['No theme selected.']);
        }

        // Look up the theme
        if (! $theme = model(ThemeModel::class)->where('name', $name)->first()) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', ['Could not find theme: ' . $name . '.']);
        }

        // Update the setting and send back
        preference('theme', $theme->name);

        return redirect()
            ->back()
            ->with('success', 'User theme changed to ' . $theme->name . '.');
    }
}

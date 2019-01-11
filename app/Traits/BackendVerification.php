<?php

namespace App\Traits;

use Illuminate\Http\Request;

/**
 * Verification about back-end pages
 */
trait BackendVerification
{
    public function isBackend(Request $request)
    {
        return in_array('backend', explode('/', $request->url()));
    }
}

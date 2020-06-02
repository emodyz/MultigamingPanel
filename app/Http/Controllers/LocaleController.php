<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Request;

class LocaleController extends Controller
{
    public function update(Request $request, $locale)
    {
        auth()->user()->update([
            'locale' => $locale
        ]);
        return back();
    }
}

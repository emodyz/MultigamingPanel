<?php

namespace App\Http\Controllers;

class LocaleController extends Controller
{
    public function update($locale)
    {
        auth()->user()->update([
            'locale' => $locale
        ]);
        return back();
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class generalPage extends Controller
{
    public function landing() {
        return view('landing', [
            "pageName" => "Selamat Datang di "
        ]);
    }

    public function appIntro() {
        return view('app-intro', [
            "pageName" => "Selamat Datang di "
        ]);
    }
}

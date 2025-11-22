<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;

class WidgetController extends Controller
{
    public function show()
    {
        return view('widget');
    }
}

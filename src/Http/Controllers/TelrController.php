<?php

namespace Melogail\TelrLaravel\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class TelrController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function onSuccess(Request $request)
    {
        // Fire the save event
    }
}

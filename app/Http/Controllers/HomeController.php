<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;

class HomeController extends Controller
{
    public function index()
    {
        $data['setting'] = Setting::where('id' , 1)->first();
        return view('home' , $data);
    }
}

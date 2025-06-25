<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RolController extends Controller
{
    public function index()
{
    return view('roles.index');
}

}

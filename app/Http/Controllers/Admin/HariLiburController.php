<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HariLiburController extends Controller
{
    public function index() { return view('admin.hari-libur.index'); }
     public function create() { return view('admin.hari-libur.create'); }
    public function edit($id) { return view('admin.hari-libur.edit'); }
}

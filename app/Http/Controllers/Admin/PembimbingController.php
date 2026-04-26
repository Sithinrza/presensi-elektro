<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PembimbingController extends Controller
{
    public function index() { return view('admin.data.pembimbing.index'); }
    public function create() { return view('admin.data.pembimbing.create'); }
    public function edit($id) { return view('admin.data.pembimbing.edit'); }
}

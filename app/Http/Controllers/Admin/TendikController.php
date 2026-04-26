<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TendikController extends Controller
{
    public function index() { return view('admin.data.tendik.index'); }
    public function create() { return view('admin.data.tendik.create'); }
    public function edit($id) { return view('admin.data.tendik.edit'); }
}

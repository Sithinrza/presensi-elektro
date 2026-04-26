<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UnitKerjaController extends Controller
{
    public function index() { return view('admin.unit-kerja.index'); }
    public function create() { return view('admin.unit-kerja.create'); }
    public function edit($id) { return view('admin.unit-kerja.edit'); }
}

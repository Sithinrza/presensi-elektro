<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SiswaMagangController extends Controller
{
    public function index() { return view('admin.data.siswa.index'); }
    public function create() { return view('admin.data.siswa.create'); }
    public function edit($id) { return view('admin.data.siswa.edit'); }
}

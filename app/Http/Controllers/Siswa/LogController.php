<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function index()
    {
        return view('siswa.log.index');
    }
    public function create() { return view('siswa.log.create'); }
    public function edit($id) { return view('siswa.log.edit'); }
}

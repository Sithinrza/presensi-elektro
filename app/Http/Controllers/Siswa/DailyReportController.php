<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DailyReportController extends Controller
{
    public function index()
    {
        return view('siswa.daily-report.index');
    }
    public function create() { return view('siswa.daily-report.create'); }
    public function edit($id) { return view('siswa.daily-report.edit'); }
}

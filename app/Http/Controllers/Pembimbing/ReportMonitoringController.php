<?php

namespace App\Http\Controllers\Pembimbing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportMonitoringController extends Controller
{
    public function index()
    {
        return view('pembimbing.monitoring.index');
    }

    // Halaman detail untuk melihat isi report dan memberikan komen/accept
    public function show($id)
    {
        return view('pembimbing.monitoring.show');
    }
}

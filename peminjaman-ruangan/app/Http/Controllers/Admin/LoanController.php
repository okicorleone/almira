<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    public function index(Request $request)
    {
        $loans = [];
        $rooms = [];
        return view('admin.loans', compact('loans','rooms'));
    }

    public function approve($loanId)
    {
        return back()->with('ok','Permintaan diterima');
    }

    public function reject(Request $request, $loanId)
    {
        return back()->with('ok','Permintaan ditolak');
    }
}

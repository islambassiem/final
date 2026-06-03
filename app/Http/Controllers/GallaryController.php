<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class GallaryController extends Controller
{
    public function index()
    {
        $images = DB::table('gosi_campain')
            ->where('start_date', '<=', date('Y-m-d'))
            ->where('end_date', '>=', date('Y-m-d'))
            ->select('path')
            ->get();
        return view('gallary', [
            'images' => $images,
        ]);
    }
}

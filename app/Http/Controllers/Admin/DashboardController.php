<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
  public function index()
  {
    $numbers = DB::select(
      'select 
      _categories.category_en
        , _categories.category_ar
        , users.category_id
        , count(users.id) as user_count
    from users 
    join _categories on _categories.id = users.category_id
    where active = ?
    group by users.category_id, _categories.category_en, _categories.category_ar', [1]);
    $results[] = ['category_id', 'user_count'];
    foreach ($numbers as $key => $value) {
      $results[++$key] = [(string) $value->{'category' . session('_lang')}, (int) $value->user_count];
    }
    return view('admin.dashboard', [
      'results' => $results
    ]);
  }
}

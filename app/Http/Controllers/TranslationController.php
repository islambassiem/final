<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TranslationController extends Controller
{
  /**
   * Handle the incoming request.
   */
  public function __invoke($lang)
  {
    if(in_array($lang, ['en', 'ar', 'in', 'pk', 'ph'])){
      session()->put('lang', $lang);
      return  redirect()->back();
    }
  }
}

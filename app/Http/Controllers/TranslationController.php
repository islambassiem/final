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
    if(in_array($lang, ['en', 'ar', 'in', 'ph'])){
      $dir = 'ltr';
      $_lang = '_en';
      if($lang == 'ar'){
        $dir = 'rtl';
        $_lang = '_ar';
      }
      session()->put('_lang', $_lang);
      session()->put('lang', $lang);
      session()->put('dir',$dir);
      return  redirect()->back();
    }
  }
}

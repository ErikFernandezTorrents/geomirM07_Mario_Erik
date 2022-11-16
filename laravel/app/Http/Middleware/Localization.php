<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Session;
class Localization
{
    public function handle(Request $request, Closure $next)
   {
       if (Session::has('locale')) {
           $locale = Session::get('locale');
           Log::debug("Session 'locale' is '$locale'");
           App::setLocale($locale);
       }
 
       return $next($request);
   }

}

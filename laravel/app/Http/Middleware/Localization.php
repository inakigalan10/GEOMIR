<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\App;



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

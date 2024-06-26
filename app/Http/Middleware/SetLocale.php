<?php
// app/Http/Middleware/SetLocale.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    public function handle($request, Closure $next)
    {
        $locale = $request->route('lang', Session::get('locale', config('app.locale')));
        App::setLocale($locale);
        Session::put('locale', $locale);
        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;
use App\Models\LandingPage;
use Closure;
use Illuminate\Support\Facades\Auth;

class AuthenticateEditor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $slug = $request->route('slug');
        $landing_page = LandingPage::where('url', $slug)->first();
        $user = Auth::user();

        if (!($user->id == $landing_page->user->id)) { // Assuming the User model has an isAdmin() method
            return redirect('/'); // Or any other action you want to take
        }

        return $next($request);
    }
}

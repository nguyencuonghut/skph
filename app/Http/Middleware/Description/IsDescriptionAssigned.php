<?php

namespace App\Http\Middleware\Description;

use Closure;
use App\Models\Setting;
use App\Models\Description;

class IsDescriptionAssigned
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
        $description = Description::findOrFail($request->id);
        $settings = Setting::all();
        $isAdmin = Auth()->user()->hasRole('administrator');
        $settingscomplete = $settings[0]['description_assign_allowed'];

        if ($isAdmin) {
            return $next($request);
        }
        if ($settingscomplete == 1  && Auth()->user()->id != $description->fk_user_id_assign) {
            Session()->flash('flash_message_warning', 'Only assigned user are allowed to do this');
            return redirect()->back();
        }
        return $next($request);
    }
}

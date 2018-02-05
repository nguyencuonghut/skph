<?php

namespace App\Http\Middleware\Description;

use Closure;

class CanDescriptionCreate
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
        if (!auth()->user()->can('description-create')) {
            Session()->flash('flash_message_warning', 'Not allowed to create ticket description');
            return redirect()->route('descriptions.index');
        }
        return $next($request);
    }
}

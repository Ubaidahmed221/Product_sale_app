<?php

namespace App\Http\Middleware;

use App\Models\AffiliateClick;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CaptureReferral
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if($request->has('ref')){
                $ref = $request->query('ref');

                if(User::where('referral_code', $ref)->exists()){
                    AffiliateClick::create([
                        'referral_code' => $ref,
                        'ip_address' => request()->ip(),
                        'user_agent' => request()->userAgent(),
                    ]);

                    session(['referral_code' => $ref]);

                }
        }
        return $next($request);
    }
}

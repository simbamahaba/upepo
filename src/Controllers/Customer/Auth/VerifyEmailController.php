<?php

namespace Simbamahaba\Upepo\Controllers\Customer\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Simbamahaba\Upepo\Requests\EmailVerificationRequest;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param  \Illuminate\Foundation\Auth\EmailVerificationRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(EmailVerificationRequest $request)
    {
        if ($request->user('customer')->hasVerifiedEmail()) {
//            return redirect()->intended(RouteServiceProvider::HOME.'?verified=1');
            return redirect()->intended('customer/profile/?verified=1');
        }

        if ($request->user('customer')->markEmailAsVerified()) {
            event(new Verified($request->user('customer')));
        }

//        return redirect()->intended(RouteServiceProvider::HOME.'?verified=1');
        return redirect()->intended('customer/profile/?verified=1');
    }
}

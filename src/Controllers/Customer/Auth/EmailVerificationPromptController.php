<?php

namespace Simbamahaba\Upepo\Controllers\Customer\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;

class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function __invoke(Request $request)
    {
        return $request->user('customer')->hasVerifiedEmail()
                    ? redirect()->intended('/customer/profile?verified=yes')
                    : view('upepo::customers.auth.verify-email');
    }
}

<?php

namespace Simbamahaba\Upepo\Controllers\Customer\Auth;

use App\Http\Controllers\Controller;
use Simbamahaba\Upepo\Models\Customer;
use Simbamahaba\Upepo\Requests\CustomerProfileRequest;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('upepo::customers.auth.register');
    }


    /**
     * Handle an incoming registration request.
     *
     * @param CustomerProfileRequest $request
     * @return \Illuminate\Routing\Redirector
     */
    public function store(CustomerProfileRequest $request)
    {
        $account = $request->validated();
        $account['account_type'] = (int)$account['account_type'];
        $account['password'] = Hash::make($account['password']);
        $account['email_token'] = null;

        $customer = Customer::create($account);

        event(new Registered($customer));

        Auth::guard('customer')->login($customer);

        return redirect('/');
    }
}

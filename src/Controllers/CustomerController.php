<?php

namespace Simbamahaba\Upepo\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Simbamahaba\Upepo\Requests\CustomerProfileRequest;
use Simbamahaba\Upepo\Models\Customer;
use Simbamahaba\Upepo\Models\Order;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{

    public function __construct()
    {
        $this->middleware('web');
        $this->middleware('loggedcustomer');
        $this->middleware('customer.email.verified');
    }


    public function profile(Request $request)
    {
        return view('upepo::customers.profile',[
            'customer' => $request->user('customer'),
            ]);
    }


    public function myOrders(Request $request)
    {
        return view('upepo::customers.myorders',[
            'orders' => Order::where('customer_id', (int)$request->user('customer')->id )
                ->orderBy('created_at','desc')
                ->get(),
        ]);
    }


    /**
     * Updates customer profile
     *
     * @param CustomerProfileRequest $request
     * @param Customer $customer
     * @return \Illuminate\Routing\Redirector
     */
    public function update(CustomerProfileRequest $request, Customer $customer)
    {
        $validated = $request->validated();

        $customer->account_type = (int)$validated['account_type'];
        $customer->name = $validated['name'];
        $customer->phone = $validated['phone'];
        $customer->cnp = $validated['cnp'];
        $customer->region = $validated['region'];
        $customer->city = $validated['city'];
        $customer->address = $validated['address'];
        $customer->company = $validated['company'];
        $customer->rc = $validated['rc'];
        $customer->cif = $validated['cif'];
        $customer->bank_account = $validated['bank_account'];
        $customer->bank_name = $validated['bank_name'];
        $customer->save();

        return redirect('customer/profile')
            ->with('mesaj', __('profile.updated'));
    }


    /**
     * Displays page to logged customers for changing password
     *
     * @return \Illuminate\View\View
     */
    public function newPassword()
    {
        return view('upepo::customers.auth.passwords.update');
    }


    /**
     * Updates password for logged customers
     *
     * @param Request $request
     * @param Customer $customer
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updatePassword(Request $request, Customer $customer)
    {
        $this->validate($request,[
            'password'              => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6',
        ]);

        $customer->password = Hash::make($request->password);
        $customer->save();

        return redirect('customer/profile')->with('mesaj', __('passwords.changed'));
    }

}

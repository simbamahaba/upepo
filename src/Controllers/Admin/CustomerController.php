<?php

namespace Simbamahaba\Upepo\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Simbamahaba\Upepo\Models\Customer;
use DB;
use Illuminate\Support\Facades\Hash;
use App\Notifications\YourAccountWasCreatedManually;
use Simbamahaba\Upepo\Requests\CustomerProfileRequest;
use Simbamahaba\Upepo\Requests\CustomerProfileUpdateRequest;

class CustomerController extends Controller
{
    private $customers;

    public function __construct(Customer $customer)
    {
        $this->customers = $customer;
        $this->middleware('web');
        $this->middleware('admin.only');
    }

    public function index()
    {
        list($perPage, $customers) = $this->getCustomers();

        return view('upepo::admin.shop.customers.index',
            compact('customers', 'perPage'));
    }

    public function updateLimit(Request $request)
    {
        $this->validate($request,[
           'perPage'    => 'required|integer'
        ]);
        DB::table('sys_shop_setups')->where('action','customers_per_page')->update(['value'=>$request->perPage]);
        return redirect('admin/shop/customers');
    }

    public function create()
    {
        return view('upepo::admin.shop.customers.create');
    }


    public function store(CustomerProfileRequest $customerProfileRequest)
    {

        $validated = $customerProfileRequest->validated();

        $customer = new $this->customers();
        $customer->account_type = (int)$validated['account_type'];
        $customer->email = $validated['email'];
        $customer->password = Hash::make($validated['password']);
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

        if( $customerProfileRequest->has('verified') && $customerProfileRequest->verified == 1 ){
            $customer->markEmailAsVerified();
        }

        if( $customerProfileRequest->has('notify') && $customerProfileRequest->notify == 1 ){
            if( $customerProfileRequest->has('verified') && $customerProfileRequest->verified == 1 ) {
                $customer->notify(new YourAccountWasCreatedManually($customer, $validated['password']));
            }else{
                /*$email_token = md5(Carbon::now());
                $customer->email_token = $email_token;
                $customer->notify(new AccountCreatedManuallyNeedsConfirmation($customer, $request->password, $email_token));*/
                $customer->sendEmailVerificationNotification();
            }
        }

        $customer->save();

        return redirect('admin/shop/customers')->with('mesaj','Utilizatorul a fost adaugat cu succes!');
    }

    public function edit(Request $request, Customer $customer)
    {
        return view('upepo::admin.shop.customers.edit', ['customer' => $customer]);
    }

    public function update(CustomerProfileUpdateRequest $customerProfileUpdateRequest, Customer $customer)
    {

        $validated = $customerProfileUpdateRequest->validated();

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

        if(  $customerProfileUpdateRequest->has('verified') &&  $customerProfileUpdateRequest->verified == 1 ){
            $customer->verified = 1;
        }else{
            $customer->verified = 0;
        }
        $customer->save();

        return redirect('admin/shop/customers/'.$customer->id.'/edit')->with('mesaj','Profil actualizat cu success!');
    }

    public function destroy(Request $request, $id)
    {
        $customer = $this->customers->findOrFail((int)$id);
        $customer->delete();
        return redirect('admin/shop/customers')->with('mesaj','Utilizatorul a fost sters din baza de date.');
    }

    public function deleteMultiple(Request $request)
    {
        if( !$request->exists('deleteMultiple') || !$request->has('item') || !is_array($request->item) ){
            return redirect('admin/shop/customers');
        }

        $customersIds = '';
        foreach($request->item as $customerKey=>$on){
            $customersIds[] = (int)$customerKey;
        }

        Customer::whereIn('id',$customersIds)->delete();

        return redirect('admin/shop/customers')->with('mesaj','Utilizatorii au fost stersi cu succes !');
    }

    /**
     * @return array
     */
    private function getCustomers(): array
    {
        $perPage = DB::table('sys_shop_setups')->where('action', 'customers_per_page')->pluck('value')->first();
        $ord = ['asc', 'desc'];
        if (request()->has('name') && in_array(request('name'), $ord)) {
            $name = request('name');
            $customers = $this->customers->orderBy('email', $name)->paginate($perPage)->appends('name', request('name'));
        } elseif (request()->has('active') && in_array(request('active'), $ord)) {
            $customers = $this->customers->orderBy('verified', request('active'))->paginate($perPage)->appends('active', request('active'));
        } else {
            $customers = $this->customers->orderBy('created_at', $ord[1])->paginate($perPage);
        }
        return array($perPage, $customers);
    }
}

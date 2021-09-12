<?php

namespace Simbamahaba\Upepo\Controllers\CustomerAuth;

use Simbamahaba\Upepo\Models\Customer;
use App\Mail\CustomerLinkConfirmation;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;
    # Validation regex
    private $alphaDashSpaces = '/^[A-Za-z \-ĂÎÂŞŢăîâşţ]+$/';
    private $alphaDashSpacesNum = '/^[A-Za-z0-9\s\-ĂÎÂŞŢăîâşţ]+$/';
    private $numbers = '/^[0-9]+$/';
    private $address = "/^[A-Za-zĂÎÂŞŢăîâşţ0-9\.\-\s\,]+$/";
    private $alphaNumSlash = '/^[A-Za-z0-9\/\-\.]+$/';
    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/customer/register';

    public function showRegistrationForm()
    {
        return view('upepo::customers.auth.register');
    }

    protected function guard()
    {
        return Auth::guard('customer');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('web');
        $this->middleware('customer');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $messages = [
            'rc.regex'  => 'Numarul de inregistrare in registrul comertului are format invalid',
            'required_if'  => 'Acest camp este obligatoriu.'
        ];
        return Validator::make($data, [
            'account_type'  => 'required|in:0,1' ,
            'name'          => 'required_if:account_type,0|max:255|nullable|regex:'.$this->alphaDashSpaces,
            'email'         => 'required|email|max:255|unique:customers,email',
            'password'      => 'required|min:6|confirmed',
            'phone'         => 'required_if:account_type,0|nullable|regex:'.$this->numbers,
            'cnp'           => 'required_if:account_type,0|nullable|digits:13',
            'region'        => 'required_if:account_type,0|nullable|regex:'.$this->alphaDashSpaces,
            'city'          => 'required_if:account_type,0|nullable|regex:'.$this->alphaDashSpaces,
            'address'       => 'required|regex:'.$this->address,
            'company'       => 'required_if:account_type,1|nullable|regex:'.$this->alphaDashSpacesNum,
            'rc'            => 'required_if:account_type,1|nullable|regex:'.$this->alphaNumSlash,
            'cif'           => 'required_if:account_type,1|nullable|alpha_num',
            'bank_account'  => 'required_if:account_type,1|nullable|alpha_num',
            'bank_name'     => 'required_if:account_type,1|nullable|regex:'.$this->alphaDashSpaces,
        ], $messages);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return Customer
     */
    protected function create(array $data)
    {
        $email_token = str_random(35);
        $mail = $data['email'];
        $nume = ((int)$data['account_type'] == 0)?$data['name']:$data['company'];
        Mail::to($mail)->send(new CustomerLinkConfirmation($nume,$email_token));

        $account = [];
        switch ((int)$data['account_type']) {
            case 0 : $account = [
                            'name' => $data['name'],
                            'email' => $data['email'],
                            'password' => bcrypt($data['password']),
                            'email_token' => $email_token,
                            'account_type'  => (int)$data['account_type'],
                            'phone'         => $data['phone'],
                            'cnp'           => $data['cnp'],
                            'region'        => $data['region'],
                            'city'          => $data['city'],
                            'address'       => $data['address'],
                        ];
                break;
            case 1 : $account = [
                            'company' => $data['company'],
                            'email' => $data['email'],
                            'password' => bcrypt($data['password']),
                            'email_token' => $email_token,
                            'account_type'  => (int)$data['account_type'],
                            'rc'         => $data['rc'],
                            'cif'           => $data['cif'],
                            'bank_account'  => $data['bank_account'],
                            'bank_name'     => $data['bank_name'],
                            'address'       => $data['address'],
                        ];
                break;
            default: ;
        }
        return Customer::create($account);
    }

}

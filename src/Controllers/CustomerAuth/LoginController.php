<?php

namespace Simbamahaba\Upepo\Controllers\CustomerAuth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Simbamahaba\Upepo\Models\Customer;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/customer/profile';
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('web');
        $this->middleware('customer', ['except' => 'logout']);
    }

    public function showLoginForm($toCheckout3 = null)
    {
        if($toCheckout3 != null && (int)trim($toCheckout3) == 1 ){
            session(['toCheckout3'=>1]);
        }
        return view('upepo::customers.auth.login');
    }

    public function redirectPath()
    {
        if( session('toCheckout3') && session('toCheckout3') == 1 ){
            return 'cart/checkout3';
        }else{
            return $this->redirectTo;
        }
    }

    protected function guard()
    {
        return Auth::guard('customer');
    }
    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        $credentials = $request->only($this->username(), 'password');
        $credentials['verified'] = 1;
        return $credentials;
    }
    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        $errors = [$this->username() => Lang::get('auth.failed')];

        $customer = Customer::where( $this->username(), $request->{$this->username()} )->first();
        // Check if customer was successfully loaded, that the password matches
        // and active is not 1. If so, override the default error message.
        if ($customer && \Hash::check($request->password, $customer->password) && $customer->verified != 1) {
            $errors = [$this->username() => 'Contul nu este activ. Verificati emailul pentru a trimite linkul de confirmare.'];
        }
        return redirect()->back()
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors($errors);
    }
}

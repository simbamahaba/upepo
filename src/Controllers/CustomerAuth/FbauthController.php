<?php

namespace Simbamahaba\Upepo\Controllers\CustomerAuth;

use App\Mail\FbUserPassword;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Socialite;
use Simbamahaba\Upepo\Models\Customer;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
class FbauthController extends Controller
{
    public function __construct()
    {
        $this->middleware('web');
    }
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallback()
    {

        $user = Socialite::driver('facebook')->user();

        if( $this->nonFacebookAccountExists($user->email) === true){
            return redirect('customer/login')->withErrors([
                'fberror'=>"Adresa de email asociata contului de facebook exista deja. <br>Va rugam sa va logati folosind respectiva adresa de email si parola."
            ]);
        }

        $authUser = $this->findOrCreateUser($user, 'facebook');
        Auth::guard('customer')->login($authUser, true);
        return ( session('toCheckout3') && session('toCheckout3') == 1 )?redirect('cart/checkout3'):redirect('/customer/profile');
        // $user->token;
    }

    /**
     * If a user has registered before using social auth, return the user
     * else, create a new user object.
     * @param  $user Socialite user object
     * @param $provider Social auth provider
     * @return  Customer
     */
    public function findOrCreateUser($user, $provider='facebook')
    {
        $authUser = Customer::where('provider_id', $user->id)->first();
        if ($authUser) {
            return $authUser;
        }
        $verified = 0;
        $parola_bcrypt = null;

        if(trim($user->email) != ''){
            $verified = 1;
            $parola = Str::random(6);
            $parola_bcrypt = bcrypt($parola);
            Mail::to($user->email)->send(new FbUserPassword($user->name,$parola));
        }

        return Customer::create([
            'name'          => $user->name,
            'email'         => $user->email,
            'password'      => $parola_bcrypt,
            'provider'      => $provider,
            'provider_id'   => $user->id,
            'verified'      => $verified
        ]);
    }

    /**
     * Checks if an account with the same email address exists already in db
     * and it is not associated the Facebook account
     *
     * @param $email
     * @return bool
     */
    private function nonFacebookAccountExists($email)
    {
        $customer = Customer::where('email',$email)->whereNULL('provider_id')->first();
        if( $customer ){
            return true;
        }
        return false;
    }
}

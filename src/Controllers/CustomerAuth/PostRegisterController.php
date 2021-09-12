<?php

namespace Simbamahaba\Upepo\Controllers\CustomerAuth;

use App\Mail\FbUserPassword;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Simbamahaba\Upepo\Models\Customer;
use Illuminate\Support\Facades\Auth;
class PostRegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('web');
    }
    /**
     * Confirm a user's email address.
     *
     * @param  string $token
     * @return mixed
     */
    public function confirmEmail($token)
    {
        $customer = Customer::where('email_token',$token)->first();
        if($customer == null){
            return 'Acest email nu exista.';
        }else{
            if($customer->verified == 1){
                return 'Emailul dvs a fost deja confirmat.';
            }
            $customer->verified = 1;
            $customer->email_token = null;
            $messageLoginData = '';
            if( trim($customer->provider) == 'facebook' ){
                $parola = Str::random(6);
                $parola_bcrypt = bcrypt($parola);
                $customer->password = $parola_bcrypt;
                Mail::to($customer->email)->send(new FbUserPassword($customer->name,$parola));
                $messageLoginData = ' si v-a fost trimis un mesaj cu datele de logare';
            }

            $customer->save();
            Auth::guard('customer')->login($customer, true);

            return redirect('customer/profile')->with('mesaj',"Adresa de email a fost confirmata$messageLoginData. Va multumim!");
            //return "Adresa de email a fost confirmata$messageLoginData. Va multumim!";
        }

    }
}

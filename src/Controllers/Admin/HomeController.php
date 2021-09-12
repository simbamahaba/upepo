<?php

namespace Simbamahaba\Upepo\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Simbamahaba\Upepo\Models\Admin;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('web');
        $this->middleware('admin.only');
    }

    /**
     * Show the admin dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('upepo::admin.home');
    }

    public function account()
    {
        $user = Admin::first();
        return view('upepo::admin.account',[
            'user' => $user,
        ]);
    }

    public function updatePassword(Request $request, $id)
    {
        $id = (int)trim($id);
        $user = Admin::findOrFail($id);

        $this->validate($request,[
            'password'  => 'required|min:6',
            'passwordAgain'  => 'required|same:password',
        ],[
            'password.required' => 'Va rugam sa introduceti o parola noua.',
            'password.min' => 'Parola trebuie sa aiba minim 6 caractere.',
            'passwordAgain.required' => 'Va rugam sa retastati parola noua.',
            'passwordAgain.same' => 'Cele doua parole nu se potrivesc.',
        ]);

        $user->password = Hash::make($request->password);
        $user->save();

        $request->session()->flash('mesaj','Parola a fost schimbata.');
        return redirect('admin/home/account');
    }

    public function help()
    {
        return view('upepo::admin.help');
    }
}

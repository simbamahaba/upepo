<?php

namespace Simbamahaba\Upepo\Controllers;

use App\Http\Controllers\Controller;
use Simbamahaba\Upepo\Models\Map;
use Simbamahaba\Upepo\Models\SysSetting;
use App\Mail\ContactUs;
use Illuminate\Support\Facades\Mail;
use Simbamahaba\Upepo\Requests\ContactRequest;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact',[
            'map' => Map::first(),
        ]);
    }

    public function send(ContactRequest $request, SysSetting $sysSetting)
    {
        $validated = $request->validated();

        Mail::to( $sysSetting->property('contact_email') )
            ->send(new ContactUs(
            $validated['name'],
            $validated['email'],
            $validated['subject'],
            $validated['phone'],
            strip_tags(trim($validated['message'])),
        ));

        return redirect()
            ->route('contact')
            ->with('mesaj', __('upepo::email.sent'));
    }
}

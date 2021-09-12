<?php


namespace Simbamahaba\Upepo\Controllers\Admin;

use App\Http\Controllers\Controller;

class HelpController extends Controller
{

    public function __construct()
    {
        $this->middleware('web');
        $this->middleware('admin.only');
    }

    public function __invoke()
    {
        return view('upepo::admin.help');
    }
}

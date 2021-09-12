<?php

namespace Simbamahaba\Upepo\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Simbamahaba\Upepo\Models\SysSetting;
class SettingsController extends Controller
{
    private $settings;
    public function __construct(SysSetting $sysSetting)
    {
        $this->settings = $sysSetting;
        $this->middleware('web');
        $this->middleware('admin.only');
    }

    public function index()
    {
        return view('upepo::admin.settings.index');
    }

    public function update(Request $request)
    {
        $this->validate($request,[
           'city'   => 'required',
           'system_email'   => 'required|email',
           'contact_email'   => 'required|email',
            'phone' => 'required|numeric',
            'site_name' => 'required',
            'meta_keywords' => 'required',
            'meta_description' => 'required|max:180',
        ]);

        $this->updateSettings($request,[1,2,3]);

        return redirect('admin/settings');
    }

    public function social()
    {
        return view('upepo::admin.settings.social');
    }

    public function updateSocial(Request $request)
    {
        $fbRegex = '/^[a-z\d.\-\/]{5,}$/im';
        $twitterRegex = '/^[a-z\d_]{1,15}$/im';
        $this->validate($request,[
           'facebook_address'   => 'regex:'.$fbRegex,
            'twitter_address'   => 'regex:'.$twitterRegex,
            'google_plus'       => 'numeric',
            'og'                => 'image'
        ]);
        $this->updateSettings($request,[4]);

        if ($request->hasFile('og')) {
            //return 111;
            $picName = 'og_pic.' .  $request->file('og')->getClientOriginalExtension();
            $this->settings->where('name', 'og_pic')->update(['value' => $picName]);
            $request->file('og')->storeAs('og_image', $picName);
        }

        return redirect('admin/settings/social');
    }

    /**
     * @param Request $request
     * @param array   $category
     */
    private function updateSettings(Request $request, array $category)
    {
        $settings = $this->settings->whereIn('category', $category)->get();
        foreach ($settings as $setting) {
            if ( $request->exists($setting->name) ) {
                $name = $setting->name;
                $this->settings->where('name', $name)->update(['value' => $request->$name]);
            }
        }
    }
}

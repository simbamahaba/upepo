<?php

namespace Simbamahaba\Upepo\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Simbamahaba\Upepo\Models\Status;
class StatusController extends Controller
{
    private $statuses;
    private $alphaDashSpacesNum = '/^[A-Za-z0-9\s\-]+$/';
    private $numbers = '/^[0-9]+$/';

    public function __construct(Status $status)
    {
        $this->middleware('web');
        $this->middleware('admin.only');
        $this->statuses = $status->all();
    }

    public function index()
    {
        return view('upepo::admin.shop.statuses.index',['statuses' => $this->statuses]);
    }

    public function edit(Request $request, $id)
    {
        $status = $this->statuses->find( (int)$id );
        if( null == $status){
            return redirect('admin/shop/statuses')->with('mesaj','Acest status nu exista in baza de date.');
        }
        return view('upepo::admin.shop.statuses.edit',['status'=>$status]);
    }

    public function update(Request $request, $id)
    {
        $status = $this->statuses->find((int)$id);
        if( null == $status){
            return redirect('admin/shop/statuses')->with('mesaj','Acest status nu exista in baza de date.');
        }
        $rules = [
            'name'   => 'required|regex:'.$this->alphaDashSpacesNum,
        ];
        $this->validate($request, $rules);
        if($request->has('visible') && $request->visible == 1 ){
            $rules['visible'] = 'in:1,2';
            $status->visible = 1;
        }else{
            $status->visible = 2;
        }
        $status->name = $request->name;
        $status->save();

        return redirect('admin/shop/statuses/'.$id.'/edit')->with('mesaj','Modificare reusita !');
    }
}

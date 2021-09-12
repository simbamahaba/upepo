<?php

namespace Simbamahaba\Upepo\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Simbamahaba\Upepo\Models\Transport;
class TransportController extends Controller
{

    private $transport;
    public function __construct(Transport $transport)
    {
        $this->transport = $transport;
        $this->middleware('web');
        $this->middleware('admin.only');
    }

    public function index()
    {
        $tr = $this->transport->orderBy('ordine')->orderBy('created_at','desc')->get();
        return view('upepo::admin.shop.transport.index',['transport'=>$tr]);
    }

    public function edit($id)
    {
        $transport = $this->transport->findOrFail((int)$id);
        return view('upepo::admin.shop.transport.edit',['transport'=>$transport]);
    }

    public function update(Request $request, $id)
    {
        $transport = $this->transport->find((int)$id);
        $this->validate($request,[
            'name'  => 'required|max:150',
            'price' => 'required|numeric',
        ]);

        $transport->name = $request->name;
        $transport->price = $request->price;
        if($request->has('visible')){
            $transport->visible = 1;
        }else{
            $transport->visible = 2;
        }

        $transport->save();
        return redirect('admin/shop/transport/'.$transport->id.'/edit')->with('mesaj','Modificare realizata!');
    }

    public function create()
    {
        return view('upepo::admin.shop.transport.create');
    }

    public function store(Request $request)
    {
        $transport = new $this->transport();
        $this->validate($request,[
            'name'  => 'required|max:150',
            'price' => 'required|numeric',
        ]);
        $transport->name = $request->name;
        $transport->price = $request->price;
        if($request->has('visible')){
            $transport->visible = 1;
        }else{
            $transport->visible = 2;
        }
        $order = $this->transport->max('ordine');
        $order += 1;
        $transport->ordine = $order;
        $transport->save();
        return redirect('admin/shop/transport')->with('mesaj','O noua modalitate de transport a fost adugata!');
    }

    public function destroy($id)
    {
        $transport = $this->transport->findOrfail((int)$id);
        $transport->delete();
        return redirect('admin/shop/transport');
    }

    public function updateOrder(Request $request)
    {
        $items = $this->transport->all();
        foreach($items as $item){
            $order = 'orderId_'.$item->id;
            if ($request->has($order) && $request->$order != $item->ordine && $request->$order >= 0){
                if (ctype_digit((string)trim($request->$order)) !== true) {
                    continue;
                }
                $item->ordine = (int)$request->$order;
                $item->save();
            }
        }

        return redirect('admin/shop/transport');
    }
}

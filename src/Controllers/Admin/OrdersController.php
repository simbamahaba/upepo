<?php

namespace Simbamahaba\Upepo\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Simbamahaba\Upepo\Models\Order;
use Simbamahaba\Upepo\Models\Ordereditem;
use Simbamahaba\Upepo\Models\Proforma;
use Simbamahaba\Upepo\Models\Status;
use Simbamahaba\Upepo\Models\SysSetting;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderStatusChange;
use DB;
class OrdersController extends Controller
{
    private $orders;

    public function __construct(Order $order)
    {
        $this->middleware('web');
        $this->middleware('admin.only');
        $this->orders = $order;
    }

    public function index(Request $request)
    {
        $perPage = DB::table('sys_shop_setups')->where('action','orders_per_page')->pluck('value')->first();
        $direction = ['asc', 'desc'];
        $orders = (new $this->orders)->newQuery();
        $key = '';
        $value = '';
        if( $request->has('name') && in_array($request->name, $direction) ){
            $orders->orderBy('name',$request->name);
            $key = 'name';
            $value = $request->name;
        }
        if( $request->has('price') && in_array($request->price, $direction) ){
            $orders->selectRaw('*,(price + price_transport) as finalPrice');
            $orders->orderBy('finalPrice', $request->price);
            $key = 'price';
            $value = $request->price;
        }
        if( $request->has('date') && in_array($request->date, $direction) ){
            $orders->orderBy('created_at',$request->date);
            $key = 'date';
            $value = $request->date;
        }else{
            $orders->orderBy('created_at','desc');
        }

        if( $request->session()->has('status') ){
            $orders->where('status_id',(int)session('status'));
        }
        $statuses = Status::select('id','name')->where('visible',1)->orderby('order')->get()->toArray();
        $selectStatus[0] = 'Oricare';
        foreach($statuses as $status){
            $selectStatus[$status['id']] = $status['name'];
        }
        //dd($selectStatus);

        if( !empty($key) && !empty($value) && in_array($value, $direction)){
            return view('decoweb::admin.shop.orders.index',[
                'selectStatus'  => $selectStatus ,
                'orders'        => $orders->paginate($perPage)->appends($key, $value),
                'perPage'       => $perPage,
            ]);
        }
        return view('upepo::admin.shop.orders.index',[
            'selectStatus'  => $selectStatus,
            'orders'        => $orders->paginate($perPage),
            'perPage'       => $perPage,
        ]);
    }


    public function updateLimit(Request $request)
    {
        $this->validate($request,[
            'perPage'    => 'required|integer'
        ]);
        DB::table('sys_shop_setups')->where('action','orders_per_page')->update(['value'=>$request->perPage]);
        return redirect('admin/shop/orders');
    }

    /**
     * Show the form for editing the order.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order = $this->orders->findOrFail($id);
        if($order->read == 1){
            $order->read =2;
            $order->save();
        }
        $statuses = Status::where('visible',1)->get();
        $selectStatus = [];
        foreach($statuses as $status){
            $selectStatus[$status->id] = $status->name;
        }
        //dd($selectStatus);
        $proforma = Proforma::select('code')->where('order_id',$order->id)->first();
        return view('upepo::admin.shop.orders.edit', [
            'order'         => $order,
            'proformaCode'  =>$proforma->code,
            'selectStatus'  => $selectStatus,
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $order = $this->orders->findOrFail((int)$id);

        $statusIds = $this->statusIds();
        $this->validate($request,[
           'status' => 'required|in:'.$statusIds
        ]);

        if( trim($request->status) == $order->status ){
            return redirect('admin/shop/orders/'.$id.'/edit/');
        }
        $order->status_id = (int)trim($request->status);
        $order->save();
        Mail::to($order->email)->send( new OrderStatusChange($order->id));
        $contactMail = SysSetting::select('value')->where('name','contact_email')->first();
        Mail::to($contactMail)->send( new OrderStatusChange($order->id, true));
        return redirect('admin/shop/orders/'.$id.'/edit/')->with('mesaj','Statusul comenzii a fost schimbat');
    }

    public function updateTransportPrice(Request $request, $id)
    {
        $order = $this->orders->findOrFail((int)$id);

        $this->validate($request,[
           'price_transport'    => 'required|numeric'
        ]);

        $order->price_transport = $request->price_transport;
        $order->save();

        return redirect('admin/shop/orders/'.$id.'/edit/')->with('mesaj','Pretul transportului a fost schimbat');
    }

    /*
     * Update qty for order | Update qty for each ordered item | Recalculate Grand Total for order
     *
     */
    public function updateQuantity(Request $request, $id)
    {
        $comanda = $this->orders->findOrFail((int)$id);
        $orderedItems = $comanda->items()->get();

        foreach($orderedItems as $item){
            $quantity = 'item_'.$item->id;
            if( $request->has($quantity) && $item->quantity != $request->$quantity && $request->$quantity >= 1){
                if (ctype_digit((string)trim($request->$quantity)) !== true) {
                    continue;
                }
                // update order quantity
                $comanda->quantity = ( $comanda->quantity - $item->quantity ) + $request->$quantity;
                $comanda->price = ( $comanda->price - ($item->price * $item->quantity) ) + ($item->price * $request->$quantity);
                Ordereditem::where('id',$item->id)->update(['quantity'=>(int)$request->$quantity]);
            }
        }
        $comanda->save();
        return redirect()->back();
    }
    /**
     * Update the order.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the order.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = $this->orders->findOrFail((int)$id);
        $order->delete();
        return redirect('admin/shop/orders')->with('mesaj','Comanda a fost stearsa.');
    }

    public function destroyItem($order, $orderedItem)
    {
        $comanda = $this->orders->findOrFail((int)$order);
        $item = Ordereditem::where('id', (int)$orderedItem)->where('order_id',(int)$order)->first();
        if( ! $item ){
            return abort(404,'Acest item nu a fost identificat');
        }

        $comanda->price = (float)$comanda->price - ((float)$item->price * (int)$item->quantity);
        $comanda->quantity = (int)$comanda->quantity - (int)$item->quantity;
        $comanda->save();

        $item->delete();
        return redirect('admin/shop/orders/'.$order.'/edit/')->with('mesaj','Produsul a fost sters din comanda.');
    }
    /**
     * Gathers in a string all statuses' ids
     *
     * @return string
     */
    private function statusIds()
    {
        $statuses = Status::pluck('id')->all();
        $statusIds = implode(',', $statuses);
        return $statusIds;
    }

    public function ordersByStatus(Request $request)
    {
        //dd($request->all());
        $statusIds = $this->statusIds();
        $this->validate($request,[
            'status'    => 'required|in:0,'.$statusIds,
            'filter'    => 'in:1',
            'deleteFilter'    => 'in:1',
        ]);

        if($request->status == 0 || ($request->has('deleteFilter') && $request->deleteFilter == 1) ){
            $request->session()->forget('status');
            $message = 'Filtrul a fost sters.';
        }else{
            session(['status' => $request->status]);
            $message = 'Filtrul a fost aplicat cu succes !';
        }

        return redirect('admin/shop/orders')->with('mesaj', $message);
    }

    public function deleteMultiple(Request $request)
    {
        if( !$request->exists('deleteMultiple') || !$request->has('item') || !is_array($request->item) ){
            return redirect('admin/shop/orders');
        }

        $ordersIds = '';
        foreach($request->item as $orderKey=>$on){
            $ordersIds[] = (int)$orderKey;
        }

        Order::whereIn('id',$ordersIds)->delete();

        return redirect('admin/shop/orders')->with('mesaj','Comenzile au fost sterse cu succes !');
    }
}

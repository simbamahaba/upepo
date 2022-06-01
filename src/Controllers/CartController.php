<?php

namespace Simbamahaba\Upepo\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Simbamahaba\Upepo\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Gloudemans\Shoppingcart\Facades\Cart;
use Simbamahaba\Upepo\Models\SysSetting;
use Simbamahaba\Upepo\Models\Transport;
use Simbamahaba\Upepo\Models\Order;
use Simbamahaba\Upepo\Models\Ordereditem;
use Simbamahaba\Upepo\Models\Proforma;
use Simbamahaba\Upepo\Helpers\Contracts\ShopContract as Shop;
use Simbamahaba\Upepo\Helpers\Contracts\PicturesContract as Pictures;
use App\Mail\NewOrderConfirm;
use Illuminate\Support\Facades\Mail;
use Simbamahaba\Upepo\Requests\StoreOrderRequest;

class CartController extends Controller
{
    private $shop;
    private $category;
    private $products;
    private $settings;

    public function __construct(Shop $shop, SysSetting $sysSetting)
    {
        # If customer is logged, skip checkout2
        $this->middleware('web');
        $this->middleware('customer')->only('checkout2');
        $this->shop = $shop;
        $this->category = $shop->categoryModel();
        $this->products = $shop->productModel();
        $this->settings = $sysSetting;
    }

    public function index(Pictures $pictures)
    {
        //dd(Cart::content());
        if ( Auth::guard('customer')->check() ){
            $url = url('cart/checkout3');
        }else{
            $url = url('cart/checkout2');
            session(['ch3'=>1]);
        }
        $pics = $pictures->setModel('Product')->getPics();
        //dd($pics);
        return view('upepo::cart.index', ['url'=>$url, 'pics'=>$pics]);
    }

    public function checkout2()
    {
        if ( Cart::count() == 0 ){
            return redirect('/');
        }
        return view('upepo::cart.checkout2');
    }

    public function checkout3()
    {
        if ( Cart::count() == 0 ){
            return redirect('/');
        }
        if( Auth::guard('customer')->check() ){
            $customer = Customer::find((int)Auth::guard('customer')->user()->id);
        }else{
            $customer = new Customer();
        }
        $transportItems = Transport::where('visible',1)->orderBy('ordine')->get();
        $transport[0] = 'Alege tipul de transport';
        foreach ($transportItems as $item){
            $transport[$item->id] = $item->name.' / '.$item->price.' '.config('settings.magazin.currency');
        }
        return view('upepo::cart.checkout3', ['customer' => $customer, 'transport'=>$transport]);
    }

    public function checkout4()
    {
        return view('upepo::cart.checkout4');
    }


    /**
     * @param StoreOrderRequest $storeOrderRequest
     * @param Order $order
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function storeOrder(StoreOrderRequest $storeOrderRequest, Order $order)
    {
        if ( Cart::count() == 0 ){
            return redirect('/');
        }

        $validated = $storeOrderRequest->validated();

        $transport = Transport::find((int)$validated['transport']);

        $newOrder = new $order();

        $newOrder->account_type = $validated['account_type'];
        $newOrder->customer_id = $this->customerId();
        $newOrder->status_id = 1;
        $newOrder->price = (float)Cart::total(2, '.', '');
        $newOrder->transport_id = (int)$validated['transport'];
        $newOrder->price_transport = $transport->price;
        $newOrder->quantity = (int)Cart::count();
        $newOrder->email = $validated['email'];
        $newOrder->address = $validated['address'];
        $newOrder->delivery_address = $validated['delivery_address'] ?? 'Coincide cu adresa de facturare.';

        if( $validated['account_type'] == 0 ){
            $newOrder->name = $validated['name'];
            $newOrder->phone = $validated['phone'];
            $newOrder->region = $validated['region'];
            $newOrder->city = $validated['city'];
            $newOrder->cnp = $validated['cnp'];
        }elseif( $validated['account_type'] == 1 ){
            $newOrder->company = $validated['company'];
            $newOrder->rc = $validated['rc'];
            $newOrder->cif = $validated['cif'];
            $newOrder->bank_name = $validated['bank_name'];
            $newOrder->bank_account = $validated['bank_account'];
        }
        $newOrder->save();

        foreach(Cart::content() as $item){
            $product = new Ordereditem();
            $product->order_id = $newOrder->id;
            $product->product_id = $item->id;
            $product->name = $item->name;
            $product->price = $item->priceTax;
            $product->sku = '';
            $product->quantity = $item->qty;
            $product->size = $item->options->size ?? '';
            $product->color = '';
            $product->save();
        }

        $proforma = new Proforma();
        $proforma->order_id = $newOrder->id;
        $proforma->code = Str::random(40);;
        $proforma->save();

        Mail::to($newOrder->email)
            ->send(new NewOrderConfirm($newOrder->customerName(),url('cart/vizualizareProforma/'.$newOrder->id.'/'.$proforma->code)));

        $contact_email = $this->settings->property('contact_email');
        Mail::to($contact_email)
            ->send(new NewOrderConfirm($newOrder->customerName(),url('cart/vizualizareProforma/'.$newOrder->id.'/'.$proforma->code),true));

        Cart::destroy();
        return redirect('cart/checkout4');
    }


    public function addCart(Request $request)
    {
       /* if($request->ajax()){
            return response()->json($request->session()->all(), 200);
        }*/

        if ($request->ajax()) {

            $this->validate($request, [

                'product_id' => 'required|numeric',
                'qty' => 'required|numeric',
                'price' => 'required|numeric'
            ]);

            $product = $this->products->find($request->product_id);
            $price = $this->shop->priceWithoutVAT($product->price);

            //  id, name, quantity, price,  weight, array $options = []
            Cart::add($request->product_id, $product->name, $request->qty, $price);

            return Cart::count();

        }
    }

    public function cartDestroy()
    {
        if ( Cart::count() != 0 ){
            Cart::destroy();
        }
        return redirect('/cart')->with('mesaj','Cosul a fost golit cu succes.');
    }

    public function deleteItem($rowId)
    {
        $rows = [];
        foreach( Cart::content() as $item){
            $rows[] = $item->rowId;
        }

        if( ! in_array($rowId,$rows)){
            return response()->view('decoweb::errors.404',[
                'tell'=>'Produsul pe care doriti sa-l stergeti nu exista in cos.',
            ],404);
        }

        Cart::remove($rowId);

        return redirect('cart');
    }

    public function update(Request $request)
    {
        $rows = [];
        foreach( Cart::content() as $item){
            $rows[] = $item->rowId;
        }

        if ($request->has('item') && is_array($request->item) ){
            foreach( $request->item as $rowId=>$item ){
                if ( in_array($rowId, $rows) ){ // Needs additional check FIX MEEEEE
                    Cart::update($rowId,(int)$item);
                }
            }
        }

        return redirect('cart')->with('mesaj','Cantitatile au fost modificate!');
    }

    /**
     * @return int|null
     */
    private function customerId()
    {
        $customerId = null;
        if ( Auth::guard('customer')->check() ) {
            $customerId = (int) Auth::guard('customer')->user()->id;
        }
        return $customerId;
    }

    public function modalInfo(Request $request)
    {
        if ($request->ajax()) {
            $this->validate($request, [
                'product_id' => 'required|numeric',
            ]);
        }

        $produs = $this->products->find($request->product_id);
        return $produs;
    }
}

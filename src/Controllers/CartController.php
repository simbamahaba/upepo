<?php

namespace Simbamahaba\Upepo\Controllers;

use App\Http\Controllers\Controller;
use Simbamahaba\Upepo\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Cart;
use Simbamahaba\Upepo\Models\SysSetting;
use Simbamahaba\Upepo\Models\Transport;
use Simbamahaba\Upepo\Models\Order;
use Simbamahaba\Upepo\Models\Ordereditem;
use Simbamahaba\Upepo\Models\Proforma;
use Simbamahaba\Upepo\Helpers\Contracts\ShopContract as Shop;
use Simbamahaba\Upepo\Helpers\Contracts\PicturesContract as Pictures;
use App\Mail\NewOrderConfirm;
use Illuminate\Support\Facades\Mail;
class CartController extends Controller
{
    private $shop;
    private $category;
    private $products;
    private $settings;
    # Validation regex
    private $alphaDashSpaces = '/^[A-Za-z \-ĂÎÂŞŢăîâşţ]+$/';
    private $alphaDashSpacesNum = '/^[A-Za-z0-9\s\-ĂÎÂŞŢăîâşţ]+$/';
    private $numbers = '/^[0-9]+$/';
    private $address = "/^[A-Za-zĂÎÂŞŢăîâşţ0-9\.\-\s\,]+$/";
    private $alphaNumSlash = '/^[A-Za-z0-9\/\-\.]+$/';

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

    private function rules()
    {
        $transportIds = Transport::select('id')->where('visible',1)->get()->toArray();
        $allowedTransportIds = [];
        foreach($transportIds as $array){
            $allowedTransportIds[] = $array['id'];
        }
        $allowedTransportIds = implode(',',$allowedTransportIds);
        $rules = [
            'account_type'      => 'required|in:0,1' ,
            'transport'         => 'required|in:'.$allowedTransportIds ,
            'name'              => 'required_if:account_type,0|nullable|regex:'.$this->alphaDashSpaces,
            'phone'             => 'required_if:account_type,0|nullable|regex:'.$this->numbers,
            'email'             => 'required|email',
            'cnp'               => 'required_if:account_type,0|nullable|digits:13',
            'region'            => 'required_if:account_type,0|nullable|regex:'.$this->alphaDashSpaces,
            'city'              => 'required_if:account_type,0|nullable|regex:'.$this->alphaDashSpaces,
            'address'           => 'required|regex:'.$this->address,
            'same_address'      => 'in:1',
            'delivery_address'  => 'required_without:same_address|nullable|regex:'.$this->address,
            'company'           => 'required_if:account_type,1|nullable|regex:'.$this->alphaDashSpacesNum,
            'rc'                => 'required_if:account_type,1|nullable|regex:'.$this->alphaNumSlash,
            'cif'               => 'required_if:account_type,1|nullable|alpha_num',
            'bank_account'      => 'required_if:account_type,1|nullable|alpha_num',
            'bank_name'         => 'required_if:account_type,1|nullable|regex:'.$this->alphaDashSpaces,
        ];
        return $rules;
    }

    public function storeOrder(Request $request, Order $order)
    {
        if ( Cart::count() == 0 ){
            return redirect('/');
        }

       $this->validate($request, $this->rules());

        $transportPrice = Transport::find((int)$request->transport);
        $comanda = new $order();

        $comanda->account_type = $request->account_type;
        $comanda->customer_id = $this->customerId();
        $comanda->status_id = 1;
        $comanda->price = Cart::total();
        $comanda->transport_id = (int)$request->transport;
        $comanda->price_transport = $transportPrice->price;
        $comanda->quantity = (int)Cart::count();
        $comanda->email = $request->email;
        $comanda->address = $request->address;
        $comanda->delivery_address = $request->delivery_address;

        if( $request->account_type == 0 ){
            $comanda->name = $request->name;
            $comanda->phone = $request->phone;
            $comanda->region = $request->region;
            $comanda->city = $request->city;
            $comanda->cnp = $request->cnp;
        }elseif( $request->account_type == 1 ){
            $comanda->company = $request->company;
            $comanda->rc = $request->rc;
            $comanda->cif = $request->cif;
            $comanda->bank_name = $request->bank_name;
            $comanda->bank_account = $request->bank_account;
        }
        $comanda->save();

        foreach(Cart::content() as $item){
            $product = new Ordereditem();
            $product->order_id = $comanda->id;
            $product->product_id = $item->id;
            $product->name = $item->name;
            $product->price = $item->priceTax;
            $product->sku = '';
            $product->quantity = $item->qty;
            $product->size = $item->options->size;
            $product->color = '';
            $product->save();
        }

        $proforma = new Proforma();
        $proforma->order_id = $comanda->id;
        $proforma->code = str_random(40);
        $proforma->save();

        Mail::to($comanda->email)->send(new NewOrderConfirm($comanda->customerName(),url('cart/vizualizareProforma/'.$comanda->id.'/'.$proforma->code)));
        $contact_email = $this->settings->property('contact_email');
        Mail::to($contact_email)->send(new NewOrderConfirm($comanda->customerName(),url('cart/vizualizareProforma/'.$comanda->id.'/'.$proforma->code),true));

        Cart::destroy();
        return redirect('cart/checkout4');
    }
    public function addCart(Request $request)
    {
        /*if($request->ajax()){
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

            Cart::add($request->product_id, $product->name, $request->qty, $price, ['size' => 'xxl']);

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
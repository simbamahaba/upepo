<?php

namespace Simbamahaba\Upepo\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Simbamahaba\Upepo\Models\Invoice;
class InvoiceController extends Controller
{
    private $invoice;
    # Validation regex
    private $alphaDashSpaces = '/^[A-Za-z\s\-]+$/';
    private $alphaNumSlash = '/^[A-Za-z0-9\/\-\.]+$/';
    private $alphaDashSpacesNum = '/^[A-Za-z0-9\s\-]+$/';
    private $numbers = '/^[0-9]+$/';
    private $address = "/^[A-Za-z0-9\'\.\-\s\,]+$/";

    public function __construct(Invoice $invoice)
    {
        $this->middleware('web');
        $this->middleware('admin.only');
        $this->invoice = $invoice->first();
    }
    public function index()
    {
        return view('upepo::admin.shop.invoice.index',['invoice'=>$this->invoice]);
    }


    public function update(Request $request, $id)
    {
        $invoice = $this->invoice->find( (int)$id );
        $rules = $this->rules();
        $this->validate($request, $rules);

        $invoice->bank_account = $request->bank_account;
        $invoice->bank_name = $request->bank_name;
        $invoice->cif = $request->cif;
        $invoice->rc = $request->rc;
        $invoice->company = $request->company;
        $invoice->region = $request->region;
        $invoice->city = $request->city;
        $invoice->address = $request->address;
        $invoice->serie = $request->serie;
        $invoice->tva = $request->tva;
        $invoice->save();

        return redirect('admin/shop/invoice')->with('mesaj','Datele de facturare au fost actualizate.');
    }
    private function rules()
    {
        $rules = [
            'region'        => "required|regex:".$this->alphaDashSpaces,
            'city'          => "required|regex:".$this->alphaDashSpaces,
            'address'       => 'required|regex:'.$this->address,
            'company'       => "required|regex:".$this->alphaDashSpacesNum,
            'rc'            => 'required|regex:'.$this->alphaNumSlash,
            'cif'           => 'required|alpha_num',
            'bank_account'  => 'required|alpha_num',
            'bank_name'     => "required|regex:".$this->alphaDashSpaces,
            'serie'         => 'required|alpha_num',
            'tva'           => 'required|regex:'.$this->numbers,
        ];
        return $rules;
    }

}

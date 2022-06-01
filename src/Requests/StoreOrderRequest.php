<?php

namespace Simbamahaba\Upepo\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Simbamahaba\Upepo\Models\Transport;

class StoreOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'account_type'      => 'required|in:0,1' ,
            'transport'         => 'required|in:'.$this->availableTransportIds() ,
            'name'              => 'required_if:account_type,0|nullable|regex:'.config('regex.alpha_dash_space'),
            'phone'             => 'required_if:account_type,0|nullable|regex:'.config('regex.num'),
            'email'             => 'required|email',
            'cnp'               => 'required_if:account_type,0|nullable|digits:13',
            'region'            => 'required_if:account_type,0|nullable|regex:'.config('regex.alpha_dash_space'),
            'city'              => 'required_if:account_type,0|nullable|regex:'.config('regex.alpha_dash_space'),
            'address'           => 'required|regex:'.config('regex.address'),
            'same_address'      => 'in:1',
            'delivery_address'  => 'required_without:same_address|nullable|regex:'.config('regex.address'),
            'company'           => 'required_if:account_type,1|nullable|regex:'.config('regex.alpha_dash_space_num'),
            'rc'                => 'required_if:account_type,1|nullable|regex:'.config('regex.alphaNumSlash'),
            'cif'               => 'required_if:account_type,1|nullable|alpha_num',
            'bank_account'      => 'required_if:account_type,1|nullable|alpha_num',
            'bank_name'         => 'required_if:account_type,1|nullable|regex:'.config('regex.alpha_dash_space'),
        ];
    }

    private function availableTransportIds()
    {
        $transportIds = Transport::select('id')->where('visible',1)->get()->toArray();
        $availableTransportIds = [];
        foreach($transportIds as $array){
            $availableTransportIds[] = $array['id'];
        }
        return implode(',',$availableTransportIds);
    }
}

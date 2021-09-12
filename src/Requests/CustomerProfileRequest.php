<?php

namespace Simbamahaba\Upepo\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
class CustomerProfileRequest extends FormRequest
{

    # Validation regex
    private $alphaDashSpaces = '/^[A-Za-z \-ĂÎÂŞŢăîâşţ]+$/';
    private $alphaDashSpacesNum = '/^[A-Za-z0-9\s\-ĂÎÂŞŢăîâşţ]+$/';
    private $numbers = '/^[0-9]+$/';
    private $address = "/^[A-Za-zĂÎÂŞŢăîâşţ0-9\.\-\s\,]+$/";
    private $alphaNumSlash = '/^[A-Za-z0-9\/\-\.]+$/';
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
        $rules = [
            'account_type'  => 'required|in:0,1',
            'name'          => 'required_if:account_type,0|max:255|nullable|regex:'.$this->alphaDashSpaces,
            'email'         => 'required|email|max:255|unique:customers,email',
            'password'      => 'required|min:6|confirmed',
            'phone'         => 'required_if:account_type,0|nullable|regex:'.$this->numbers,
            'cnp'           => 'required_if:account_type,0|nullable|digits:13',
            'region'        => 'required_if:account_type,0|nullable|regex:'.$this->alphaDashSpaces,
            'city'          => 'required_if:account_type,0|nullable|regex:'.$this->alphaDashSpaces,
            'address'       => 'required|regex:'.$this->address,
            'company'       => 'required_if:account_type,1|nullable|regex:'.$this->alphaDashSpacesNum,
            'rc'            => 'required_if:account_type,1|nullable|regex:'.$this->alphaNumSlash,
            'cif'           => 'required_if:account_type,1|nullable|alpha_num',
            'bank_account'  => 'required_if:account_type,1|nullable|alpha_num',
            'bank_name'     => 'required_if:account_type,1|nullable|regex:'.$this->alphaDashSpaces,
        ];

        if( Auth::guard('customer')->check() ){
            unset( $rules['password'] );
            unset( $rules['email'] );
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'rc.regex'  => 'Numărul de înregistrare în registrul comerțului are format invalid.',
            'required_if'  => 'Acest camp este obligatoriu.'
        ];
    }
}

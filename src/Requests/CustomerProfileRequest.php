<?php

namespace Simbamahaba\Upepo\Requests;

use Illuminate\Foundation\Http\FormRequest;
class CustomerProfileRequest extends FormRequest
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
        $rules = [
            'account_type'  => 'required|in:0,1',
            'name'          => 'required_if:account_type,0|max:255|nullable|regex:'.config('regex.alpha_dash_space'),
            'email'         => 'required|email|max:255|unique:customers,email',
            'password'      => 'required|min:6|confirmed',
            'phone'         => 'required_if:account_type,0|nullable|regex:'.config('regex.num'),
            'cnp'           => 'required_if:account_type,0|nullable|digits:13',
            'region'        => 'required_if:account_type,0|nullable|regex:'.config('regex.alpha_dash_space'),
            'city'          => 'required_if:account_type,0|nullable|regex:'.config('regex.alpha_dash_space'),
            'address'       => 'required|regex:'.config('regex.address'),
            'company'       => 'required_if:account_type,1|nullable|regex:'.config('regex.alpha_dash_space_num'),
            'rc'            => 'required_if:account_type,1|nullable|regex:'.config('regex.alphaNumSlash'),
            'cif'           => 'required_if:account_type,1|nullable|alpha_num',
            'bank_account'  => 'required_if:account_type,1|nullable|alpha_num',
            'bank_name'     => 'required_if:account_type,1|nullable|regex:'.config('regex.alpha_dash_space'),
        ];


        if( request()->has('verified')){
            $rules['verified']  = 'in:0,1';
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

<?php

namespace Simbamahaba\Upepo\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
            'name'      => 'required|regex:' . config('regex.alpha_dash_space'),
            'email'     => 'required|email',
            'subject'   => 'nullable|regex:'. config('regex.alpha_dash_space_num'),
            'phone'     => 'required|regex:' . config('regex.num'),
            'message'   => 'required|min:15|regex:' . config('regex.body_message'),
            'privacy'   => 'accepted',
        ];
    }

    public function messages()
    {
        return [
            'name.required'     => __('upepo::validation.custom.name.required'),
            'name.regex'        => __('upepo::validation.custom.name.regex'),
            'email.required'    => __('upepo::validation.required'),
            'email.email'       => __('upepo::validation.email'),
            'phone.required'    => __('upepo::validation.custom.phone.required'),
            'phone.regex'       => __('upepo::validation.custom.phone.regex'),
            'message.required'  => __('upepo::validation.required'),
            'message.min'       => __('upepo::validation.min.string'),
            'message.regex'     => __('upepo::validation.custom.message.regex'),
            'privacy.accepted'  => __('upepo::validation.accepted'),
        ];
    }
}

<?php

namespace Simbamahaba\Upepo\Requests;


class CustomerProfileUpdateRequest extends CustomerProfileRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = parent::rules();

        unset( $rules['password'] );
        unset( $rules['email'] );

        return $rules;
    }

}

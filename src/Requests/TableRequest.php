<?php

namespace Simbamahaba\Upepo\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TableRequest extends FormRequest
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
            'tableName'             => 'required|alpha',
            'pageName'              => 'required',
            'model'                 => 'required|alpha',
            'displayedName'         => 'required|alpha',
            'displayedFriendlyName' => 'required',
            'filesExt'              => 'nullable',
            'limitPerPage'          => 'required|integer',
            'functionAdd'           => 'nullable|integer',
            'functionEdit'          => 'nullable|integer',
            'functionDelete'        => 'nullable|integer',
            'functionSetOrder'      => 'nullable|integer',
            'functionImages'        => 'nullable|integer',
            'imagesMax'             => 'nullable|integer',
            'functionFile'          => 'nullable|integer',
            'filesMax'              => 'nullable|integer',
            'functionVisible'       => 'nullable|integer',
            'functionCreateTable'   => 'nullable|integer',
            'functionRecursive'     => 'nullable|integer',
            'recursiveMax'          => 'nullable|integer',
            'add'                   => 'required|',
            'edit'                  => 'required|',
            'no_images'             => 'required|',
            'no_files'              => 'required|',
            'added'                 => 'required|',
            'deleted'               => 'required|',
            'elements.*.friendlyName'   => 'required',
            'elements.*.databaseName'   => 'required|alpha_dash',
            'elements.*.type'           => 'required|alpha',
            'elements.*.required'       => 'nullable',
            'elements.*.colType'        => 'required',
            'elements.*.readOnly'       => 'nullable|integer',

            'elements.*.selectMultiple'       => '',
            'elements.*.selectFirstEntry'       => '',
            'elements.*.selectExtra'       => '',
            'elements.*.selectTable'       => '',

        ];
    }
}

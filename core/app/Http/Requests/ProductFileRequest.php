<?php

namespace Inventory\Http\Requests;

use Inventory\Http\Requests\Request;

class ProductFileRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->guard('admin')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'file_product'    => 'max:1000',
        ];

		return $rules;
    }
}

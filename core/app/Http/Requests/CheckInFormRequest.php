<?php

namespace Inventory\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckInFormRequest extends FormRequest
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
        return [
          'type_contact'    => 'required',
          // 'tracking_number' => 'required',
          // 'number_types_in'   => 'required',
          // 'batch_number'   => 'required',

        ];
    }
}

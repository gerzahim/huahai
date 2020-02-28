<?php

namespace Inventory\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CourierRequest extends FormRequest
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
      $rules['name'] = 'required|unique:couriers,name';
      if($id = $this->courier)
      {
          $rules['name'] .= ','.$id.',uuid';
      }
      return $rules;
    }
}

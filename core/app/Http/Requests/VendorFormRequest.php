<?php namespace Inventory\Http\Requests;
class VendorFormRequest extends Request {
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
        $rules =
            [   'vendor_no' => 'required|unique:vendors,vendor_no',
                'name'    => 'required|unique:vendors,name',
                'email'    => 'email|unique:vendors,email',
            ];

        if($id = $this->vendor)
        {
            $rules['vendor_no'] .= ','.$id.',uuid';
            $rules['name'] .= ','.$id.',uuid';
            $rules['email'] .= ','.$id.',uuid';
        }else{
            //$rules['password'] .= '|required';
        }
        return $rules;
	}

}

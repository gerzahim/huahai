<?php

namespace Inventory\Http\Controllers;
use Illuminate\Http\Request;
use Inventory\Mobiledetail;

class MobileController extends Controller
{
    public function create()
    {
        return view('test.addmobile');
    }
    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'mobilecompany' => 'required',
            'model' => 'required',
            'price' => 'required',
        ]);
        if ($validator->fails())
        {
            flashy()->error('Please Insert Value');
            return back() ;
        }
        $mobile=new Mobiledetail();
        $mobile->mobilecompany=$request->get('mobilecompany');
        $mobile->model=$request->get('model');
        $mobile->price=$request->get('price');
        $mobile->save();
        flashy()->success('Mobile has been succesfully added');
        return back();
   }
}
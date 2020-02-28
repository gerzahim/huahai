<?php

namespace Inventory\Http\Controllers;
use Illuminate\Http\Request;
use Inventory\Http\Requests;
use Laracasts\Flash\Flash;
use Yajra\Datatables\Facades\Datatables;
use Inventory\Models\Product;
use Session;
use Auth;
use Validator;
use DB;
//use Storage;
use Illuminate\Support\Facades\Storage;

class AjaxController extends Controller
{
    //



   public function getAddCheckIn(Request $request){

   		$input = $request->all();
   		$products = Product::where('code', '=', $request->id)->first();

        if ($products) {
        	$sku=$products->code;
          $name=$products->name;
          $uuid=$products->uuid;
      		return response()->json(['sku' => $sku, 'name' => $name, 'uuid' => $uuid], 200);
        }
        else{
			$msg = "This is a Error message.";
     		 return response()->json(array('msg'=> $msg), 200);
        }
/*
  */
        //$product = $this->product->getById($id);
   	/*

        $product = Product::find($id);
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->add($product, $product->id);

        Session::put('cart', $cart);

        */
   }
}

<?php namespace Inventory\Http\Controllers;
use Inventory\Http\Requests\ProductFormRequest;
use Inventory\Http\Requests\ProductFileRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Request;
use Inventory\Invoicer\Repositories\Contracts\ProductInterface as Product;
use Inventory\Invoicer\Repositories\Contracts\ProductCategoryInterface as Category;
use Illuminate\Support\Facades\Response;
use Intervention\Image\Facades\Image;
use Laracasts\Flash\Flash;
use Yajra\Datatables\Facades\Datatables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Session;
use DB;
use Inventory\Models\TransactionItemsSerialNumbers;
use Inventory\Models\ProductFile;

class ProductsController extends Controller {
    private $product,$category;
    public function __construct(Product $product,Category $category){
        $this->product = $product;
        $this->category = $category;
    }
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        
        $model = $this->product->model();
        $payments = $model::with('category')->select('uuid','name','category_id','code', 'model', 'brand', 'image','price','quantity', 'quantity_rma')->ordered();

        if (Request::ajax()){
            
            return Datatables::of($payments)
                ->editColumn('category', function($data){ return $data->category ? $data->category->name : ''; })
                ->editColumn('amount', function($data){ return format_amount($data->amount); })
                ->editColumn('image',
                    '@if($image != \'\')
                        <a href="#" data-toggle="popover" data-trigger="hover" title="{{ $name }}" data-html="true" data-content="{{HTML::image(asset(\'assets/img/uploads/product_images/\'.$image), \'image\') }}">{!! HTML::image(asset(\'assets/img/uploads/product_images/\'.$image), \'image\', array(\'style\'=>\'width:50px\')) !!}</a>
                    @else
                        {!! HTML::image(asset(\'assets/img/uploads/product_images/no-product-image.png\'), \'image\', array(\'style\'=>\'width:50px\')) !!}
                    @endif')
                ->addColumn('action', '
                      @if(hasPermission(\'edit_product\')){!! edit_btn(\'products.edit\', $uuid) !!}@endif
                      @if(hasPermission(\'delete_product\')){!! delete_btn(\'products.destroy\', $uuid) !!}@endif
                      {!! addFiles_btn(\'products.add_files\', $uuid) !!}
                ')->make(true);
        }else {
            return view('products.index');
        }
	}
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{

        if(!hasPermission('add_product', true)) return redirect('products');

        $categories = $this->category->categorySelect();
        //dd($categories);

        // Get info for Banner Section
        //$categories = Categories::all();

		return view('products.create3',compact('categories'));
	}
    /**
     * Store a newly created resource in storage.
     * @param ProductFormRequest $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function store(ProductFormRequest $request)
	{


        //$input = $request->all();

        $data = array(
                    'code'      => Request::get('code'),
                    'name'      => Request::get('name'),
                    'model'      => Request::get('model'),
                    'brand'      => Request::get('brand'),
                    'dimension'      => Request::get('dimension'),
                    'weight'      => Request::get('weight'),
                    'category_id'  => Request::get('category_id'),
                    'description'=> Request::get('description'),
        );


        $data['code'] = strtoupper($data['code']);

        $rules = array(
            'imagepath' => 'image| mimes:jpeg,jpg,png,gif | max:1000',
        );

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }

        if ($request->hasFile('imagepath')){
            $file = $request->file('imagepath');
            $filename = strtolower(str_random(50) . '.' . $file->getClientOriginalExtension());
            $file->move('assets/img/uploads/product_images', $filename);
            $canvas = Image::canvas(245, 245);
            $image = Image::make(sprintf('assets/img/uploads/product_images/%s', $filename))->resize(245, 245,
                function($constraint) {
                    $constraint->aspectRatio();
                });
            $canvas->insert($image, 'center');
            $canvas->save(sprintf('assets/img/uploads/product_images/%s', $filename));
            $data['image']= $filename;
        }



        if($this->product->create($data)){
            //dd(DB::getQueryLog());
            Flash::success(trans('application.record_created'));
            return view('products.index');

        }return redirect()->back()->withInput($request->all())->withErrors();

/*
try {
        $product = $this->product->create($data);
    } catch (ModelNotFoundException $exception) {
        return back()->withError($exception->getMessage())->withInput();
    }
    return redirect('products.create');

        try{
                $product = $this->product->create($data);
                dd($product);
            }
            catch (Illuminate\Database\QueryException $e){
                $error_code = $e->errorInfo[1];
                     $verga = 'houston, we have a duplicate entry problem';
                    dd($verga);

                if($error_code == 1062){
                    //self::delete($lid);
                    //return 'houston, we have a duplicate entry problem';
                    $verga2 = 'houston, we have a duplicate entry problem222';
                    dd($verga2);
                }
            }
        //return view('products.index');


        code
        name
        model
        price
        category_id
        description
        qty
        product_image

        /

        type clients
         clients
         vendors

        Currier ( ups, DHL, etc.. )
        Tracking number
        Type In  Reason( RMA, Purchase)
        Code_TypeIn  ( RMA AUTOGENERATE, empty)
        Bill of Number BOL
        batch // Batch Number
        Note
        Date In



*/        /*
        $data['code'] = strtoupper($data['code']);

        if ($request->hasFile('imagepath')){
            $file = $request->file('imagepath');
            $filename = strtolower(str_random(50) . '.' . $file->getClientOriginalExtension());
            $file->move('assets/img/uploads/product_images', $filename);
            $canvas = Image::canvas(245, 245);
            $image = Image::make(sprintf('assets/img/uploads/product_images/%s', $filename))->resize(245, 245,
                function($constraint) {
                    $constraint->aspectRatio();
                });
            $canvas->insert($image, 'center');
            $canvas->save(sprintf('assets/img/uploads/product_images/%s', $filename));
            $data['image']= $filename;
        }



        try{
                $user = $this->product->create($data);
                dd($user);
                exit();
            }
            catch (Illuminate\Database\QueryException $e){
                $error_code = $e->errorInfo[1];
                if($error_code == 1062){
                    //self::delete($lid);
                    //return 'houston, we have a duplicate entry problem';
                    $verga = 'houston, we have a duplicate entry problem';
                    dd($verga);
                }
            }

        //dd($this->product->create($data)->getQueryLog());


        if($this->product->create($data)){
            dd(DB::getQueryLog());
            //Flash::success(trans('application.record_created'));
            //return view('products.index');
        }*/

        //dd($data);
        //exit();
        //Session::flash('message', trans('application.record_creation_failed'));


        //Session::flash('message', 'Product creation Failed!');
        //Session::flash('alert-danger', 'Product creation Failed!');
        //return redirect('products.create');

	}


	/**
	 * Show the form for editing the specified resource.
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        if(!hasPermission('edit_product', true)) return redirect('products');
        $product = $this->product->getById($id);
        $categories = $this->category->categorySelect();
		return view('products.edit', compact('product','categories'));
	}
    /**
     * Update the specified resource in storage.
     * @param ProductFormRequest $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function update(ProductFormRequest $request, $id)
	{
        $product = $this->product->getById($id);

        $data = array(
                    'code'      => Request::get('code'),
                    'name'      => Request::get('name'),
                    'model'      => Request::get('model'),
                    'brand'      => Request::get('brand'),
                    'dimension'  => Request::get('dimension'),
                    'weight'      => Request::get('weight'),
                    'category_id'  => Request::get('category_id'),
                    'description'=> Request::get('description'),
        );


        $data['code'] = strtoupper($data['code']);

        $rules = array(
            'imagepath' => 'image| mimes:jpeg,jpg,png,gif | max:1000',
        );

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }

        if ($request->hasFile('product_image')){
            $file = $request->file('product_image');
            $filename = strtolower(str_random(50) . '.' . $file->getClientOriginalExtension());
            $file->move('assets/img/uploads/product_images', $filename);
            $canvas = Image::canvas(245, 245);
            $image = Image::make(sprintf('assets/img/uploads/product_images/%s', $filename))->resize(245, 245,
                function($constraint) {
                    $constraint->aspectRatio();
                });
            $canvas->insert($image, 'center');
            $canvas->save(sprintf('assets/img/uploads/product_images/%s', $filename));
            File::delete('assets/img/uploads/product_images/'.$product->image);
            $data['image']= $filename;
        }
		if($this->product->updateById($id,$data)){
            Flash::success(trans('application.record_updated'));
            return Response::json(array('success'=>true, 'msg' => trans('application.record_updated')), 201);
        }
        return Response::json(array('success'=>false, 'msg' =>  trans('application.record_update_failed')), 422);
	}
	/**
	 * Remove the specified resource from storage.
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        if(!hasPermission('delete_product', true)) return redirect('products');
		if($this->product->deleteById($id))
            Flash::success(trans('application.record_deleted'));
        else
            Flash::error(trans('application.record_deletion_failed'));

        return redirect('products');
	}
    /**
     * @return \Illuminate\View\View
     */
    public function products_modal(){
        $products = $this->product->all();
        return view('products.products_modal', compact('products'));
    }
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function process_products_selections(){
        $selected = \Request::get('products_lookup_ids');
        $products = $this->product->whereIn('uuid', $selected)->get();
        return Response::json(array('success'=>true, 'products' => $products), 200);
    }

    /**
     * @return \Illuminate\View\View
     */
    public function add_serial_number_modal(){
        return view('products.add_serial_number');
    }

    /**
     * @return \Illuminate\View\View
     */
    public function show_serial_numbers(){
        $transaction_item_id = \Request::get('transaction_item_id');
        $serial_numbers = TransactionItemsSerialNumbers::where('transaction_item_id', $transaction_item_id)->get();
        return view('products.show_serial_numbers', compact('serial_numbers'));
    }

    /**
	 * Show the form for add files.
	 *
	 * @return Response
	 */
	public function add_files($id)
	{
        $productFiles = ProductFile::where('product_id', $id)->get();
        $product = $this->product->getById($id);
		return view('products.add_files', compact('product', 'productFiles'));
    }
    
    /**
	 * Save file for product
	 *
	 * @return Response
	 */
    public function save_files(ProductFileRequest $request)
    {
         $rules = array(
            'file_product' => 'max:1000',
        );

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        } 

        if ($request->hasFile('file_product')){
            $file = $request->file('file_product');
            $filename = strtolower(str_random(50) . '.' . $file->getClientOriginalExtension());
            $file->move('assets/img/uploads/product_files', $filename);    
            $data['image']= $filename;

            $product_file = New ProductFile();
            $product_file->product_id =  Request::get('product_id');
            $product_file->filename = $filename;
            $product_file->original_name = $file->getClientOriginalName();
            if ($product_file->save()){
                Flash::success(trans('application.record_created'));
                return view('products.index');
            } 

        }else{
            return redirect()->back()->withInput($request->all())->withErrors();
        }

    }

    /**
	 * Save file for product
	 *
	 * @return Response
	 */
    public function delete_file($id)
    {
        $productFile = ProductFile::find($id);
        
        if (isset($productFile)){
            if ($productFile->delete()){
                Flash::success(trans('application.record_deleted'));
                return view('products.index');
            }
        }else{
            return redirect()->back();
        }

    }
}

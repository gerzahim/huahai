<?php namespace Inventory\Http\Controllers;
use Inventory\Http\Requests\CheckInFormRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Request;
use Inventory\Invoicer\Repositories\Contracts\ProductInterface as Product;
use Inventory\Invoicer\Repositories\Contracts\ProductCategoryInterface as Category;
use Inventory\Invoicer\Repositories\Contracts\TaxSettingInterface as Tax;
use Inventory\Invoicer\Repositories\Contracts\CurrencyInterface as Currency;
use Inventory\Invoicer\Repositories\Contracts\NumberSettingInterface as Number;
use Inventory\Invoicer\Repositories\Contracts\TemplateInterface as Template;
use Inventory\Invoicer\Repositories\Contracts\EmailSettingInterface as MailSetting;
use Inventory\Invoicer\Repositories\Contracts\InvoiceInterface as Invoice;
use Inventory\Invoicer\Repositories\Contracts\InvoiceSettingInterface as InvoiceSetting;
use Inventory\Invoicer\Repositories\Contracts\InvoiceItemInterface as InvoiceItem;
use Illuminate\Support\Facades\Response;
use Intervention\Image\Facades\Image;
use Laracasts\Flash\Flash;
use Yajra\Datatables\Facades\Datatables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Inventory\Models\Client;
use Inventory\Models\Vendor;
use Inventory\Models\Courier;
use Inventory\Models\Transaction;
use Inventory\Models\TransactionItem;
use Inventory\Models\TransactionType;
use Inventory\Models\TransactionItemsSerialNumbers;
use DB;
use Session;
use Auth;
use PDF;

class TransactionController extends Controller
{
    public $items = null;

    private $product,$category, $transaction, $transaction_type, $transactionItem;
    protected $tax,$client,$currency,$setting, $number,$template,$mail_setting,$invoiceSetting,$invoiceItem,$invoice;

    public function __construct(Transaction $oldTransactions, Transaction $transaction, TransactionItem $transactionItem, Product $product,Category $category, Tax $tax, Client $client, Currency $currency, Number $number,Template $template, MailSetting $mail_setting,InvoiceSetting $invoiceSetting,InvoiceItem $invoiceItem,Invoice $invoice, TransactionType $transaction_type ){
          $this->product = $product;
          $this->category = $category;
          $this->client = $client;
          $this->currency = $currency;
          $this->tax = $tax;
          $this->number = $number;
          $this->template = $template;
          $this->mail_setting = $mail_setting;
          $this->invoiceSetting = $invoiceSetting;
          $this->invoiceItem = $invoiceItem;
          $this->invoice = $invoice;
          $this->transaction = $transaction;
          $this->transactionItem = $transactionItem;

        if($oldTransactions){
            $this->items = $oldTransactions->items;
        }
    }
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        if (Request::ajax()){ 
            $model = $this->product->model();
            $inventory = $model::with('category')->select('uuid','name','category_id','code','image','price','quantity', 'quantity_rma')->ordered();
            return Datatables::of($inventory)
                ->editColumn('category', function($data){ return $data->category ? $data->category->name : ''; })
                ->editColumn('image',
                    '@if($image != \'\')
                        <a href="#" data-toggle="popover" data-trigger="hover" title="{{ $name }}" data-html="true" data-content="{{HTML::image(asset(\'assets/img/uploads/product_images/\'.$image), \'image\') }}">{!! HTML::image(asset(\'assets/img/uploads/product_images/\'.$image), \'image\', array(\'style\'=>\'width:50px\')) !!}</a>
                    @else
                        {!! HTML::image(asset(\'assets/img/uploads/product_images/no-product-image.png\'), \'image\', array(\'style\'=>\'width:50px\')) !!}
                    @endif') 
                ->make(true);

         }else {
            return view('inventory.index');
        } 
	}


    /**
     * Show checkin products view
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function checkinProducts(){

        $products = $this->product->all();

        $clients = Client::all();
        $clients = Client::orderBy('name')->pluck('name', 'uuid');

        $vendors = Vendor::all();
        $vendors = Vendor::orderBy('name')->pluck('name', 'uuid');

        $couriers = Courier::all();
        $couriers = Courier::orderBy('name')->pluck('name', 'uuid');

        $taxes        = $this->tax->taxSelect();
        $currencies   = $this->currency->currencySelect();

        $last_transaction_number = Transaction::selectRaw("MAX(`transaction_number`) AS number")->first();
        $transaction_number = $last_transaction_number->number + 1;

        return view('inventory.checkin', compact('products', 'clients', 'vendors', 'couriers', 'taxes', 'currencies', 'transaction_number'));
    }

    /**
     * [saveCheckinProducts Save Checkin Transaction]
     * @param  CheckInFormRequest $request
     * @return [type]
     */
    public function saveCheckinProducts(CheckInFormRequest $request)
    {
        
      //  Transaction type id (IN)
      $transactionType= TransactionType::where('type','in')->first();
      $transaction_type_id = $transactionType->uuid;

      $data = array(
                  'date'                  => Request::get('date'),
                  'transactions_items'    =>'',
                  'transaction_types_id'  => $transaction_type_id,
                  'type_contact'          => Request::get('type_contact'),
                  'contacts_id'          => Request::get('contacts_client_id'),
                  'contacts_client_id'   => Request::get('contacts_client_id'),
                  'contacts_vendor_id'   => Request::get('contacts_vendor_id'),
                  'couriers_id'           => Request::get('couriers_id'),
                  'tracking_number'       => Request::get('tracking_number'),
                  'transaction_types_in'  => Request::get('transaction_types_in'),
                  'number_types_in'       => Request::get('number_types_in'),
                  'bol'                   => Request::get('bol'),
                  'batch_number'          => Request::get('batch_number'),
                  'package_list'          => Request::get('package_list'),
                  'quantity'              => 0,
                  'notes'                 => Request::get('notes'),
                  'user_id'               => auth()->guard('admin')->id(),
                );


      $validator = Validator::make($request->all(), $request->rules());

      if ($validator->fails()) {
          return Redirect::back()
              ->withErrors($validator)
              ->withInput();
      }
      //  Save Transaction
      $Transaction = new Transaction;
      $Transaction->transactions_items = '';
      $Transaction->transaction_types_id  = $transaction_type_id;
      $Transaction->date = date('Y-m-d', strtotime(Request::get('date')));
      $Transaction->type_contact = Request::get('type_contact');
      
      if ($data['type_contact'] == 0){
        $Transaction->contacts_id = $data['contacts_client_id'];
      }else{
        $Transaction->contacts_id = $data['contacts_vendor_id'];
      }
      $Transaction->couriers_id = Request::get('couriers_id');
      $Transaction->tracking_number = Request::get('tracking_number');
      $Transaction->transaction_types_in = Request::get('transaction_types_in');
      $Transaction->number_types_in = Request::get('number_types_in');
      $Transaction->bol = Request::get('bol');
      $Transaction->batch_number = Request::get('batch_number');
      $Transaction->package_list = Request::get('package_list');
      $Transaction->quantity = 0;
      $Transaction->notes = Request::get('notes');
      $Transaction->user_id = auth()->guard('admin')->id();

      if ($Transaction->save()){
          // Save Transaction $items
          $productId = Request::get('product_id');
          $quantity = Request::get('quantity');
          foreach ($productId as $key => $product_id) {
              $transactionItems = new TransactionItem;
              $transactionItems->transaction_id = $Transaction->uuid->string;
              $transactionItems->product_id = $product_id;
              $transactionItems->quantity = $quantity[$key];
              $transactionItems->save();

              //  Update quantity field in products table
              $product = $this->product->getById($product_id);
                if (isset($product)){
                    if ($Transaction->transaction_types_in == 1){ // RMA    
                        $product->quantity_rma =  $product->quantity_rma + $quantity[$key];
                        $product->save();
                    }else{
                        $product->quantity =  $product->quantity + $quantity[$key];
                        $product->save();
                    }
                  
                }
          }
          Flash::success(trans('application.record_created'));
          return redirect('transactions');

      }return redirect()->back()->withInput($request->all())->withErrors();

    }


    /**
     * [saveCheckoutProducts description]
     * @param  CheckInFormRequest $request [description]
     * @return [type]                      [description]
     */
    public function saveCheckoutProducts(CheckInFormRequest $request)
    {
      //  Transaction type id (IN)
      $transactionType= TransactionType::where('type','out')->first();
      $transaction_type_id = $transactionType->uuid;

      $data = array(
                  'transactions_items'    =>'',
                  'transaction_types_id'  => $transaction_type_id,
                  'date'                  => Request::get('date'),
                  'type_contact'          => Request::get('type_contact'),
                  'contacts_id'          => Request::get('contacts_client_id'),
                  'contacts_client_id'   => Request::get('contacts_client_id'),
                  'contacts_vendor_id'   => Request::get('contacts_vendor_id'),
                  'couriers_id'           => Request::get('couriers_id'),
                  'tracking_number'       => Request::get('tracking_number'),
                  'transaction_types_in'  => Request::get('transaction_types_in'),
                  'number_types_in'       => Request::get('number_types_in'),
                  'bol'                   => Request::get('bol'),
                  'batch_number'          => Request::get('batch_number'),
                  'package_list'          => Request::get('package_list'),
                  'quantity'              => 0,
                  'notes'                 => Request::get('notes'),
                  'user_id'               => auth()->guard('admin')->id(),
                );

      $validator = Validator::make($request->all(), $request->rules());

      if ($validator->fails()) {
          return Redirect::back()
              ->withErrors($validator)
              ->withInput();
      }


      //  Save Transaction
      $Transaction = new Transaction;
      $Transaction->transactions_items = '';
      $Transaction->transaction_types_id  = $transaction_type_id;
      $Transaction->date = date('Y-m-d', strtotime(Request::get('date')));
      $Transaction->type_contact = Request::get('type_contact');
     
      if ($data['type_contact'] == 0){
            $Transaction->contacts_id = $data['contacts_client_id'];
      }else{
            $Transaction->contacts_id = $data['contacts_vendor_id'];
        }
      $Transaction->couriers_id = Request::get('couriers_id');
      $Transaction->tracking_number = Request::get('tracking_number');
      $Transaction->transaction_types_in = Request::get('transaction_types_in');
      $Transaction->number_types_in = Request::get('number_types_in');
      $Transaction->bol = Request::get('bol');
      $Transaction->batch_number = Request::get('batch_number');
      $Transaction->package_list = Request::get('package_list');
      $Transaction->quantity = 0;
      $Transaction->notes = Request::get('notes');
      $Transaction->user_id = auth()->guard('admin')->id();

      if ($Transaction->save()){
          // Save Transaction $items
          $productId = Request::get('product_id');
          $quantity = Request::get('quantity');
          foreach ($productId as $key => $product_id) {
              $transactionItems = new TransactionItem;
              $transactionItems->transaction_id = $Transaction->uuid->string;
              $transactionItems->product_id = $product_id;
              $transactionItems->quantity = $quantity[$key];
              $transactionItems->save();

              //  Update quantity field in products table
              $product = $this->product->getById($product_id);
              if (isset($product)){
                if ($Transaction->transaction_types_in == 2){ // RMA    
                    $product->quantity_rma =  $product->quantity_rma - $quantity[$key];
                    $product->save();
                }else{
                    $product->quantity =  $product->quantity - $quantity[$key];
                    $product->save();
                }
                
              }
          }
          Flash::success(trans('application.record_created'));
          return redirect('transactions');

      }return redirect()->back()->withInput($request->all())->withErrors();

    }

    /**
     * Show checkout products view
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function checkoutProducts(){

        $products = $this->product->all();

        $clients = Client::all();
        $clients = Client::orderBy('name')->pluck('name', 'uuid');

        $vendors = Vendor::all();
        $vendors = Vendor::orderBy('name')->pluck('name', 'uuid');

        $couriers = Courier::all();
        $couriers = Courier::orderBy('name')->pluck('name', 'uuid');

        $taxes        = $this->tax->taxSelect();
        $currencies   = $this->currency->currencySelect();

        $last_transaction_number = Transaction::selectRaw("MAX(`transaction_number`) AS number")->first();
        $transaction_number = $last_transaction_number->number + 1;

        return view('inventory.checkout', compact('products', 'clients', 'vendors', 'couriers', 'taxes', 'currencies', 'transaction_number'));
    }
	
  /**
	 * Show the form for editing the specified resource.
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        
        $transaction = $this->transaction->find($id);

        $clients = Client::all();
        $clients = Client::orderBy('name')->pluck('name', 'uuid');

        $vendors = Vendor::all();
        $vendors = Vendor::orderBy('name')->pluck('name', 'uuid');

        $couriers = Courier::all();
        $couriers = Courier::orderBy('name')->pluck('name', 'uuid');

        $taxes        = $this->tax->taxSelect();
        $currencies   = $this->currency->currencySelect();

        $transaction_number = $transaction->transaction_number;

        $items = TransactionItem::where('transaction_id', $id)->get();
        if ($transaction->transactiontypes->type == "in"){
            return view('inventory.edit_checkin', compact('transaction', 'items', 'products', 'clients', 'vendors', 'couriers', 'taxes', 'currencies', 'transaction_number'));
        }else{
            return view('inventory.edit_checkout', compact('transaction', 'items', 'products', 'clients', 'vendors', 'couriers', 'taxes', 'currencies', 'transaction_number'));
        }
        
	}
    /**
     * Update the specified resource in storage.
     * @param ProductFormRequest $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function update(CheckInFormRequest $request, $id)
	{
        $data = $request->all();

        $transaction = Transaction::find($id);
        if (isset($transaction)){
            $transaction->date = date('Y-m-d', strtotime($data['date']));
            $transaction->type_contact = $data['type_contact'];
            if ($data['type_contact'] == 0){
                $transaction->contacts_id = $data['contacts_client_id'];
            }else{
                $transaction->contacts_id = $data['contacts_vendor_id'];
            }
            $transaction->couriers_id = $data['couriers_id'];
            $transaction->tracking_number = $data['tracking_number'];
            $transaction->transaction_types_in = $data['transaction_types_in'];
            $transaction->number_types_in = $data['number_types_in'];
            $transaction->bol = $data['bol'];
            $transaction->batch_number = $data['batch_number'];
            $transaction->package_list = $data['package_list'];
            $transaction->notes = $data['notes'];
            $transaction->save();
            
            
            foreach ($data['product_id'] as $index => $product_id){
                $transaction_item = TransactionItem::where('transaction_id', $id)->where('product_id', $product_id)->get();
                
                //  For Update quantity field in products table
                $product = $this->product->getById($product_id);
            
                if ($transaction_item->count()>0){
                    $item = TransactionItem::find($transaction_item[0]->uuid);
                    $item->quantity = $data['quantity'][$index];
                    $item->save();
                    if ($transaction->transactiontypes->type == "in"){
                        $product->quantity =  $product->quantity - $item->quantity;
                        $product->quantity =  $product->quantity + $data['quantity'][$index];
                        $product->save();
                    }else{
                        $product->quantity =  $product->quantity + $item->quantity;
                        $product->quantity =  $product->quantity - $data['quantity'][$index];
                        $product->save();
                    }
                    
                }else{
                    $transactionItem = new TransactionItem;
                    $transactionItem->transaction_id = $id;
                    $transactionItem->product_id = $product_id;
                    $transactionItem->quantity = $data['quantity'][$index];
                    $transactionItem->save();
                    if ($transaction->transactiontypes->type == "in"){
                        $product->quantity =  $product->quantity + $data['quantity'][$index];
                        $product->save();
                    }else{
                        $product->quantity =  $product->quantity - $data['quantity'][$index];
                        $product->save();
                    }
                }
            }

            $transaction_items = TransactionItem::where('transaction_id', $id)->get();
            
            foreach($transaction_items as $transaction_item){
                if (!in_array($transaction_item->product_id, $data['product_id'])){
                    $item = TransactionItem::find($transaction_item->uuid);
                    $item->delete();

                    //  Update quantity field in products table
                    $product = $this->product->getById($transaction_item->product_id);
                    if (isset($product)){
                        $product->quantity =  $product->quantity - $transaction_item->quantity;
                        $product->save();
                    }
                }
            }

            Flash::success(trans('application.record_updated'));
            return redirect('transactions');
        }   
	}

	/**
	 * Remove the specified resource from storage.
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
          
        $transaction = Transaction::find($id);
        if ($transaction->count()){
            $transaction_items = TransactionItem::where('transaction_id', $id)->get();
            if ($transaction_items->count()){
                $transaction_items_serial_numbers = TransactionItemsSerialNumbers::where('transaction_id', $id)->get();
                if ($transaction_items_serial_numbers->count()){
                    foreach($transaction_items_serial_numbers as $transaction_items_serial_number){
                        $transaction_items_serial_number->delete();
                    }
                }

                foreach($transaction_items as $transaction_item){
                    $transaction_item->delete();
                }
            }

            $transaction->delete();

            Flash::success(trans('application.record_deleted'));
            return redirect('transactions');
        }
	}

  /**
   * Display a listing of the transactions.
   *
   * @return Response
   */
  public function listTransactions()
  {
        if (Request::ajax()){
            $transactions = Transaction::with(['transactiontypes', 'courier'])
                            ->select('uuid','transaction_types_id', 'type_contact', 'contacts_id', 'couriers_id', 'tracking_number', 'transaction_types_in', 'number_types_in', 'bol', 'batch_number', 'package_list', 'user_id', 'quantity', 'notes', 'date', 'transaction_number' )->ordered();

            return Datatables::of($transactions)
                ->editColumn('date', function($data){ return date('m-d-Y', strtotime($data->date)); })
                ->editColumn('transaction_types_id', function($data){ return $data->transaction_types_id ? $data->transactiontypes->name : ''; })
                ->editColumn('couriers_id', function($data){ return $data->couriers_id ? $data->courier->name : ''; })
                ->editColumn('type_contact', function($data){ return $data->type_contact==0 ? 'Client' : 'Vendor'; })
                ->editColumn('transaction_types_in', function($data){ 
                            if ($data->transactiontypes->type == 'in'){
                                if ($data->transaction_types_in == 0){
                                    return 'Purchase';
                                }else{
                                    return 'RMA';
                                } 
                            } elseif ($data->transactiontypes->type == 'out'){
                                if ($data->transaction_types_in == 0){
                                    return 'Sales';
                                }elseif ($data->transaction_types_in == 1){
                                    return 'Loan';
                                }elseif ($data->transaction_types_in == 2){
                                    return 'RMA OUT';
                                }
                            } 
                        }
                    )
                ->addColumn('action', '
                     {!! show_btn(\'inventory.show\', $uuid) !!}
                     {!! edit_transaction_btn(\'inventory.edit\', $uuid) !!}
                     {!! print_btn(\'transaction.print\', $uuid) !!}
                     {!! delete_btn(\'inventory.destroy\', $uuid) !!}

                ')
                ->make(true);
/*  */
        }else {
            return view('inventory.transactions');
        }
  }

  public function show($uuid)
	{
    $transaction = Transaction::with('users', 'transactiontypes', 'courier', 'transactionItems')
                    ->find($uuid);

    if ($transaction->type_contact == 0){
      //  Client
      $contact = Client::find($transaction->contacts_id);
    }else{
      //  Vendor/Supplier
      $contact = Vendor::find($transaction->contacts_id);
    }
    $serialNumbers[] = "";
    $countSerialNumbers[] = "";
    foreach($transaction->transactionItems as $transactionItem){
        $transactionItemId = TransactionItemsSerialNumbers::select('transaction_item_id')->where('transaction_item_id', $transactionItem->uuid)->get();
        
        if ($transactionItemId->count() >0){
            $serialNumbers[] = $transactionItem->uuid;  
            $countSerialNumbers[$transactionItem->uuid] = $transactionItemId->count();
        }   
    }

    if($transaction){
        return view('inventory.transactions_show', compact('transaction', 'contact', 'serialNumbers', 'countSerialNumbers'));
    }
    return redirect('transactions');
	}

  public function printTransaction($uuid)
  {
    unset($pdf);
    $transaction = Transaction::with('users', 'transactiontypes', 'courier', 'transactionItems')
                    ->find($uuid);

    if ($transaction->type_contact == 0){
      //  Client
      $contact = Client::find($transaction->contacts_id);
    }else{
      //  Vendor/Supplier
      $contact = Vendor::find($transaction->contacts_id);
    }
    
    $name = 'check_'.trim($transaction->transactiontypes->name).'_transaction_'.$transaction->created_at.'.pdf';

    if($transaction){
        $pdf = \PDF::loadView('inventory.transaction_pdf', compact('transaction', 'contact'));
        return $pdf->download($name);
    }

  }

  /**
   * @return \Symfony\Component\HttpFoundation\Response
   */
  public function save_serial_number(){

      $serial_number = \Request::get('serial_number');
      $transaction_item_id = \Request::get('transaction_item_id');
      $transaction_id = \Request::get('transaction_id');
      $product_id = \Request::get('product_id');
      $quantity = \Request::get('quantity');
      if ($serial_number !=""){
          //  Save Transaction
          $TransactionItemsSerialNumbers = new TransactionItemsSerialNumbers;
          $TransactionItemsSerialNumbers->transaction_id = $transaction_id;
          $TransactionItemsSerialNumbers->transaction_item_id = $transaction_item_id;
          $TransactionItemsSerialNumbers->product_id = $product_id;
          $TransactionItemsSerialNumbers->serial_number = $serial_number;
          if ($TransactionItemsSerialNumbers->save()){
          }
      }

      return Response::json(array('success'=>true), 200);
  }

  /**
   * @return \Symfony\Component\HttpFoundation\Response
   */
  public function delete_serial_number(){

    $transaction_items_serial_numbers_id = \Request::get('transaction_items_serial_numbers_id');
    if ($transaction_items_serial_numbers_id !=""){
        //  Delete Transaction Item Serial Number
        $TransactionItemsSerialNumbers = TransactionItemsSerialNumbers::find($transaction_items_serial_numbers_id);
        if (isset($TransactionItemsSerialNumbers)){
            if ($TransactionItemsSerialNumbers->delete()){
                return Response::json(array('success'=>true), 200);
            }else{
                return Response::json(array('success'=>false), 405);
            }
        }
    }
  }

  /**
   * @return \Symfony\Component\HttpFoundation\Response
   */
   public function  save_secuencial_serial_number(){

        $serial_number_initial = \Request::get('serial_number_initial');
        $serial_number_final = \Request::get('serial_number_final');
        $transaction_item_id = \Request::get('transaction_item_id');
        $transaction_id = \Request::get('transaction_id');
        $product_id = \Request::get('product_id');
        $quantity = \Request::get('quantity');
        
        if ($serial_number_initial !="" && $serial_number_final !=""){
             for ($i=$serial_number_initial; $i <= $serial_number_final; $i++) { 
                 //  Save Transaction
                    $TransactionItemsSerialNumbers = new TransactionItemsSerialNumbers;
                    $TransactionItemsSerialNumbers->transaction_id = $transaction_id;
                    $TransactionItemsSerialNumbers->transaction_item_id = $transaction_item_id;
                    $TransactionItemsSerialNumbers->product_id = $product_id;
                    $TransactionItemsSerialNumbers->serial_number = $i;
                    if ($TransactionItemsSerialNumbers->save()){
                    } 
             }
        }

        return Response::json(array('success'=>true), 200);
    }
 
    public function checkQuantityProduct(){
        $productId = \Request::get('productId');
        $product = $this->product->getById($productId);
        if (isset($product)){
            if ($product->quantity >0){
                return Response::json(array('success'=>true), 200);
            }else{
                return Response::json(array('success'=>false), 405);
            }
        }else{
            return Response::json(array('success'=>false), 405);
        }

    }
  
}

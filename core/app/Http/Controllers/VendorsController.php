<?php namespace Inventory\Http\Controllers;
use Inventory\Http\Requests;
use Inventory\Http\Requests\VendorFormRequest;
use Inventory\Invoicer\Repositories\Contracts\VendorInterface as Vendor;
//use Inventory\Models\Vendor;
use Inventory\Invoicer\Repositories\Contracts\InvoiceInterface as Invoice;
use Inventory\Invoicer\Repositories\Contracts\EstimateInterface as Estimate;
use Inventory\Invoicer\Repositories\Contracts\NumberSettingInterface as Number;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Laracasts\Flash\Flash;
use Yajra\Datatables\Facades\Datatables;

class VendorsController extends Controller
{
    private $vendor, $invoice, $estimate, $number;
    public function __construct(Vendor $vendor, Invoice $invoice, Estimate $estimate, Number $number){
        $this->vendor = $vendor;
        $this->invoice = $invoice;
        $this->estimate = $estimate;
        $this->number = $number;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Request::ajax()) {
            $model = $this->vendor->model();
            $vendors = $model::select('vendor_no','name','email','phone','country','photo','uuid')->ordered();
            return Datatables::of($vendors)
                ->editColumn('photo', '<img src="{{ asset($photo != "" ? "assets/img/uploads/client_images/".$photo : "assets/img/uploads/no-image.jpg" ) }}" class="img-circle" width="36px"/>')
                ->addColumn('action', '
                     {!! show_btn(\'vendors.show\', $uuid) !!}
                     @if(hasPermission(\'edit_client\')) {!! edit_btn(\'vendors.edit\', $uuid) !!}@endif
                     @if(hasPermission(\'delete_client\')) {!! delete_btn(\'vendors.destroy\', $uuid) !!}@endif
                ')->make(true);
        }else {
            return view('vendors.index');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        if(!hasPermission('add_client', true)) return redirect('vendors');
        $client_num = $this->number->prefix('client_number', $this->vendor->generateClientNum());
        //DD($client_num);
        return view('vendors.create', compact('client_num'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VendorFormRequest $request)
    {
        $data = array('vendor_no' => $request->vendor_no,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'mobile' => $request->mobile,
            'address1' => $request->address1,
            'address2' => $request->address2,
            'city' => $request->city,
            'state' => $request->state,
            'country' => $request->country,
            'postal_code' => $request->postal_code,
            'website' => $request->website,
            'contact_person' => $request->contact_person,
            'notes' => $request->notes

        );

        //DD($data);

        $vendor = $this->vendor->create($data);
        if($vendor){
            if($request->ajaxNonReload){
                return Response::json(array('value' => $vendor->uuid->string, 'text' => $vendor->name), 200);
            }else {
                Flash::success(trans('application.record_created'));
                return Response::json(array('success' => true, 'msg' => trans('application.record_created')), 200);
            }
        }
        return Response::json(array('success' => false, 'msg' => trans('application.record_creation_failed')), 422);


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($uuid)
    {
        $vendor = $this->vendor->getById($uuid);
        if($vendor){
            /*
            foreach($vendor->invoices as $count => $invoice){
                $vendor->invoices[$count]['totals'] = $this->invoice->invoiceTotals($invoice->uuid);
            }
            foreach($vendor->estimates as $count => $estimate){
                $vendor->estimates[$count]['totals'] = $this->estimate->estimateTotals($estimate->uuid);

            }

            */
            return view('vendors.show', compact('vendor'));
        }
        return redirect('vendors');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($uuid)
    {

        if(!hasPermission('edit_client', true)) return redirect('vendors');
        $vendor = $this->vendor->getById($uuid);
        if($vendor)
            return view('vendors.edit',  compact('vendor'));
        else
            return redirect('vendors');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(VendorFormRequest $request, $uuid)
    {


        $data = array('vendor_no' => $request->vendor_no,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'mobile' => $request->mobile,
            'address1' => $request->address1,
            'address2' => $request->address2,
            'city' => $request->city,
            'state' => $request->state,
            'country' => $request->country,
            'postal_code' => $request->postal_code,
            'website' => $request->website,
            'contact_person' => $request->contact_person,
            'notes' => $request->notes

        );

        if($this->vendor->updateById($uuid,$data)){
            Flash::success(trans('application.record_updated'));
            return Response::json(array('success' => true, 'msg' => trans('application.record_updated')), 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($uuid)
    {
        if(!hasPermission('delete_client', true)) return redirect('vendors');
        $this->vendor->deleteById($uuid);
        Flash::success(trans('application.record_deleted'));
        return redirect('vendors');
    }
}

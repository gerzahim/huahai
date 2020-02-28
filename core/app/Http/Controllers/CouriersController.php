<?php

namespace Inventory\Http\Controllers;

use Illuminate\Http\Request;
use Inventory\Http\Controllers\Controller;
use Inventory\Http\Requests\CourierRequest;
use Inventory\Invoicer\Repositories\Contracts\CourierInterface as Courier;
use Illuminate\Support\Facades\Response;
use Laracasts\Flash\Flash;

class CouriersController extends Controller
{
    private $courier;
    public function __construct(Courier $courier){
      $this->courier = $courier;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $couriers = $this->courier->all();
        return view('couriers.index', compact('couriers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('couriers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CourierRequest $request)
    {
      $data = array(
          'name' => $request->get('name')
      );
      if($this->courier->create($data)){
          Flash::success(trans('application.record_created'));
          return Response::json(array('success'=>true, 'msg' => trans('application.record_created')), 200);
      }
      return Response::json(array('success'=>false, 'msg' => trans('application.record_creation_failed')), 422);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $courier = $this->courier->getById($id);
      return view('couriers.edit', compact('courier'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CourierRequest $request, $id)
    {
      $data = array(
          'name' => $request->get('name')
      );
      if($this->courier->updateById($id,$data)){
          Flash::success(trans('application.record_updated'));
          return Response::json(array('success'=>true, 'msg' => trans('application.record_updated')), 200);
      }
      return Response::json(array('success'=>false, 'msg' =>  trans('application.record_update_failed')), 422);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      if($this->courier->deleteById($id)){
          Flash::success(trans('application.record_deleted'));
      }
      else {
          Flash::error(trans('application.record_deletion_failed'));
      }
      return redirect('couriers');
    }
}

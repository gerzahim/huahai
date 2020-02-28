<?php namespace Inventory\Invoicer\Repositories\Eloquent;
use Inventory\Invoicer\Repositories\Contracts\CourierInterface;
class CourierRepository extends BaseRepository implements CourierInterface{
    public function model() {
        return 'Inventory\Models\Courier';
    }
    public function courierSelect(){
        $couriers = $this->all();
        $courierList = array();
        foreach($couriers as $courier)
        {
            $courierList[$courier->uuid] = $courier->name;
        }
        return $courierList;
    }
}

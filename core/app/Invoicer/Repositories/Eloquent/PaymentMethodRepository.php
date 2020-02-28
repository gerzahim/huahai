<?php namespace Inventory\Invoicer\Repositories\Eloquent;

use Inventory\Invoicer\Repositories\Contracts\PaymentMethodInterface;

class PaymentMethodRepository extends BaseRepository implements PaymentMethodInterface{

    public function model() {
        return 'Inventory\Models\PaymentMethod';
    }

    public function resetDefault(){
    	$method  = new $this->model();
        $method->update(['selected' => 0]);
    }

    /**
     * @return array
     */
    public function paymentMethodSelect(){
        $model = $this->model();
        $methods = $model::orderBy('selected', 'desc')->get();
        $methodList = array();
        foreach($methods as $method)
        {
            $methodList[$method->uuid] = $method->name;
        }
        return $methodList;
    }
}
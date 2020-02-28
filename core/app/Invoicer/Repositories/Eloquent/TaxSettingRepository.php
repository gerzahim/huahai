<?php namespace Inventory\Invoicer\Repositories\Eloquent;

use Inventory\Invoicer\Repositories\Contracts\TaxSettingInterface;

class TaxSettingRepository extends BaseRepository implements TaxSettingInterface{
    public function model() {
        return 'Inventory\Models\TaxSetting';
    }
    public function resetDefault(){
    	$tax  = $this->model();
    	$tax::where('selected',1)->update(['selected' => 0]);
    }
    /**
     * @return array
     */
    public function taxSelect(){
        $taxes = $this->all();
        $select = array();
        $options = array();
        $default = null;
        $options[] = ['value' => '', 'display' => 'None', 'data-value' => '' ];
        foreach($taxes as $tax){
            $option = ['value' => $tax->uuid, 'display' => $tax->name, 'data-value' => $tax->value ];
            array_push($options, $option);
            if($tax->selected == 1){
                $default = $tax->uuid;
            }
        }
        $select['options'] = $options;
        $select['default'] = $default;
        return $select;
    }
}
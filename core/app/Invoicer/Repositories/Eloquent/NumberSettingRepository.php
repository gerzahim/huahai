<?php namespace Inventory\Invoicer\Repositories\Eloquent;

use Inventory\Invoicer\Repositories\Contracts\NumberSettingInterface;

class NumberSettingRepository extends BaseRepository implements NumberSettingInterface{

    public function model() {
        return 'Inventory\Models\NumberSetting';
    }

    public function prefix($type, $num){
        $prefix = $this->first();
        if($prefix){
            return $prefix->$type.$num;
        }
        return $num;
    }
}
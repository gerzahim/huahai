<?php namespace Inventory\Invoicer\Repositories\Eloquent;

use Inventory\Invoicer\Repositories\Contracts\EstimateSettingInterface;

class EstimateSettingRepository extends BaseRepository implements EstimateSettingInterface{

    public function model() {
        return 'Inventory\Models\EstimateSetting';
    }
}
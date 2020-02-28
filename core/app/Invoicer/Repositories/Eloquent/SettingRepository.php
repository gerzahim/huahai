<?php namespace Inventory\Invoicer\Repositories\Eloquent;

use Inventory\Invoicer\Repositories\Contracts\SettingInterface;

class SettingRepository extends BaseRepository implements SettingInterface{

    public function model() {
        return 'Inventory\Models\Setting';
    }
}
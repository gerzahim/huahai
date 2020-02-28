<?php namespace Inventory\Invoicer\Repositories\Eloquent;

use Inventory\Invoicer\Repositories\Contracts\EmailSettingInterface;

class EmailSettingRepository extends BaseRepository implements EmailSettingInterface{

    public function model() {
        return 'Inventory\Models\EmailSetting';
    }
}
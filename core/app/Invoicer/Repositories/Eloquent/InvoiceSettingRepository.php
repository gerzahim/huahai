<?php namespace Inventory\Invoicer\Repositories\Eloquent;

use Inventory\Invoicer\Repositories\Contracts\InvoiceSettingInterface;

class InvoiceSettingRepository extends BaseRepository implements InvoiceSettingInterface{

    public function model() {
        return 'Inventory\Models\InvoiceSetting';
    }
}
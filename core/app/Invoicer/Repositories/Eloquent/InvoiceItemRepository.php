<?php namespace Inventory\Invoicer\Repositories\Eloquent;

use Inventory\Invoicer\Repositories\Contracts\InvoiceItemInterface;

class InvoiceItemRepository extends BaseRepository implements InvoiceItemInterface{

    public function model() {
        return 'Inventory\Models\InvoiceItem';
    }
}
<?php namespace Inventory\Invoicer\Repositories\Eloquent;

use Inventory\Invoicer\Repositories\Contracts\EstimateItemInterface;

class EstimateItemRepository extends BaseRepository implements EstimateItemInterface{

    public function model() {
        return 'Inventory\Models\EstimateItem';
    }
}
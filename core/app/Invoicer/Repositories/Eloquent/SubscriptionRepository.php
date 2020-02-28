<?php namespace Inventory\Invoicer\Repositories\Eloquent;

use Inventory\Invoicer\Repositories\Contracts\SubscriptionInterface;

class SubscriptionRepository extends BaseRepository implements SubscriptionInterface{

    public function model() {
        return 'Inventory\Models\Subscription';
    }
}
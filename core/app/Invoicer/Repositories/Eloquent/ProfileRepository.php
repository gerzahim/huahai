<?php namespace Inventory\Invoicer\Repositories\Eloquent;

use Inventory\Invoicer\Repositories\Contracts\ProfileInterface;

class ProfileRepository extends BaseRepository implements ProfileInterface{

    public function model() {
        return 'Inventory\Models\User';
    }
}
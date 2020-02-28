<?php namespace Inventory\Invoicer\Repositories\Eloquent;

use Inventory\Invoicer\Repositories\Contracts\UserInterface;

class UserRepository extends BaseRepository implements UserInterface{

    public function model() {
        return 'Inventory\Models\User';
    }
}
<?php namespace Inventory\Invoicer\Repositories\Eloquent;

use Inventory\Invoicer\Repositories\Contracts\RoleInterface;

class RoleRepository extends BaseRepository implements RoleInterface{

    public function model() {
        return 'Inventory\Models\Role';
    }
}
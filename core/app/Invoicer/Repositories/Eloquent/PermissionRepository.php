<?php namespace Inventory\Invoicer\Repositories\Eloquent;

use Inventory\Invoicer\Repositories\Contracts\PermissionInterface;

class PermissionRepository extends BaseRepository implements PermissionInterface{

    public function model() {
        return 'Inventory\Models\Permission';
    }
}
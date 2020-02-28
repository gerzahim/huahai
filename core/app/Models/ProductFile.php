<?php

namespace Inventory\Models;

use Illuminate\Database\Eloquent\Model;
use Inventory\Traits\UuidModel;

class ProductFile extends Model
{
    use UuidModel;
    public $incrementing = false;
    protected $fillable = ['product_id', 'filename'];
    protected $table = 'product_files';
    protected $primaryKey = 'uuid';

    public function products(){
        return $this->hasMany('Inventory\Models\Product');
    }
}

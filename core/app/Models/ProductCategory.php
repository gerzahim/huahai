<?php namespace Inventory\Models;
use Illuminate\Database\Eloquent\Model;
use Inventory\Traits\UuidModel;
class ProductCategory extends Model
{
    use UuidModel;
    public $incrementing = false;
    protected $fillable = ['name'];
    protected $primaryKey = 'uuid';

    public function products(){
        return $this->hasMany('Inventory\Models\Product');
    }
}

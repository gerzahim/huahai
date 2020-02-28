<?php namespace Inventory\Models;
use Illuminate\Database\Eloquent\Model;
use Inventory\Traits\UuidModel;

class Inventory extends Model {
    use UuidModel;
    public $incrementing = false;
    protected $primaryKey = 'uuid';
    protected $fillable =  ['name', 'code', 'model', 'category_id', 'price', 'quantity', 'description','image'];    

    public function category(){
        return $this->belongsTo('Inventory\Models\ProductCategory');
    }
    public function scopeOrdered($query){
        return $query->orderBy('created_at', 'desc')->get();
    }
}

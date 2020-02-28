<?php namespace Inventory\Models;
use Illuminate\Database\Eloquent\Model;
use Inventory\Traits\UuidModel;
class Estimate extends Model {
    use UuidModel;
    public $incrementing = false;
    protected $primaryKey = 'uuid';
    protected  $fillable = ['client_id','estimate_no','estimate_date','currency','notes','terms'];

    public function client(){
        return $this->belongsTo('Inventory\Models\Client');
    }
    public function items(){
        return $this->hasMany('Inventory\Models\EstimateItem');
    }
    public function scopeOrdered($query){
        return $query->orderBy('created_at', 'desc')->get();
    }
}
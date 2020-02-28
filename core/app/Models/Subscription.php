<?php namespace Inventory\Models;

use Illuminate\Database\Eloquent\Model;
use Inventory\Traits\UuidModel;
class Subscription extends Model {
    use UuidModel;
    public $incrementing = false;
    protected $primaryKey = 'uuid';
	protected $fillable = ['invoice_id','billingcycle','nextduedate','status'];
    public function invoice(){
        return $this->belongsTo('Inventory\Models\Invoice');
    }
    public function scopeOrdered($query){
        return $query->orderBy('created_at', 'desc')->get();
    }
}

<?php namespace Inventory\Models;
use Illuminate\Database\Eloquent\Model;
use Inventory\Traits\UuidModel;
class PaymentMethod extends Model{
    use UuidModel;
    public $incrementing = false;

    protected $primaryKey = 'uuid';
    protected  $fillable = ['name','selected'];
    public function payments(){
        return $this->hasMany('Inventory\Models\Payment','method');
    }
}

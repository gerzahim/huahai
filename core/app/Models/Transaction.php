<?php namespace Inventory\Models;
use Illuminate\Database\Eloquent\Model;
use Inventory\Traits\UuidModel;

class Transaction extends Model
{
    use UuidModel;
    public $incrementing = false;
    protected $primaryKey = 'uuid';
    protected $fillable =  ['date', 'transactions_items', 'transaction_types_id', 'type_contact', 'contacts_id', 'couriers_id', 'tracking_number', 'transaction_types_in', 'number_types_in', 'bol', 'batch_number', 'package_list', 'user_id','quantity','notes'];

    public function category(){
        return $this->belongsTo('Inventory\Models\ProductCategory');
    }
    public function scopeOrdered($query){
        return $query->orderBy('created_at', 'desc')->get();
    }

    public function products(){
        return $this->hasMany('Inventory\Models\Product');
    }

    public function users()
    {
        return $this->belongsTo('Inventory\Models\User', 'user_id', 'uuid');
        //return $this->hasMany(User::class, 'role_id', 'uuid');
    }

     public function transactiontypes(){
         return $this->belongsTo('Inventory\Models\TransactionType', 'transaction_types_id', 'uuid');
     }
    public function courier(){
        return $this->belongsTo('Inventory\Models\Courier', 'couriers_id', 'uuid');
    }

    public function transactionItems(){
        return $this->hasMany('Inventory\Models\TransactionItem', 'transaction_id', 'uuid');
    }
}

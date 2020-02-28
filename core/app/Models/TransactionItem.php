<?php

namespace Inventory\Models;

use Illuminate\Database\Eloquent\Model;
use Inventory\Traits\UuidModel;

class TransactionItem extends Model
{
  use UuidModel;
  public $incrementing = false;
  protected $primaryKey = 'uuid';
  protected $fillable =  ['transaction_id', 'product_id', 'quantity'];

  public function product(){
      return $this->belongsTo('Inventory\Models\Product');
  }
  public function scopeOrdered($query){
      return $query->orderBy('created_at', 'desc')->get();
  }

  public function transaction()
  {
      return $this->belongsTo('Inventory\Models\Transaction');
  }
  
  public function serialNumbers(){
    return $this->hasMany('Inventory\Models\TransactionItemsSerialNumbers', 'transaction_item_id', 'uuid');    
  }

}

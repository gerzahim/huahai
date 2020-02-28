<?php

namespace Inventory\Models;

use Illuminate\Database\Eloquent\Model;
use Inventory\Traits\UuidModel;

class TransactionItemsSerialNumbers extends Model
{
  use UuidModel;
  public $incrementing = false;
  protected $primaryKey = 'uuid';
  protected $fillable =  ['transaction_id', 'transaction_item_id', 'product_id', 'serial_number'];

}

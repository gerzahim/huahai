<?php namespace Inventory\Models;
use Illuminate\Database\Eloquent\Model;
use Inventory\Traits\UuidModel;

class TransactionType extends Model
{
    use UuidModel;
    public $incrementing = false;
    protected $primaryKey = 'uuid';

    protected $fillable = ['type', 'name', 'description'];

}

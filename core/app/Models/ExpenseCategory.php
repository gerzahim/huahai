<?php namespace Inventory\Models;
use Illuminate\Database\Eloquent\Model;
use Inventory\Traits\UuidModel;
class ExpenseCategory extends Model
{
    use UuidModel;
    public $incrementing = false;
    protected $fillable = ['name'];
    protected $primaryKey = 'uuid';

    public function expenses(){
        return $this->hasMany('Inventory\Models\Expense');
    }
}

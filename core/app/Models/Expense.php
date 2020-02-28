<?php namespace Inventory\Models;
use Illuminate\Database\Eloquent\Model;
use Inventory\Traits\UuidModel;
class Expense extends Model {
    use UuidModel;
    public $incrementing = false;
    protected $primaryKey = 'uuid';

    protected $fillable = ['name', 'vendor','category_id','amount', 'notes', 'expense_date','currency'];

    public function category(){
        return $this->belongsTo('Inventory\Models\ExpenseCategory');
    }
    public function scopeOrdered($query){
        return $query->orderBy('created_at', 'desc')->get();
    }
}

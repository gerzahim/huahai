<?php namespace Inventory\Models;
use Illuminate\Database\Eloquent\Model;
use Inventory\Traits\UuidModel;
class TaxSetting extends Model {
    use UuidModel;
    public $incrementing = false;
    protected $primaryKey = 'uuid';

    protected $fillable = ['name', 'value', 'selected'];
    public function estimateItems(){
        return $this->hasMany('Inventory\Models\EstimateItem');
    }
}
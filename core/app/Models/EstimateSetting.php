<?php namespace Inventory\Models;
use Illuminate\Database\Eloquent\Model;
use Inventory\Traits\UuidModel;
class EstimateSetting extends Model {
    use UuidModel;
    public $incrementing = false;
    protected $primaryKey = 'uuid';
    protected $fillable = ['start_number', 'terms', 'logo'];
}

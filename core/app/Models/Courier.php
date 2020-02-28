<?php namespace Inventory\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Inventory\Traits\UuidModel;
use Illuminate\Notifications\Notifiable;
class Courier extends Model
{
    use UuidModel;
    use Notifiable;
    public $incrementing = false;
    protected $fillable = ['name'];
    protected $primaryKey = 'uuid';

    public function scopeOrdered($query){
        return $query->orderBy('created_at', 'desc')->get();
    }
}

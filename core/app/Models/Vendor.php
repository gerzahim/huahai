<?php namespace Inventory\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Inventory\Traits\UuidModel;
use Illuminate\Notifications\Notifiable;
class Vendor extends Model
{
    use UuidModel;
    use Notifiable;
    public $incrementing = false;
    protected $fillable = ['vendor_no', 'name', 'email', 'address1', 'address2', 'city', 'state', 'postal_code', 'country', 'phone', 'mobile', 'website', 'notes','photo', 'contact_person'];
    /**
     * Main table primary key
     * @var string
     */
    protected $primaryKey = 'uuid';
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function invoices(){
        return $this->hasMany('Inventory\Models\Invoice');
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function estimates(){
        return $this->hasMany('Inventory\Models\Estimate');
    }
    public function sendPasswordResetNotification($token){
        $this->notify(new ClientResetPassword($token));
    }
    public function scopeOrdered($query){
        return $query->orderBy('created_at', 'desc')->get();
    }
}
